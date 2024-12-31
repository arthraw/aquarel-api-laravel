<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email field is required',
            'email.email' => 'Type a valid email',
            'password.required' => 'Password field is required',
            'password.min' => 'Password must be at least 6 characters long',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'validation_message' => 'Error in data validation',
            'errors' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}
