<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageOptimizer
{
    /**
     * Optimize and store an uploaded image as an optimized WebP file.
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $targetDirectory,
        ?string $customFilename = null,
        int $maxWidth = 800,
        int $maxHeight = 500,
        int $quality = 82,
        bool $cropToAspect = false
    ): string {
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $baseName = $customFilename ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // Ensure webp extension
        $filename = time() . '_' . \Illuminate\Support\Str::slug($baseName) . '.webp';
        $destinationPath = rtrim($targetDirectory, '/\\') . DIRECTORY_SEPARATOR . $filename;

        self::processAndSave(
            file_get_contents($file->getRealPath()),
            $destinationPath,
            $maxWidth,
            $maxHeight,
            $quality,
            $cropToAspect
        );

        return $filename;
    }

    /**
     * Optimize an existing image file on disk in-place.
     */
    public static function optimizeFileInPlace(
        string $filePath,
        int $maxWidth = 800,
        int $maxHeight = 500,
        int $quality = 82,
        bool $cropToAspect = false
    ): bool {
        if (!file_exists($filePath)) {
            return false;
        }

        $rawContent = file_get_contents($filePath);
        if (empty($rawContent)) {
            return false;
        }

        return self::processAndSave(
            $rawContent,
            $filePath,
            $maxWidth,
            $maxHeight,
            $quality,
            $cropToAspect
        );
    }

    /**
     * Internal processing: resize, preserve alpha, compress to WebP.
     */
    protected static function processAndSave(
        string $rawBytes,
        string $outputPath,
        int $maxWidth,
        int $maxHeight,
        int $quality,
        bool $cropToAspect
    ): bool {
        if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
            file_put_contents($outputPath, $rawBytes);
            return true;
        }

        $srcImg = @imagecreatefromstring($rawBytes);
        if (!$srcImg) {
            file_put_contents($outputPath, $rawBytes);
            return false;
        }

        $origW = imagesx($srcImg);
        $origH = imagesy($srcImg);

        if ($origW <= 0 || $origH <= 0) {
            file_put_contents($outputPath, $rawBytes);
            return false;
        }

        if ($cropToAspect) {
            // Target exact aspect ratio ($maxWidth / $maxHeight)
            $targetRatio = $maxWidth / $maxHeight;
            $srcRatio = $origW / $origH;

            if ($srcRatio > $targetRatio) {
                $cropW = (int)($origH * $targetRatio);
                $cropH = $origH;
                $srcX = (int)(($origW - $cropW) / 2);
                $srcY = 0;
            } else {
                $cropW = $origW;
                $cropH = (int)($origW / $targetRatio);
                $srcX = 0;
                $srcY = (int)(($origH - $cropH) / 2);
            }

            $dstW = min($maxWidth, $cropW);
            $dstH = (int)($dstW / $targetRatio);

            $dstImg = imagecreatetruecolor($dstW, $dstH);
            imagealphablending($dstImg, false);
            imagesavealpha($dstImg, true);

            imagecopyresampled($dstImg, $srcImg, 0, 0, $srcX, $srcY, $dstW, $dstH, $cropW, $cropH);
        } else {
            // Fit within $maxWidth x $maxHeight preserving original aspect ratio
            $scale = min(1.0, min($maxWidth / $origW, $maxHeight / $origH));
            $dstW = max(1, (int)round($origW * $scale));
            $dstH = max(1, (int)round($origH * $scale));

            $dstImg = imagecreatetruecolor($dstW, $dstH);
            imagealphablending($dstImg, false);
            imagesavealpha($dstImg, true);

            imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $dstW, $dstH, $origW, $origH);
        }

        // Save to temporary file first, then replace atomically
        $tempPath = $outputPath . '.tmp.webp';
        $success = @imagewebp($dstImg, $tempPath, $quality);

        if ($success && file_exists($tempPath) && filesize($tempPath) > 0) {
            rename($tempPath, $outputPath);
            return true;
        }

        if (file_exists($tempPath)) {
            @unlink($tempPath);
        }

        return false;
    }
}
