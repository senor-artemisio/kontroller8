<?php

namespace App\Api\Http\Resources;

use App\Api\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Json adapter for profile.
 */
class ProfileResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Profile $profile */
        $profile = $this;
        return [
            'user_id' => $profile->user_id,
            'weight' => $profile->weight,
            'age' => $profile->age,
            'height' => $profile->height,
            'activity' => $profile->activity,
            'modifier' => $profile->modifier,
            'calories' => $profile->calories,
            'created_at' => $profile->created_at->toDateTimeString(),
            'updated_at' => $profile->updated_at->toDateTimeString(),
        ];
    }
}