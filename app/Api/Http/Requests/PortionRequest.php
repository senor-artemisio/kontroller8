<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP-request for change eaten field
 */
class PortionRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'eaten' => 'required|bool'
        ];
    }

    /**
     * Check access locate in controller.
     *
     * @see \App\Api\Http\Controllers\PortionController
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}