<?php

namespace App\Api\Http\Requests;

/**
 * Запрос на обновление сущности «продукт».
 */
class ItemUpdateRequest extends ItemStoreRequest
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return array_map(function ($value) {
            return $value . '|sometimes';
        }, parent::rules());
    }

    /**
     * Запрос может выполнить любой авторизованный пользователь.
     *
     * @return bool
     */
    public function authorize(): bool
    {
//        dd($this->request->all());


        return true;
    }
}
