<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => ['sometimes', 'string'],
            'model' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string', 'in:new,used'],
            'year_from' => ['sometimes', 'integer', 'min:1900', 'max:2100'],
            'year_to' => ['sometimes', 'integer', 'min:1900', 'max:2100', 'gte:year_from'],
            'price_less' => ['sometimes', 'integer', 'min:0'],
            'price_more' => ['sometimes', 'integer', 'min:0'],
            'mileage_less' => ['sometimes', 'integer', 'min:0'],
            'mileage_more' => ['sometimes', 'integer', 'min:0'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
