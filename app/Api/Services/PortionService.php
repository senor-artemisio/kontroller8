<?php

namespace App\Api\Services;

use App\Api\DTO\PortionDTO;
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
     * @param PortionDTO $dto
     * @param string $userId
     * @param string $dayId
     * @throws AuthorizationException
     */
    public function create(PortionDTO $dto, string $userId, string $dayId): void
    {
        $meal = $this->mealRepository->findById($dto->getMealId());
        $this->authorize('view', $meal);

        $weightK = $dto->getWeight() / 100;

        $this->portionRepository->create([
            'id' => $dto->getId(),
            'user_id' => $userId,
            'day_id' => $dayId,
            'meal_id' => $dto->getMealId(),
            'protein' => (int)($meal->protein * $weightK),
            'fat' => (int)($meal->fat * $weightK),
            'carbohydrates' => (int)($meal->carbohydrates * $weightK),
            'fiber' => (int)($meal->fiber * $weightK),
            'weight' => $dto->getWeight(),
            'eaten' => $dto->getEaten(),
            'time' => $dto->getTime()
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