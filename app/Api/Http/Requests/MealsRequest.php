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
    protected function getSortableAttributes(): array
    {
        return ['title', 'protein', 'fat', 'fiber', 'carbohydrates', 'calories'];
    }
}