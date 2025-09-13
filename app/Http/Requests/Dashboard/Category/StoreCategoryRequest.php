<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('categories', 'name'),
                // custome rule to prevent the name 'laravel'
                /*
                    function ($attribute, $value, $fail) {
                        if (strtolower($value) == 'laravel') {
                            $fail('The ' . $attribute . ' cannot be "laravel".');
                        }
                    }
                */
                // use global custom validation rule from AppServiceProvider
                'filter:laravel,php',
            ],
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ];
    }
}
