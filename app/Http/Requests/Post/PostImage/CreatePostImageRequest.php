<?php

namespace App\Http\Requests\Post\PostImage;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostImageRequest extends FormRequest
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
            'post_image_url' => 'string|required',
            'profile_id' => 'string|required',
            'post_id' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'post_image_url.required' => 'Post image URL cant be empty',
            'profile_id.required' => 'The Post owner cant be empty',
            'post_id.required' => 'The Post id cant be empty'
        ];
    }
}
