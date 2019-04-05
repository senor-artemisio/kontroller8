<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Json adapter for meal.
 */
class MealResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Meal $meal */
        $meal = $this;
        return [
            'id' => $meal->id,
            'title' => $meal->title,
            'protein' => $meal->protein,
            'fat' => $meal->fat,
            'carbohydrates' => $meal->carbohydrates,
            'fiber' => $meal->fiber,
            'type' => $meal->type,
            'created_at' => $meal->created_at->toDateTimeString(),
            'updated_at' => $meal->updated_at->toDateTimeString(),
        ];
    }
}