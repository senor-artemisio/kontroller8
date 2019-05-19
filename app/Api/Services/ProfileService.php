<?php

namespace App\Api\Services;

use App\Api\DTO\ProfileDTO;
use App\Api\Models\Profile;
use App\Api\Repositories\ProfileRepository;

class ProfileService
{
    /** @var ProfileRepository */
    private $profileRepository;

    /**
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param ProfileDTO $profileDTO
     */
    public function create(ProfileDTO $profileDTO): void
    {
        $this->profileRepository->create([
            'user_id' => $profileDTO->getUserId(),
            'age' => $profileDTO->getAge(),
            'height' => $profileDTO->getHeight(),
            'weight' => $profileDTO->getWeight(),
            'gender' => $profileDTO->getGender(),
            'activity' => $profileDTO->getActivity(),
            'modifier' => $profileDTO->getModifier(),
            'calories' => $this->calculateCalories($profileDTO)
        ]);
    }

    /**
     * @param Profile $profile
     * @param ProfileDTO $profileDTO
     */
    public function update(Profile $profile, ProfileDTO $profileDTO): void
    {
        $values = $profileDTO->getChangedValues();

        $this->profileRepository->update($profile, $values);

        $calories = $this->calculateCalories(ProfileDTO::createFromModel($profile));

        $this->profileRepository->update($profile, ['calories' => $calories]);
    }

    /**
     * @param ProfileDTO $profileDTO
     * @return int
     */
    private function calculateCalories(ProfileDTO $profileDTO): int
    {
        if ($profileDTO->getGender()) {
            $basalMetabolism = 66 + (13.7 * $profileDTO->getWeight()) +
                (5 * $profileDTO->getHeight()) - (6.8 * $profileDTO->getAge());
        } else {
            $basalMetabolism = 655 + 9.6 * $profileDTO->getWeight() +
                1.8 * $profileDTO->getHeight() - 4.7 * $profileDTO->getAge();
        }

        return ($basalMetabolism * $profileDTO->getActivity()) * $profileDTO->getModifier();
    }
}