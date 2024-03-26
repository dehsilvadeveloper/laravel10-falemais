<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SimulateCallPriceRequest extends FormRequest
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
            'ddd_origin' => ['required', 'string', 'min:3', 'max:3'],
            'ddd_destination' => ['required', 'string', 'min:3', 'max:3'],
            'call_minutes' => ['required', 'integer', 'gt:0'],
            'plan_id' => ['required', 'integer', 'gt:0', 'exists:plans,id']
        ];
    }
}
