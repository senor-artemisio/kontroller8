<?php

namespace App\Api\Http\Resources;


use App\Api\Components\NutritionPercents;
use App\Api\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    use NutritionPercents;

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
            'title' => $day->getTitle(),
            'date' => $day->date->toDateString(),
            'protein' => $day->protein,
            'fat' => $day->fat,
            'carbohydrates' => $day->carbohydrates,
            'fiber' => $day->fiber,
            'weight' => $day->weight,
            'calories' => $day->calories,
            'protein_percent' => $this->getProteinPercent(),
            'fat_percent' => $this->getFatPercent(),
            'carbohydrates_percent' => $this->getCarbohydratesPercent(),
            'protein_eaten' => $day->protein_eaten,
            'fat_eaten' => $day->fat_eaten,
            'carbohydrates_eaten' => $day->carbohydrates_eaten,
            'fiber_eaten' => $day->fiber_eaten,
            'weight_eaten' => $day->weight_eaten,
            'protein_eaten_percent' => $this->getProteinEatenPercent(),
            'fat_eaten_percent' => $this->getFatEatenPercent(),
            'carbohydrates_eaten_percent' => $this->getCarbohydratesEatenPercent(),
            'calories_eaten_percent' => $this->getCaloriesEatenPercent(),
            'created_at' => $day->created_at->toDateTimeString(),
            'updated_at' => $day->updated_at->toDateTimeString(),
            'eaten' => $day->isEaten(),
            'ratio' => $day->getRatio(),
            'progress' => $day->getProgress(),
        ];
    }
}