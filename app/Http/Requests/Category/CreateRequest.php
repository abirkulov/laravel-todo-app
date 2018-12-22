<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories,name|min:3'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required!',
            'min' => 'This field must have not less than 3 characters!',
            'unique' => 'The category with this name already exists. Choose another one.'
        ];
    }
}
