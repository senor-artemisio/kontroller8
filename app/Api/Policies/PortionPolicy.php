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
     * Check access for view day.
     *
     * @param User $user
     * @param Portion $portion
     * @return mixed
     */
    public function view(User $user, Portion $portion): bool
    {
        return $user->getAuthIdentifier() === $portion->user_id;
    }

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


    /**
     * Check access for change portion.
     *
     * @param User $user
     * @param Portion $portion
     * @return mixed
     */
    public function update(User $user, Portion $portion): bool
    {
        return $user->getAuthIdentifier() === $portion->user_id;
    }


    /**
     * Check access for delete portion.
     *
     * @param User $user
     * @param Portion $portion
     * @return mixed
     */
    public function delete(User $user, Portion $portion)
    {
        return $user->getAuthIdentifier() === $portion->user_id;
    }
}