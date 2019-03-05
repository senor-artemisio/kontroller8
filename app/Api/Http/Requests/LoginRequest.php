<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * HTTP-request for login.
 */
class LoginRequest extends FormRequest
{
    /**
     * Validation rules for login.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ];
    }

    /**
     * Only for unauthorized users.
     *
     * @see \App\Api\Http\Controllers\ItemController
     * @return bool
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }
}