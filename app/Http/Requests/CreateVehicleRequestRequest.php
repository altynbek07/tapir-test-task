<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'phone' => ['required', 'string', 'regex:/^\+7[0-9]{10}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone number must be in format: +79999999999',
        ];
    }
}
