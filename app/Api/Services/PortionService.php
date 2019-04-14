<?php

namespace App\Api\Services;

use App\Api\DTO\MealDTO;
use App\Api\DTO\PortionDTO;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Repositories\MealRepository;
use App\Api\Repositories\PortionRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Business logic for portion.
 */
class PortionService
{
    use AuthorizesRequests;

    /** @var PortionRepository */
    private $portionRepository;

    /** @var MealRepository */
    private $mealRepository;

    /**
     * @param PortionRepository $portionRepository
     */
    public function __construct(PortionRepository $portionRepository, MealRepository $mealRepository)
    {
        $this->portionRepository = $portionRepository;
        $this->mealRepository = $mealRepository;
    }

    /**
     * @param PortionDTO $portionDTO
     * @param string $userId
     * @param string $dayId
     */
    public function create(PortionDTO $portionDTO, MealDTO $mealDTO, string $userId, string $dayId): void
    {

        $weightK = $portionDTO->getWeight() / 100;

        $this->portionRepository->create([
            'id' => $portionDTO->getId(),
            'user_id' => $userId,
            'day_id' => $dayId,
            'meal_id' => $portionDTO->getMealId(),
            'protein' => (int)($mealDTO->getProtein() * $weightK),
            'fat' => (int)($mealDTO->getFat() * $weightK),
            'carbohydrates' => (int)($mealDTO->getCarbohydrates() * $weightK),
            'fiber' => (int)($mealDTO->getFiber() * $weightK),
            'weight' => $portionDTO->getWeight(),
            'eaten' => $portionDTO->getEaten(),
            'time' => $portionDTO->getTime()
        ]);
    }

    /**
     * @param Portion $portion
     * @param PortionDTO $dto
     */
    public function update(Portion $portion, PortionDTO $dto): void
    {
        $this->portionRepository->update($portion, $dto->getChangedValues());
    }

    /**
     * @param Portion $portion
     * @throws \Exception
     */
    public function delete(Portion $portion): void
    {
        $this->portionRepository->delete($portion);
    }
}