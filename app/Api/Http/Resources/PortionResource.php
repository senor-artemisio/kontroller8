<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Portion;
use Illuminate\Http\Resources\Json\JsonResource;

class PortionResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Portion $portion */
        $portion = $this;

        return [
            'id' => $portion->id,
            'meal_id' => $portion->meal_id,
            'protein' => $portion->protein,
            'fat' => $portion->fat,
            'carbohydrates' => $portion->carbohydrates,
            'fiber' => $portion->fiber,
            'weight' => $portion->weight,
            'eaten' => $portion->eaten,
            'time_plan' => $portion->time_plan,
            'time_eaten' => $portion->time_eaten,
            'created_at' => $portion->created_at->toDateTimeString(),
            'updated_at' => $portion->updated_at->toDateTimeString(),
        ];
    }
}