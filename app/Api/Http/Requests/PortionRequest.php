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
            'protein' => 'integer|required',
            'fat' => 'integer|required',
            'carbohydrates' => 'integer|required',
            'fiber' => 'integer|require',
            'weight' => 'integer|require',
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