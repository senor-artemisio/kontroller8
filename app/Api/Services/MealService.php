<?php

namespace App\Api\Services;

use App\Api\DTO\MealDTO;
use App\Api\Repositories\MealRepository;
use App\Api\Models\Meal;

/**
 * Business logic for meal.
 */
class MealService
{
    /** @var MealRepository */
    private $mealRepository;

    /**
     * @param MealRepository $mealRepository
     */
    public function __construct(MealRepository $mealRepository)
    {
        $this->mealRepository = $mealRepository;
    }

    /**
     * @param MealDTO $dto
     * @param string $userId
     */
    public function create(MealDTO $dto, string $userId): void
    {
        $dto->setUserId($userId);
        $this->mealRepository->create([
            'id' => $dto->getId(),
            'title' => $dto->getTitle(),
            'user_id' => $dto->getUserId(),
            'protein' => $dto->getProtein(),
            'fat' => $dto->getFat(),
            'carbohydrates' => $dto->getCarbohydrates(),
            'fiber' => $dto->getFiber(),
            'calories' => ceil($dto->getProtein() * 4 + $dto->getFat() * 8 + $dto->getCarbohydrates() * 4)
        ]);
    }

    /**
     * @param MealDTO $dto
     * @param Meal $meal
     */
    public function update(Meal $meal, MealDTO $dto): void
    {
        $values = $dto->getChangedValues();

        $values['calories'] = ceil(
            ($values['protein'] ?? $meal->protein) * 4 +
            ($values['fat'] ?? $meal->fat) * 8 +
            ($values['carbohydrates'] ?? $meal->carbohydrates) * 4
        );

        $this->mealRepository->update($meal, $values);
    }

    /**
     * @param Meal $meal
     * @throws \Exception
     */
    public function delete(Meal $meal): void
    {
        $this->mealRepository->delete($meal);
    }
}