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
        $rules = [
            'protein' => 'numeric|required',
            'fat' => 'numeric|required',
            'carbohydrates' => 'numeric|required',
            'fiber' => 'numeric|required',
            'date' => 'date|required',
            'weight' => 'numeric|required',
            'weight_eaten' => 'numeric|required',
            'user_id' => 'string|size:26|required|exists:days',
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules = array_map(function ($value) {
                return $value . '|sometimes';
            }, $rules);
        }

        return $rules;
    }

    /**
     * Check access locate in controller.
     *
     * @see \App\Api\Http\Controllers\MealController
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
