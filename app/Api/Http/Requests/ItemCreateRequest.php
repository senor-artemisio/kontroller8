<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос на создание сущности «продукт».
 */
class ItemCreateRequest extends FormRequest
{
    /**
     * Возвращает правила валидации применяемых к запросу.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required|max:255',
            'protein' => 'numeric|required',
            'fat' => 'numeric|required',
            'carbohydrates' => 'numeric|required',
            'fiber' => 'numeric|required',
            'user_id' => 'string|required',
        ];
    }

    /**
     * Запрос может выполнить любой авторизованный пользователь.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
