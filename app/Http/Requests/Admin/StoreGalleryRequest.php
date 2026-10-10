<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'in:rumahan,b2b'],
            'service_id' => ['nullable', 'exists:services,id'],
            'before_image' => $this->hasFile('before_image')
                ? ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']
                : ['nullable'],
            'before_image_url' => ['nullable', 'string', 'max:500'],
            'after_image' => $this->hasFile('after_image')
                ? ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']
                : ['nullable'],
            'after_image_url' => ['nullable', 'string', 'max:500'],
            'image' => $this->hasFile('image')
                ? ['image', 'mimes:jpeg,png,jpg,webp,svg,gif', 'max:20480']
                : ['nullable'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
