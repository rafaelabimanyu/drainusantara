<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use RuntimeException;

final class ImageOptimizer
{
    /**
     * Upload ceilings shared by the OptimizedImage rule and the optimizer itself.
     */
    public const MAX_BYTES = 20 * 1024 * 1024;

    public const MAX_SIDE = 12000;

    public const MAX_PIXELS = 20_000_000;

    public const MAX_TARGET_SIDE = 1920;

    /**
     * Pre-flight rejection message for an upload, or null when it can be processed.
     *
     * Single source of truth for what the CMS accepts, so form validation and the
     * optimizer never disagree about formats or limits.
     */
    public static function rejectionReason(UploadedFile $file): ?string
    {
        if (! $file->isValid() || $file->getSize() > self::MAX_BYTES) {
            return 'Gambar tidak valid atau melebihi 20 MB.';
        }
        $info = @getimagesize($file->getPathname());
        // ponytail: GD cannot preserve animation; accept only static JPEG, PNG and WebP.
        if (! $info || ! in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            return 'Gunakan gambar JPEG, PNG, atau WebP statis. GIF dan SVG tidak didukung.';
        }
        [$width, $height] = $info;
        if ($width < 1 || $height < 1 || max($width, $height) > self::MAX_SIDE || $width * $height > self::MAX_PIXELS) {
            return 'Gambar maksimal 20 megapiksel dan 12000 piksel per sisi.';
        }
        $ratio = min(1, self::MAX_TARGET_SIDE / max($width, $height));
        $targetWidth = max(1, (int) round($width * $ratio));
        $targetHeight = max(1, (int) round($height * $ratio));
        // GD keeps one truecolour buffer per image (4 bytes per pixel) plus the raw file bytes.
        $required = $width * $height * 4
            + $targetWidth * $targetHeight * 4
            + $file->getSize() * 2
            + 8 * 1024 * 1024;
        $limit = ini_parse_quantity(ini_get('memory_limit'));
        if ($limit > 0 && memory_get_usage(true) + $required > $limit) {
            return 'Resolusi gambar terlalu besar untuk diproses. Unggah gambar yang lebih kecil.';
        }

        return null;
    }

    /**
     * Decode, resize, orient, and encode an upload as WebP.
     *
     * @return resource stream positioned at the start of the encoded image
     */
    public static function webp(UploadedFile $file, string $field)
    {
        if (($reason = self::rejectionReason($file)) !== null) {
            throw ValidationException::withMessages([$field => $reason]);
        }
        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring') || ! (imagetypes() & IMG_WEBP)) {
            throw new RuntimeException('Optimasi gambar membutuhkan PHP GD dengan dukungan WebP.');
        }

        $info = @getimagesize($file->getPathname());
        [$width, $height] = $info;
        $contents = file_get_contents($file->getPathname());
        $orientation = $info[2] === IMAGETYPE_JPEG ? self::jpegOrientation($contents) : 1;
        if ($info[2] === IMAGETYPE_PNG) {
            for ($offset = 8, $length = strlen($contents); $offset + 12 <= $length;) {
                $chunkSize = unpack('N', substr($contents, $offset, 4))[1];
                if (substr($contents, $offset + 4, 4) === 'acTL') {
                    throw ValidationException::withMessages([$field => 'Gambar animasi tidak didukung. Gunakan gambar statis.']);
                }
                $offset += 12 + $chunkSize;
            }
        }
        $image = @imagecreatefromstring($contents);
        unset($contents);
        if ($image === false) {
            throw ValidationException::withMessages([$field => 'Gambar rusak atau animasi tidak didukung.']);
        }
        $ratio = min(1, self::MAX_TARGET_SIDE / max($width, $height));
        $targetWidth = max(1, (int) round($width * $ratio));
        $targetHeight = max(1, (int) round($height * $ratio));
        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        if (! imagecopyresampled($resized, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height)) {
            throw new RuntimeException('Gagal mengubah ukuran gambar.');
        }
        unset($image);
        if (in_array($orientation, [2, 4, 5, 7], true)) {
            imageflip($resized, $orientation === 4 ? IMG_FLIP_VERTICAL : IMG_FLIP_HORIZONTAL);
        }
        $angle = match ($orientation) {
            3 => 180,
            5, 8 => 90,
            6, 7 => -90,
            default => 0,
        };
        if ($angle !== 0) {
            $resized = imagerotate($resized, $angle, 0);
            if ($resized === false) {
                throw new RuntimeException('Gagal menyesuaikan orientasi gambar.');
            }
        }
        $stream = tmpfile();
        if ($stream === false) {
            throw new RuntimeException('Gagal menyiapkan optimasi gambar.');
        }
        try {
            if (! @imagewebp($resized, $stream, 82) || fstat($stream)['size'] === 0) {
                throw new RuntimeException('Gagal mengoptimalkan gambar.');
            }
            rewind($stream);

            return $stream;
        } catch (\Throwable $exception) {
            fclose($stream);
            throw $exception;
        }
    }

    /**
     * Read the EXIF orientation tag straight from the JPEG APP1 segment.
     *
     * ext-exif is optional on many PHP builds, so decode the tag ourselves:
     * a missing extension must not silently leave camera photos sideways.
     */
    private static function jpegOrientation(string $contents): int
    {
        $length = strlen($contents);
        if ($length < 4 || substr($contents, 0, 2) !== "\xFF\xD8") {
            return 1;
        }

        for ($offset = 2; $offset + 4 <= $length;) {
            if ($contents[$offset] !== "\xFF") {
                return 1;
            }
            $marker = ord($contents[$offset + 1]);
            if ($marker === 0xDA || $marker === 0xD9) {
                return 1;
            }
            $size = unpack('n', substr($contents, $offset + 2, 2))[1];
            if ($size < 2) {
                return 1;
            }
            if ($marker === 0xE1) {
                $segment = substr($contents, $offset + 4, $size - 2);
                if (str_starts_with($segment, "Exif\0\0")) {
                    return self::tiffOrientation(substr($segment, 6));
                }
            }
            $offset += 2 + $size;
        }

        return 1;
    }

    /**
     * Resolve tag 0x0112 (Orientation) from an EXIF TIFF block.
     */
    private static function tiffOrientation(string $tiff): int
    {
        $length = strlen($tiff);
        if ($length < 8) {
            return 1;
        }
        $byteOrder = substr($tiff, 0, 2);
        [$short, $long] = match ($byteOrder) {
            'II' => ['v', 'V'],
            'MM' => ['n', 'N'],
            default => [null, null],
        };
        if ($short === null || unpack($short, substr($tiff, 2, 2))[1] !== 42) {
            return 1;
        }

        $ifd = unpack($long, substr($tiff, 4, 4))[1];
        if ($ifd + 2 > $length) {
            return 1;
        }
        $entries = unpack($short, substr($tiff, $ifd, 2))[1];
        for ($index = 0; $index < $entries; $index++) {
            $entry = $ifd + 2 + $index * 12;
            if ($entry + 12 > $length) {
                return 1;
            }
            if (unpack($short, substr($tiff, $entry, 2))[1] !== 0x0112) {
                continue;
            }
            if (unpack($short, substr($tiff, $entry + 2, 2))[1] !== 3) {
                return 1;
            }
            $value = unpack($short, substr($tiff, $entry + 8, 2))[1];

            return $value >= 1 && $value <= 8 ? $value : 1;
        }

        return 1;
    }
}
