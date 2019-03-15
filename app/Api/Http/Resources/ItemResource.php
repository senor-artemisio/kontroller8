<?php

namespace App\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * Json adapter for item.
 *
 * @property string $id
 * @property string $title
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property string $user_id
 * @property string $type
 * @property Carbon created_at
 * @property Carbon updated_at
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
            'protein' => number_format($this->protein, 1),
            'fat' => number_format($this->fat, 1),
            'carbohydrates' => number_format($this->carbohydrates, 1),
            'fiber' => number_format($this->fiber, 1),
            'user_id' => $this->user_id,
            'type' => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}