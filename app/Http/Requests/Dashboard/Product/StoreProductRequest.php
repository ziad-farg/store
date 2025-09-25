<?php

namespace App\Http\Requests\Dashboard\Product;

use App\Enums\Feature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProductStatus;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:1'],
            'compare_price' => ['nullable', 'numeric', 'min:2', 'gt:price'],
            'options' => ['nullable', 'array'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'featured' => ['required', Rule::in([1, 0])],
            'status' => ['required', Rule::in(ProductStatus::values())],
            'description' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'], // Ensure tags is an array
            'tags.*.value' => ['nullable', 'string', 'max:255'], // Validate each tag's value
        ];
    }
}
