<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Posts;

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
            'title' => 'required|max:255',
            'text' => 'required',
            'img' => 'mimes:jpeg,jpg,bmp,gif,png',
            'user_id' => 'required|integer',
            'category_id' => 'required|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'This field is required!',
            'img.mimes' => 'File must have one of these extensions: jpeg, jpg, png, bmp, gif.',
            'integer' => 'This field have to be integer!',
            'max' => 'This field must have not more than 255 characters!'
        ];
    }
}
