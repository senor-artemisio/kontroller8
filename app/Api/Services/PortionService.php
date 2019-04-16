<?php

namespace App\Api\Services;

use App\Api\DTO\MealDTO;
use App\Api\DTO\PortionDTO;
use App\Api\Models\Portion;
use App\Api\Repositories\MealRepository;
use App\Api\Repositories\PortionRepository;
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
     * @param MealRepository $mealRepository
     */
    public function __construct(PortionRepository $portionRepository, MealRepository $mealRepository)
    {
        $this->portionRepository = $portionRepository;
        $this->mealRepository = $mealRepository;
    }

    /**
     * @param PortionDTO $portionDTO
     * @param MealDTO $mealDTO
     * @param string $userId
     * @param string $dayId
     */
    public function create(PortionDTO $portionDTO, MealDTO $mealDTO, string $userId, string $dayId): void
    {
        $this->applyMeal($portionDTO, $mealDTO);

        $this->portionRepository->create([
            'id' => $portionDTO->getId(),
            'user_id' => $userId,
            'day_id' => $dayId,
            'meal_id' => $portionDTO->getMealId(),
            'protein' => $portionDTO->getProtein(),
            'fat' => $portionDTO->getFat(),
            'carbohydrates' => $portionDTO->getCarbohydrates(),
            'fiber' => $portionDTO->getFiber(),
            'weight' => $portionDTO->getWeight(),
            'eaten' => $portionDTO->getEaten(),
            'time' => $portionDTO->getTime()
        ]);
    }

    /**
     * @param Portion $portion
     * @param PortionDTO $portionDTO
     * @param MealDTO|null $mealDTO
     */
    public function update(Portion $portion, PortionDTO $portionDTO, ?MealDTO $mealDTO = null): void
    {
        $updateAllowedAttributes = ['meal_id', 'weight', 'eaten', 'time'];

        $changedValues = $portionDTO->getChangedValues();

        foreach ($changedValues as $attribute => $value) {
            if (!in_array($attribute, $updateAllowedAttributes, true)) {
                throw new \LogicException("Denied to update attribute $attribute");
            }
        }

        if (!isset($changedValues['weight'])) {
            $portionDTO->setWeight($portion->weight);
        }

        if ($mealDTO !== null) {
            $this->applyMeal($portionDTO, $mealDTO);
        } elseif (isset($changedValues['weight'])) {
            $meal = $this->mealRepository->findById($portion->meal_id);
            $mealDTO = MealDTO::createFromModel($meal);
            $this->applyMeal($portionDTO, $mealDTO);
        }

        $this->portionRepository->update($portion, $portionDTO->getChangedValues());
    }

    /**
     * @param Portion $portion
     * @throws \Exception
     */
    public function delete(Portion $portion): void
    {
        $this->portionRepository->delete($portion);
    }

    /**
     * @param PortionDTO $portionDTO
     * @param MealDTO $mealDTO
     */
    private function applyMeal(PortionDTO $portionDTO, MealDTO $mealDTO): void
    {
        $precision = 1;
        $k = $portionDTO->getWeight() / 100;
        $portionDTO->setProtein(round($mealDTO->getProtein() * $k, $precision));
        $portionDTO->setFat(round($mealDTO->getFat() * $k, $precision));
        $portionDTO->setCarbohydrates(round($mealDTO->getCarbohydrates() * $k, $precision));
        $portionDTO->setFiber(round($mealDTO->getFiber() * $k, $precision));
        $portionDTO->setMealId($mealDTO->getId());
    }
}