<?php

namespace App\Api\Repositories;

use App\Api\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProfileRepository
{
    /** @var Builder */
    private $profile;

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->profile = Profile::query();
    }

    /**
     * @param array $attributes
     * @return Profile|Model
     */
    public function create(array $attributes): Profile
    {
        return $this->profile->create($attributes);
    }

    /**
     * @param Profile $profile
     * @param array $attributes
     * @return Profile
     */
    public function update(Profile $profile, array $attributes): Profile
    {
        $profile->update($attributes);

        return $profile;
    }
}