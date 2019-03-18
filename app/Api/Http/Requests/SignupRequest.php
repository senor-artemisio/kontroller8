<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * HTTP-request for signup.
 */
class SignupRequest extends FormRequest
{
    /**
     * Validation rules for signup.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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