<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name must be filled!',
            'type.required' => 'Type must be filled!',
            'description.required' => 'Description must be filled!',
            'price.required' => 'Price must be filled!',
            'quantity.required' => 'Quantity must be filled!',
        ];
    }
}
