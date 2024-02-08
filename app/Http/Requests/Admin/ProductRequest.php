<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'product_attribute' => 'required',
            'product_attribute.*.size' => 'required',
            'product_attribute.*.price' => 'required',
            //'files.*' => 'required|mimes:jpeg,png,jpg|max:2048',
            'product_images.*' => 'required|mimes:jpeg,png,jpg',
        ];
    }
}
