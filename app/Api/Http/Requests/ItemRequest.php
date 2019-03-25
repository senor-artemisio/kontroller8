<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP request for item entity.
 */
class ItemRequest extends FormRequest
{
    /**
     * Validation rules for item.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'string|required|max:255',
            'protein' => 'numeric|required|min:0|max:100|ratio',
            'fat' => 'numeric|required|min:0|max:100|ratio',
            'carbohydrates' => 'numeric|required|min:0|max:100|ratio',
            'fiber' => 'numeric|required|min:0|max:100',
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
     * @see \App\Api\Http\Controllers\ItemController
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
