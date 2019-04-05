<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * HTTP-request for days request.
 */
class DaysRequest extends FormRequest
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

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->get('date');
    }
}