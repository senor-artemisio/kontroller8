<?php

namespace App\Api\Services;

use App\Api\DTO\PortionDTO;
use App\Api\Models\Portion;
use App\Api\Repositories\PortionRepository;

/**
 * Business logic for portion.
 */
class PortionService
{
    /** @var PortionRepository */
    private $portionRepository;

    /**
     * @param PortionRepository $portionRepository
     */
    public function __construct(PortionRepository $portionRepository)
    {
        $this->portionRepository = $portionRepository;
    }

    /**
     * @param PortionDTO $dto
     * @param string $userId
     */
    public function create(PortionDTO $dto, string $userId): void
    {
        $dto->setUserId($userId);
        $this->portionRepository->create([
            'id' => $dto->getId(),
            'user_id' => $dto->getUserId(),
            'day_id' => $dto->getDayId(),
            'meal_id' => $dto->getMealId(),
            'protein' => $dto->getProtein(),
            'fat' => $dto->getFat(),
            'carbohydrates' => $dto->getCarbohydrates(),
            'fiber' => $dto->getFiber(),
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