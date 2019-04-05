<?php

namespace App\Api\Http\Requests;

/**
 * HTTP request for meals list.
 */
class MealsRequest extends ItemsRequest
{
    /**
     * {@inheritdoc}
     */
    protected function getSortableAttributes(): array
    {
        return ['title', 'protein', 'fat', 'fiber', 'carbohydrates', 'createdAt'];
    }
}