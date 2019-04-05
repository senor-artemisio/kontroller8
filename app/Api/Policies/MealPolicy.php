<?php

namespace App\Api\Policies;

use App\Api\Models\User;
use App\Api\Models\Meal;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Access rules for meal.
 */
class MealPolicy
{
    use HandlesAuthorization;

    /**
     * Check access for view meals list
     *
     * @param User $user
     * @return bool
     */
    public function list(User $user): bool
    {
        return true;
    }

    /**
     * Check access for view meal.
     *
     * @param User $user
     * @param Meal $meal
     * @return mixed
     */
    public function view(User $user, Meal $meal): bool
    {
        return $user->getAuthIdentifier() === $meal->user_id;
    }

    /**
     * Check access for change meal.
     *
     * @param User $user
     * @param Meal $meal
     * @return mixed
     */
    public function update(User $user, Meal $meal): bool
    {
        return $user->getAuthIdentifier() === $meal->user_id;
    }

    /**
     * Check access for delete meal.
     *
     * @param User $user
     * @param Meal $meal
     * @return mixed
     */
    public function delete(User $user, Meal $meal)
    {
        return $user->getAuthIdentifier() === $meal->user_id;
    }
}
