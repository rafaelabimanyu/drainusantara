<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use RuntimeException;

final class ImageOptimizer
{
    /** @return resource */
    public static function webp(UploadedFile $file, string $field)
    {
        $invalid = static fn (string $message) => ValidationException::withMessages([$field => $message]);
        if (! $file->isValid() || $file->getSize() > 20 * 1024 * 1024) {
            throw $invalid('Gambar tidak valid atau melebihi 20 MB.');
        }
        $info = @getimagesize($file->getPathname());
        // ponytail: GD cannot preserve animation; accept only static JPEG, PNG and WebP.
        if (! $info || ! in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            throw $invalid('Gunakan gambar JPEG, PNG, atau WebP statis. GIF dan SVG tidak didukung.');
        }
        [$width, $height] = $info;
        if ($width < 1 || $height < 1 || max($width, $height) > 12000 || $width * $height > 20000000) {
            throw $invalid('Gambar maksimal 20 megapiksel dan 12000 piksel per sisi.');
        }
        if (! function_exists('imagewebp') || ! function_exists('imagecreatefromstring') || ! (imagetypes() & IMG_WEBP)) {
            throw new RuntimeException('Optimasi gambar membutuhkan PHP GD dengan dukungan WebP.');
        }
        $limit = ini_parse_quantity(ini_get('memory_limit'));
        $required = $width * $height * 16 + $file->getSize() * 2 + 32 * 1024 * 1024;
        if ($limit > 0 && memory_get_usage(true) + $required > $limit) {
            throw $invalid('Resolusi gambar terlalu besar untuk diproses. Unggah gambar yang lebih kecil.');
        }
        $contents = file_get_contents($file->getPathname());
        if ($info[2] === IMAGETYPE_PNG) {
            for ($offset = 8, $length = strlen($contents); $offset + 12 <= $length;) {
                $chunkSize = unpack('N', substr($contents, $offset, 4))[1];
                if (substr($contents, $offset + 4, 4) === 'acTL') {
                    throw $invalid('Gambar animasi tidak didukung. Gunakan gambar statis.');
                }
                $offset += 12 + $chunkSize;
            }
        }
        $image = @imagecreatefromstring($contents);
        unset($contents);
        if ($image === false) {
            throw $invalid('Gambar rusak atau animasi tidak didukung.');
        }
        $ratio = min(1, 1920 / max($width, $height));
        $targetWidth = max(1, (int) round($width * $ratio));
        $targetHeight = max(1, (int) round($height * $ratio));
        $resized = imagecreatetruecolor($targetWidth, $targetHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        if (! imagecopyresampled($resized, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height)) {
            throw new RuntimeException('Gagal mengubah ukuran gambar.');
        }
        unset($image);
        if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $orientation = (int) (@exif_read_data($file->getPathname())['Orientation'] ?? 1);
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
}
