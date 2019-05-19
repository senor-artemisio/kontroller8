<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP-request for profile.
 */
class ProfileRequest extends FormRequest
{
    /**
     * Validation rules for profile.
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'age' => 'integer|required|min:18|max:99',
            'weight' => 'integer|required|min:1',
            'height' => 'integer|required|min:1',
            'gender' => 'boolean|required',
            'modifier' => 'numeric|required|min:0',
            'activity' => 'numeric|required|min:0',
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules = array_map(function ($value) {
                return $value . '|sometimes';
            }, $rules);
        }

        return $rules;
    }
}