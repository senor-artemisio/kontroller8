<?php

namespace App\Api\Policies;

use App\Api\Models\Portion;
use App\Api\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Access rules for portion.
 */
class PortionPolicy
{
    use HandlesAuthorization;

    /**
     * Check access for create portions.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }
}