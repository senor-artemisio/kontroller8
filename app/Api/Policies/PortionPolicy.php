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
    public function markEaten(User $user, Portion $portion): bool
    {
        return $portion->user_id === $user->getAuthIdentifier();
    }

    /**
     * Check access for unmark portion eaten.
     *
     * @param Portion $portion
     * @param User $user
     * @return bool
     */
    public function unmarkEaten(User $user, Portion $portion): bool
    {
        return $portion->user_id === $user->getAuthIdentifier();
    }
}