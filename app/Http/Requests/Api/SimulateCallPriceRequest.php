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

    /**
     * Define body params to be used by the API documentation
     */
    public function bodyParameters(): array
    {
        return [
            'ddd_origin' => [
                'description' => 'The DDD for the origin of the call.',
                'example' => '011'
            ],
            'ddd_destination' => [
                'description' => 'The DDD for the destination of the call.',
                'example' => '017'
            ],
            'call_minutes' => [
                'description' => 'The total duration time of the call in minutes. '
                    . 'The call minutes field must be greater than 0.',
                'example' => 80
            ],
            'plan_id' => [
                'description' => 'The plan ot be used on the simulation. The plan id field must be greater than 0.',
                'example' => 2
            ]
        ];
    }
}
