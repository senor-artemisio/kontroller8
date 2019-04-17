<?php

namespace App\Api\Http\Requests;

/**
 * HTTP-request for days request.
 */
class DaysRequest extends ItemsRequest
{
    /**
     * {@inheritDoc}
     */
    protected function getSortableAttributes(): array
    {
        return [
            'date', 'eaten', 'weight', 'weight_eaten',
            'protein', 'fat', 'fiber', 'carbohydrates',
            'protein_eaten', 'fat_eaten', 'fiber_eaten', 'carbohydrates_eaten',
        ];
    }
}