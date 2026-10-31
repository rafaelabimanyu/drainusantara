<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateGalleryRequest extends StoreGalleryRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $galleryId = $this->route('gallery')?->id ?? $this->route('gallery');
        $rules['slug'] = ['nullable', 'string', 'max:255', Rule::unique('galleries', 'slug')->ignore($galleryId)];

        return $rules;
    }
}
