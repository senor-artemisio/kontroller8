<?php

namespace App\Api\Services;

use Illuminate\Support\Carbon;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Working with tokens database data.
 */
class TokenService
{
    /**
     * @param PersonalAccessTokenResult $result
     * @param bool $rememberMe
     */
    public function create(PersonalAccessTokenResult $result, bool $rememberMe): void
    {
        $token = $result->token;

        if ($rememberMe) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();
    }
}