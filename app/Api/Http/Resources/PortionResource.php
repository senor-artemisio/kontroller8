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

        $timeEaten = $portion->time_eaten ? Carbon::createFromTimeString($portion->time_eaten)->format('H:i') : null;
        $timePlan = $portion->time_plan ? Carbon::createFromTimeString($portion->time_plan)->format('H:i') : null;

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
            'time_eaten' => $timeEaten,
            'time_plan' => $timePlan
        ];
    }
}