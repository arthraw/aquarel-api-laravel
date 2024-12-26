<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'profile_id' => 'required|string',
            'name' => 'string',
            'bio' => 'string',
            'email' => 'string',
            'password' => 'string',
            'password_check' => 'string',
            'avatar_url' => 'string',
            'banner_url' => 'string',
            'instagram_profile_url' => 'string',
            'behance_profile_url' => 'string',
            'category' => 'string'
        ];
    }

    public function messages()
    {
        return [
            'profile_id.required' => 'O id do perfil é obrigatório.'
        ];
    }
}
