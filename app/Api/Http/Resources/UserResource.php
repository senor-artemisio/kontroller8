<?php

namespace App\Api\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Json adapter for user.
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class UserResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}