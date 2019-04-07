<?php

namespace App\Api\Http\Resources;


use App\Api\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Day $day */
        $day = $this;
        return [
            'id' => $day->id,
            'title' => "{$day->date->day} {$day->date->localeMonth}",
            'dayOfWeek' => $day->date->localeDayOfWeek,
            'date' => $day->date->toDateString(),
            'protein' => $day->protein,
            'fat' => $day->fat,
            'carbohydrates' => $day->carbohydrates,
            'fiber' => $day->fiber,
            'weight' => $day->weight,
            'protein_eaten' => $day->protein_eaten,
            'fat_eaten' => $day->fat_eaten,
            'carbohydrates_eaten' => $day->carbohydrates_eaten,
            'fiber_eaten' => $day->fiber_eaten,
            'weight_eaten' => $day->weight_eaten,
            'created_at' => $day->created_at->toDateTimeString(),
            'updated_at' => $day->updated_at->toDateTimeString(),
            'portions' => PortionResource::collection($day->portions)
        ];
    }
}