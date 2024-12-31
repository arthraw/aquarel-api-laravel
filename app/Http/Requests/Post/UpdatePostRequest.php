<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'string|required',
            'content' => 'string|required',
            'profile_id' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'post_id.required' => 'Post Id cant be empty',
            'content.required' => 'Post content cant be empty',
            'profile_id.required' => 'The Post owner cant be empty'
        ];
    }
}
