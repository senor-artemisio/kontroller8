<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Portion;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * Json adapter for token.
 */
class PortionResource extends JsonResource
{
    /**
     * {@inheritDoc}
     */
    public function toArray($request): array
    {
        /** @var Portion $portion */
        $portion = $this;

        $time = $portion->time ? Carbon::createFromTimeString($portion->time)->format('H:i') : null;

        return [
            'id' => $portion->id,
            'protein' => $portion->protein,
            'fat' => $portion->fat,
            'carbohydrates' => $portion->carbohydrates,
            'fiber' => $portion->fiber,
            'weight' => $portion->weight,
            'eaten' => $portion->eaten,
            'created_at' => $portion->created_at->toDateTimeString(),
            'updated_at' => $portion->updated_at->toDateTimeString(),
            'time' => $time,
            'meal' => [
                'id' => $portion->meal_id,
                'title' => $portion->meal->title
            ],
            'day' => [
                'id' => $portion->day_id,
                'title' => $portion->day->getTitle()
            ]
        ];
    }
}