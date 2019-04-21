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
     * Check access for view days list
     *
     * @param User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return true;
    }

    /**
     * Check access for create new day
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Check access for view day.
     *
     * @param User $user
     * @param Day $day
     * @return mixed
     */
    public function view(User $user, Day $day): bool
    {
        return $user->getAuthIdentifier() === $day->user_id;
    }

    /**
     * Check access for change day.
     *
     * @param User $user
     * @param Day $day
     * @return mixed
     */
    public function update(User $user, Day $day): bool
    {
        return $user->getAuthIdentifier() === $day->user_id;
    }

    /**
     * Check access for delete day.
     *
     * @param User $user
     * @param Day $day
     * @return mixed
     */
    public function delete(User $user, Day $day)
    {
        return $user->getAuthIdentifier() === $day->user_id;
    }
}