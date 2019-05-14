<?php

namespace App\Api\Policies;

use App\Api\Models\User;
use App\Api\Models\Profile;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Access rules for profile.
 */
class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Check access for create profile.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Check access for view profile.
     *
     * @param User $user
     * @param Profile $profile
     * @return mixed
     */
    public function view(User $user, Profile $profile): bool
    {
        return $user->getAuthIdentifier() === $profile->user_id;
    }

    /**
     * Check access for change profile.
     *
     * @param User $user
     * @param Profile $profile
     * @return mixed
     */
    public function update(User $user, Profile $profile): bool
    {
        return $user->getAuthIdentifier() === $profile->user_id;
    }
}
