<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:products,name',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'categories' => 'required',
        ];

        $rules = [
            'name' => 'required|string|unique:products,name',
            'description' => 'required|string|max:500',
            'price' => 'required|numeric',
            'categories' => 'required',
        ];

        if ($this->hasFile('image1')) {
            $rules['image1'] = 'nullable|mimes:jpg,png,svg,webp|max:2048';
        }

        if ($this->hasFile('image2')) {
            $rules['image2'] = 'nullable|mimes:jpg,png,svg,webp|max:2048';
        }

        return $rules;
    }
}
