<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Portion;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PortionResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Portion $portion */
        $portion = $this;

        return [
            'id' => $portion->id,
            'protein' => $portion->protein,
            'fat' => $portion->fat,
            'carbohydrates' => $portion->carbohydrates,
            'fiber' => $portion->fiber,
            'weight' => $portion->weight,
            'eaten' => $portion->eaten,
            'time_plan' => Carbon::createFromFormat('H:i:s', $portion->time_plan)->format('h:i'),
            'time_eaten' => Carbon::createFromFormat('H:i:s', $portion->time_eaten)->format('h:i'),
            'created_at' => $portion->created_at->toDateTimeString(),
            'updated_at' => $portion->updated_at->toDateTimeString(),
            'meal' => MealResource::make($portion->meal)->toArray($request)
        ];
    }
}