<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Rules\OptimizedImage;
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
            'category' => ['nullable', 'string', 'in:rumahan,fnb,gedung,perkantoran,pabrik,ruko,b2b'],
            'service_id' => ['nullable', 'exists:services,id'],
            'before_image' => ($this->hasFile('before_image') || $this->file('before_image') !== null)
                ? [new OptimizedImage]
                : ['nullable', 'string', 'max:255'],
            'before_image_url' => ['nullable', 'string', 'max:255'],
            'after_image' => ($this->hasFile('after_image') || $this->file('after_image') !== null)
                ? [new OptimizedImage]
                : ['nullable', 'string', 'max:255'],
            'after_image_url' => ['nullable', 'string', 'max:255'],
            'image' => ($this->hasFile('image') || $this->file('image') !== null)
                ? [new OptimizedImage]
                : ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'property_type' => ['nullable', 'array'],
            'property_type.*' => ['string', 'max:100'],
            'problem_type' => ['nullable', 'array'],
            'problem_type.*' => ['string', 'max:100'],
            'severity' => ['nullable', 'string', 'max:50'],
            'duration' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'integer', 'min:0'],
            'method' => ['nullable', 'string', 'max:255'],
            'drain_type' => ['nullable', 'string', 'max:255'],
            'diagnosis' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'equipment_ids' => ['nullable', 'array'],
            'equipment_ids.*' => ['exists:equipments,id'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
