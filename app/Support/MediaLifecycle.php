<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\{Article, Equipment, Gallery, Portfolio, Review, Service, Staff};
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

final class MediaLifecycle
{
    private const FIELDS = [
        Service::class => ['image'], Equipment::class => ['image'], Staff::class => ['photo'],
        Portfolio::class => ['image'], Gallery::class => ['image', 'before_image', 'after_image'],
        Article::class => ['thumbnail'], Review::class => ['avatar'],
    ];

    private const DIRECTORIES = [
        'images/services', 'assets/TOOLKIT', 'images/staff', 'images/portfolio',
        'images/dokumentasi', 'storage/articles', 'storage/reviews',
    ];

    private const DEFAULTS = [
        'images/services/wastafel-cuci-piring-mampet.webp',
        'images/services/kloset-wc-mampet.webp',
        'images/services/floor-drain-kamar-mandi.webp',
        'images/services/talang-rooftop-pipa-atap.webp',
        'images/services/kuras-grease-trap-lemak.webp',
        'images/services/inspeksi-kamera-cctv-pipa.webp',
        'images/portfolio/gacoan-mitra-kepercayaan-drainusantara-jasa-saluran-pipa-mampet.webp',
        'images/dokumentasi/pelancar-saluran-gutter-resto-jakarta.webp',
        'images/dokumentasi/pelancar-saluran-kloset-toilet-mampet.webp',
        'images/dokumentasi/pelancar-mesin-ridgid-floor-drain-kamar-mandi.webp',
        'images/dokumentasi/inspeksi-kamera-cctv-pipa-tersumbat.webp',
        'images/dokumentasi/pembersihan-grease-trap-restoran.webp',
        'images/dokumentasi/pelancar-bak-kontrol-perumahan-warga.webp',
        'assets/TOOLKIT/mesin-spiral-rotary.webp',
        'assets/TOOLKIT/kamera-cctv-pipa.webp',
        'assets/TOOLKIT/hydro-jetting.webp',
        'assets/TOOLKIT/cutter-mata-spiral.webp',
    ];

    private array $uploads = [];

    public function run(Model $model, Closure $write): void
    {
        $old = array_map(fn ($field) => $model->getRawOriginal($field), self::FIELDS[$model::class]);
        $connection = $model->getConnection();
        try {
            $connection->transaction(function () use ($write, $old, $connection): void {
                if ($write() === false) {
                    throw new RuntimeException('Media database write was cancelled.');
                }
                $connection->afterCommit(function () use ($old): void {
                    foreach (array_unique($old) as $path) {
                        $this->deleteUnused($path);
                    }
                });
            });
        } catch (Throwable $exception) {
            foreach ($this->uploads as $path) {
                $this->deleteUnused($path);
            }
            throw $exception;
        }
    }

    public function save(Model $model, array $attributes): void
    {
        if (! $model->fill($attributes)->save()) {
            throw new RuntimeException('Media database write was cancelled.');
        }
    }

    public function upload(UploadedFile $file, string $directory, bool $stored = false, string $field = 'image'): string
    {
        if (! in_array(($stored ? 'storage/' : '').$directory, self::DIRECTORIES, true)) {
            throw new RuntimeException('Invalid media directory.');
        }
        $stream = ImageOptimizer::webp($file, $field);
        $name = Str::uuid()->toString().'.webp';
        $path = '/'.($stored ? 'storage/' : '').$directory.'/'.$name;
        $this->uploads[] = $path;
        try {
            if ($stored) {
                if (! Storage::disk('public')->put($directory.'/'.$name, $stream)) {
                    throw new RuntimeException('Media upload failed.');
                }
            } else {
                $target = public_path($directory);
                if (! is_dir($target) && ! @mkdir($target, 0755, true) && ! is_dir($target)) {
                    throw new RuntimeException('Media upload directory could not be created.');
                }
                $output = @fopen($target.'/'.$name, 'xb');
                if ($output === false) {
                    throw new RuntimeException('Media upload failed.');
                }
                try {
                    if (stream_copy_to_stream($stream, $output) !== fstat($stream)['size']) {
                        throw new RuntimeException('Media upload failed.');
                    }
                } finally {
                    fclose($output);
                }
            }
        } catch (Throwable $exception) {
            $this->deleteUnused($path);
            throw new RuntimeException('Media upload failed.', 0, $exception);
        } finally {
            fclose($stream);
        }
        return $path;
    }

    private static function localPath(?string $url): ?string
    {
        if (! $url || str_contains($url, '\\') || str_contains($url, "\0")) {
            return null;
        }
        $parts = parse_url($url);
        if ($parts === false || isset($parts['user']) || isset($parts['pass'])) {
            return null;
        }
        if (isset($parts['scheme']) || isset($parts['host'])) {
            $origin = parse_url(config('app.url'));
            if (! isset($parts['scheme'], $parts['host'])
                || ! in_array($parts['scheme'], ['http', 'https'], true)
                || $parts['scheme'] !== ($origin['scheme'] ?? null)
                || $parts['host'] !== ($origin['host'] ?? null)
                || ($parts['port'] ?? null) !== ($origin['port'] ?? null)) {
                return null;
            }
        }
        $path = ltrim($parts['path'] ?? '', '/');
        if (str_contains($path, '%') || array_intersect(['.', '..'], explode('/', $path))) {
            return null;
        }
        return $path;
    }

    private function deleteUnused(?string $url): void
    {
        try {
            $path = self::localPath($url);
            if (! $path || in_array($path, self::DEFAULTS, true)) {
                return;
            }
            $directory = null;
            foreach (self::DIRECTORIES as $allowed) {
                if (str_starts_with($path, $allowed.'/')) {
                    $directory = $allowed;
                    break;
                }
            }
            if ($directory === null) {
                return;
            }
            foreach (self::FIELDS as $class => $fields) {
                foreach ($class::query()->select($fields)->cursor() as $record) {
                    foreach ($fields as $field) {
                        if (self::localPath($record->getRawOriginal($field)) === $path) {
                            return;
                        }
                    }
                }
            }
            $stored = str_starts_with($path, 'storage/');
            $file = MediaPath::resolve(
                $stored ? substr($path, 8) : $path,
                $stored ? substr($directory, 8) : $directory,
                $stored ? Storage::disk('public')->path('') : null,
            );
            if ($file !== null && ! unlink($file)) {
                throw new RuntimeException('Could not remove unused media: '.$path);
            }
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
