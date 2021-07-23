<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ProductGalleryRequest extends FormRequest
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
            'products_id' => 'required|integer',
            'is_default' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'products_id.required' => 'Product name must be filled.',
            'is_default.required' => 'Default must be selected.',
        ];
    }
}
