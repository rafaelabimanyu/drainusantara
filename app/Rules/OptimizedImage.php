<?php

declare(strict_types=1);

namespace App\Rules;

use App\Support\ImageOptimizer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

/**
 * Accepts the same uploads the CMS can actually process.
 *
 * Controllers used to declare their own "image|mimes|max" chains, which drifted
 * (SVG and GIF passed validation but were rejected by the optimizer, and size
 * limits ranged from 5 MB to 20 MB). Every media field now uses this rule.
 */
final class OptimizedImage implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }
        if (! $value instanceof UploadedFile) {
            $fail('Berkas gambar tidak valid.');

            return;
        }
        $reason = ImageOptimizer::rejectionReason($value);
        if ($reason !== null) {
            $fail($reason);
        }
    }
}
