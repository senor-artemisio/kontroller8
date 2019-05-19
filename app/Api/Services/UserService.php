<?php

namespace App\Api\Services;

use App\Api\DTO\UserDTO;
use App\Api\Repositories\ProfileRepository;
use App\Api\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

/**
 * Business logic for user.
 */
class UserService
{
    /** @var UserRepository */
    protected $userRepository;

    /** @var ProfileRepository */
    protected $profileRepository;

    /**
     * @param UserRepository $userRepository
     * @param ProfileRepository $profileRepository
     */
    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param UserDTO $dto
     */
    public function create(UserDTO $dto): void
    {
        $this->userRepository->create([
            'id' => $dto->getId(),
            'name' => $dto->getName(),
            'email' => $dto->getEmail(),
            'password' => Hash::make($dto->getPassword())
        ]);
        $this->profileRepository->create(['user_id' => $dto->getId()]);
    }
}