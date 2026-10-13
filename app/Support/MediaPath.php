<?php

namespace App\Support;

final class MediaPath
{
    /** Return only existing files physically contained within the expected public directory. */
    public static function resolve(string $path, string $directory, ?string $basePath = null): ?string
    {
        $parsed = parse_url($path, PHP_URL_PATH);
        if (!is_string($parsed)) {
            return null;
        }

        $relative = ltrim($parsed, '/');
        if (!str_starts_with($relative, $directory . '/')) {
            return null;
        }

        // Reject traversal even when normalization would appear to remain inside the folder.
        if (in_array('..', explode('/', $relative), true) || in_array('.', explode('/', $relative), true)) {
            return null;
        }

        $basePath ??= public_path();
        $root = realpath($basePath . '/' . $directory);
        $file = realpath($basePath . '/' . $relative);

        return $root !== false && $file !== false && str_starts_with($file, $root . DIRECTORY_SEPARATOR) && is_file($file)
            ? $file
            : null;
    }
}
