<?php

namespace App\Http\Requests\Like;

use Illuminate\Foundation\Http\FormRequest;

class CreateLikeRequest extends FormRequest
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
            'profile_id' => 'string|required',
            'likeable_id' => 'string|required',
            'likeable_type' => 'string|required',
        ];
    }

    public function messages()
    {
        return [
            'profile_id.required' => 'The profile_id cant be empty',
            'likeable_id.required' => 'The likeable_id cant be empty',
            'likeable_type.required' => 'The likeable_type cant be empty'
        ];
    }
}
