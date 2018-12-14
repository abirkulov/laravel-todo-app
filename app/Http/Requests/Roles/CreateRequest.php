<?php

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name|min:3',
            'permissions.0' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required!',
            'min' => 'This field must have not less than 3 characters!',
            'unique' => 'The role with this name already exists. Choose another one.',
            'permissions.0.required' => 'You have to choose at least 1 permission!'
        ];
    }
}
