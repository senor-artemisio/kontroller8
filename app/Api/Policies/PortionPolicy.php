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
     * Check access for mark portion eaten.
     *
     * @param Portion $portion
     * @param User $user
     * @return bool
     */
    public function markEaten(Portion $portion, User $user): bool
    {
        return $portion->user_id === $user->id;
    }

    /**
     * Check access for unmark portion eaten.
     *
     * @param Portion $portion
     * @param User $user
     * @return bool
     */
    public function unmarkEaten(Portion $portion, User $user): bool
    {
        return $portion->user_id === $user->id;
    }
}