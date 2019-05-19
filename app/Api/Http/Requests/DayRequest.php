<?php

namespace App\Api\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
            'date' => [
                'date',
                'required',
                Rule::unique('days', 'date')->where(function (Builder $query) {
                    $query->where('user_id', '=', Auth::user()->getAuthIdentifier());
                })
            ]
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
