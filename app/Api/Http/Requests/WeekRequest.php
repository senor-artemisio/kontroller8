<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP-request for week in days page.
 */
class WeekRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'date|required'
        ];
    }
}