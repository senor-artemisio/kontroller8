<?php

namespace App\Api\Services;

use App\Api\DTO\DayDTO;
use App\Api\Models\Day;
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
            'id' => $dto->id,
            'date' => $dto->date,
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'fiber' => 0,
            'weight' => 0,
            'protein_eaten' => 0,
            'fat_eaten' => 0,
            'carbohydrates_eaten' => 0,
            'fiber_eaten' => 0,
            'weight_eaten' => 0,
            'user_id' => $dto->userId
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
        foreach ($day->dayMeals as $dayMeal) {
            $attributes['protein'] += $dayMeal->protein_total;
            $attributes['fat'] += $dayMeal->fat_total;
            $attributes['carbohydrates'] += $dayMeal->carbohydrates_total;
            $attributes['fiber'] = $dayMeal->fiber_total;
            $attributes['weight'] = $dayMeal->weight;
            $attributes['weight_eaten'] = $dayMeal->weight_eaten;
        }
        $this->dayRepository->update($day, $attributes);
    }
}