<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\CoverageArea;
use App\Services\AreaImageResolver;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ConvertAreaImagesToWebpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'areas:convert-webp {--quality=82 : WebP compression quality (0-100)} {--keep-original : Keep original jpg/png files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert all JPG and PNG area images in public/images/areas to WebP format and clean up originals';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $quality = (int) $this->option('quality');
        $keepOriginal = (bool) $this->option('keep-original');
        $targetDir = public_path('images/areas');

        if (! is_dir($targetDir)) {
            $this->error("Directory not found: {$targetDir}");

            return self::FAILURE;
        }

        $this->info("Scanning images in {$targetDir}...");

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($targetDir, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $converted = 0;
        $failed = 0;
        $savedBytes = 0;

        foreach ($iterator as $fileInfo) {
            if (! $fileInfo->isFile()) {
                continue;
            }

            $ext = strtolower($fileInfo->getExtension());
            if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                continue;
            }

            $sourcePath = $fileInfo->getRealPath();
            $dir = dirname($sourcePath);
            $filename = pathinfo($sourcePath, PATHINFO_FILENAME);
            $webpPath = $dir . DIRECTORY_SEPARATOR . $filename . '.webp';

            $originalSize = filesize($sourcePath);

            $im = match ($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($sourcePath),
                'png' => @imagecreatefrompng($sourcePath),
                default => false,
            };

            if (! $im) {
                $this->warn("Failed to read image: {$sourcePath}");
                $failed++;
                continue;
            }

            if ($ext === 'png') {
                imagepalettetotruecolor($im);
                imagealphablending($im, true);
                imagesavealpha($im, true);
            }

            $success = @imagewebp($im, $webpPath, $quality);
            imagedestroy($im);

            if ($success && file_exists($webpPath) && filesize($webpPath) > 0) {
                $newSize = filesize($webpPath);
                $diff = max(0, $originalSize - $newSize);
                $savedBytes += $diff;
                $converted++;

                if (! $keepOriginal) {
                    @unlink($sourcePath);
                }
            } else {
                $this->error("Failed to convert: {$sourcePath}");
                $failed++;
            }
        }

        $savedMb = round($savedBytes / (1024 * 1024), 2);
        $this->info("WebP Conversion Complete!");
        $this->table(
            ['Converted', 'Failed', 'Saved Storage (MB)', 'Originals Deleted'],
            [[$converted, $failed, "{$savedMb} MB", $keepOriginal ? 'NO' : 'YES']]
        );

        // Run sync to update coverage_areas table
        $this->info("Updating CoverageArea database records to .webp...");
        $this->call('areas:sync-images', ['--overwrite' => true]);

        return self::SUCCESS;
    }
}

