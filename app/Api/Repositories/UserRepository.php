<?php

namespace App\Api\Repositories;

use App\Api\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Working with users database data.
 */
class UserRepository
{
    /** @var \Illuminate\Database\Eloquent\Builder */
    protected $user;

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->user = User::query();
    }

    /**
     * @param string $id
     * @return User|Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(string $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * @param $attributes
     * @return User|Model
     */
    public function create(array $attributes): User
    {
        return $this->user->create($attributes);
    }

    /**
     * @param User $user
     * @return PersonalAccessTokenResult
     */
    public function token(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('Personal Access Token');
    }
}