<?php

namespace App\Api\Http\Requests;

/**
 * HTTP request for portions list.
 */
class PortionsRequest extends ItemsRequest
{
    /**
     * {@inheritDoc}
     */
    protected function getSortableAttributes(): array
    {
        return ['protein', 'fat', 'fiber', 'carbohydrates', 'time', 'weight','eaten'];
    }
}