<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Rules\OptimizedImage;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hasUpload = $this->hasFile('thumbnail') || $this->file('thumbnail') !== null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'thumbnail' => $hasUpload
                ? [new OptimizedImage]
                : ['nullable', 'string', 'max:255'],
            'thumbnail_url' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image_placement' => ['nullable', 'string', 'in:hero,content'],
            'tags' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'thumbnail.uploaded' => 'Berkas gambar thumbnail gagal diunggah atau melebihi batas ukuran server (maksimal 20 MB).',
        ];
    }
}
