<?php

namespace App\Api\Policies;

use App\Api\Models\User;
use App\Api\Models\Day;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Access rules for day.
 */
class DayPolicy
{
    use HandlesAuthorization;

    /**
     * Check access for view week
     *
     * @param User $user
     * @return bool
     */
    public function week(User $user): bool
    {
        return true;
    }
}