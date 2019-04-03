<?php

namespace App\Api\Services;

use App\Api\DTO\DayDTO;
use App\Api\Models\Day;
use App\Api\Models\Item;
use App\Api\Repositories\DayRepository;

/**
 * Business logic for day.
 */
class DayService
{
    /** @var DayRepository */
    private $dayRepository;

    /**
     * @param DayRepository $dayRepository
     */
    public function __construct(DayRepository $dayRepository)
    {
        $this->dayRepository = $dayRepository;
    }

    /**
     * @param DayDTO $dto
     * @param string $userId
     */
    public function create(DayDTO $dto, string $userId): void
    {
        $dto->setUserId($userId);
        $this->dayRepository->create([
            'id' => $dto->getId(),
            'date' => $dto->getDate(),
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'fiber' => 0,
            'weight' => 0,
            'weight_eaten' => 0,
            'user_id' => $dto->getUserId()
        ]);
    }

    /**
     * @param Day $day
     */
    public function refresh(Day $day): void
    {
        $attributes = [
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'fiber' => 0,
            'weight' => 0,
            'weight_eaten' => 0
        ];
        foreach ($day->dayItems as $dayItem) {
            $attributes['protein'] += $dayItem->protein;
            $attributes['fat'] += $dayItem->fat;
            $attributes['carbohydrates'] += $dayItem->carbohydrates;
            $attributes['fiber'] = $dayItem->fiber;
            $attributes['weight'] = $dayItem->weight;
            $attributes['weight_eaten'] = $dayItem->weight_eaten;
        }
        $this->dayRepository->update($day, $attributes);
    }
}