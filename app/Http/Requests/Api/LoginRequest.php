<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'string', 'min:6', 'max:70', 'email'],
            'password' => ['required', 'string', 'min:6']
        ];
    }

    /**
     * Define body params to be used by the API documentation
     */
    public function bodyParameters(): array
    {
        return [
            'email' => [
                'description' => 'The e-mail of the user.',
                'example' => 'test@test.com'
            ],
            'password' => [
                'description' => 'The password of the user.',
                'example' => 'LfMJvB5b9xZbF76Q4tFT'
            ]
        ];
    }
}
