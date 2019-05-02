<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP-request for portion.
 */
class PortionRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'eaten' => 'required|bool',
            'meal_id' => 'required|string|size:26|exists:meals,id',
            'weight' => 'integer|required'
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules = array_map(function ($value) {
                return $value . '|sometimes';
            }, $rules);
        }

        $rules['time'] = 'sometimes|date_format:H:i';

        return $rules;
    }

    /**
     * Check access locate in controller.
     *
     * @return bool
     * @see \App\Api\Http\Controllers\PortionController
     */
    public function authorize(): bool
    {
        return true;
    }
}