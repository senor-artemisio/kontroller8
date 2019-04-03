<?php

namespace App\Api\Http\Requests;

/**
 * HTTP request for items list.
 */
class ItemsRequest extends BaseListRequest
{
    /**
     * {@inheritdoc}
     */
    protected function getSortableAttributes(): array
    {
        return ['title', 'protein', 'fat', 'fiber', 'carbohydrates', 'createdAt'];
    }
}