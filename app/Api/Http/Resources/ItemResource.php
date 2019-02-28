<?php

namespace App\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Json-адаптер для сущности «продукт».
 *
 * @property string $id
 * @property string $title
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property string $user_id
 * @property string created_at
 * @property string updated_at
 */
class ItemResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'protein' => $this->protein,
            'fat' => $this->fat,
            'carbohydrates' => $this->carbohydrates,
            'fiber' => $this->fiber,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}