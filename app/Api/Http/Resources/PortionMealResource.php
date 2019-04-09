<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Portion;

/**
 * Json adapter for portion with meal.
 */
class PortionMealResource extends PortionResource
{
    /**
     * {@inheritDoc}
     */
    public function toArray($request): array
    {
        /** @var Portion $portion */
        $portion = $this;

        $result = parent::toArray($request);
        $result['meal'] = MealResource::make($portion->meal)->toArray($request);

        return $result;
    }
}