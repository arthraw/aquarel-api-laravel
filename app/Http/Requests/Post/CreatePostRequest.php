<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'content' => 'string|required',
            'profile_id' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Post content cant be empty',
            'profile_id.required' => 'The Post owner cant be empty'
        ];
    }
}
