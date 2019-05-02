<?php

namespace App\Api\Http\Requests;

/**
 * HTTP request for meals list.
 */
class MealsRequest extends ItemsRequest
{
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['title'] = 'sometimes|string';

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSortableAttributes(): array
    {
        return ['title', 'protein', 'fat', 'fiber', 'carbohydrates', 'calories'];
    }
}