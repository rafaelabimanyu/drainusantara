<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_role_or_location' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
            'service_id' => ['nullable', 'exists:services,id'],
            'is_active' => ['nullable', 'boolean'],
            'avatar' => $this->hasFile('avatar')
                ? ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120']
                : ['nullable'],
            'avatar_url' => ['nullable', 'string', 'max:255'],
        ];
    }
}
