<?php

namespace App\Http\Requests\Category;

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
        $id = $this->route('id');
        
        return [
            'name_'.$id => 'required|min:3'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'This field is required!',
            'min' => 'This field must have not less than 3 characters!'
        ];
    }
}
