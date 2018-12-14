<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Posts;

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'text' => 'required',
            'img' => 'required|mimes:jpeg,jpg,bmp,gif,png',
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
            'img.required' => 'File is required!',
            'img.mimes' => 'File must have one of these extensions: jpeg, jpg, png, bmp, gif.',
            'integer' => 'This field have to be integer!',
            'unique' => 'The post with this title already exists! The title must be unique. Choose another one.',
            'max' => 'This field must have not more than 255 characters!'
        ];
    }
}
