<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|min:3',
            'permissions.0' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required!',
            'min' => 'This field must have not less than 3 characters!',
            'permissions.0.required' => 'You have to choose at least 1 permission!'
        ];
    }
}
