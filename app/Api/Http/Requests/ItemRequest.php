<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * HTTP-запрос для сущности «продукт».
 */
class ItemRequest extends FormRequest
{
    /**
     * Возвращает правила валидации применяемых к запросу.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'string|required|max:255',
            'protein' => 'numeric|required',
            'fat' => 'numeric|required',
            'carbohydrates' => 'numeric|required',
            'fiber' => 'numeric|required',
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules = array_map(function ($value) {
                return $value . '|sometimes';
            }, $rules);
        }

        return $rules;
    }

    /**
     * Проверка доступа происходит в контроллере.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
