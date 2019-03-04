<?php

namespace App\Api\Services;

use App\Api\DTO\UserDTO;
use App\Api\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Business logic for user.
 */
class UserService
{
    /** @var UserRepository */
    protected $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserDTO $dto
     */
    public function create(UserDTO $dto): void
    {
        $this->repository->create([
            'id' => $dto->getId(),
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => Hash::make($dto->getPassword())
        ]);
    }
}