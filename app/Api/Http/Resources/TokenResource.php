<?php

namespace App\Api\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token;

/**
 * Json adapter for token.
 *
 * @property string $accessToken
 * @property Token $token
 */
class TokenResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'access_token' => $this->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($this->token->expires_at)->diffInDays(Carbon::now())
        ];
    }
}