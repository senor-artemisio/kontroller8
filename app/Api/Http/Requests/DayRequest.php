<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP request for day.
 */
class DayRequest extends FormRequest
{
    /**
     * Validation rules for day.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'date|required|unique:days',
        ];
    }

    /**
     * Check access locate in controller.
     *
     * @return bool
     * @see \App\Api\Http\Controllers\MealController
     */
    public function authorize(): bool
    {
        return true;
    }
}
