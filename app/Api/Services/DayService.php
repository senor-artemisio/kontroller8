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
     * @param DayDTO $dayDTO
     * @param string $userId
     */
    public function create(DayDTO $dayDTO, string $userId): void
    {
        $this->dayRepository->create([
            'id' => $dayDTO->getId(),
            'date' => $dayDTO->getDate(),
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'fiber' => 0,
            'weight' => 0,
            'calories' => 0,
            'protein_eaten' => 0,
            'fat_eaten' => 0,
            'carbohydrates_eaten' => 0,
            'fiber_eaten' => 0,
            'weight_eaten' => 0,
            'calories_eaten' => 0,
            'user_id' => $userId
        ]);
    }

    /**
     * @param Day $day
     * @throws \Exception
     */
    public function delete(Day $day): void
    {
        $this->dayRepository->delete($day);
    }

    /**
     * Refresh all stats for day
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
            'calories' => 0,
            'protein_eaten' => 0,
            'fat_eaten' => 0,
            'carbohydrates_eaten' => 0,
            'fiber_eaten' => 0,
            'weight_eaten' => 0,
            'calories_eaten' => 0
        ];
        foreach ($day->portions as $portion) {
            $calories = ceil($portion->protein * 4 + $portion->fat * 8 + $portion->carbohydrates * 4);
            $attributes['protein'] += $portion->protein;
            $attributes['fat'] += $portion->fat;
            $attributes['carbohydrates'] += $portion->carbohydrates;
            $attributes['fiber'] += $portion->fiber;
            $attributes['weight'] += $portion->weight;
            $attributes['calories'] += $calories;
            if ($portion->eaten) {
                $attributes['protein_eaten'] += $portion->protein;
                $attributes['fat_eaten'] += $portion->fat;
                $attributes['carbohydrates_eaten'] += $portion->carbohydrates;
                $attributes['fiber_eaten'] += $portion->fiber;
                $attributes['weight_eaten'] += $portion->weight;
                $attributes['calories_eaten'] += $calories;
            }
        }
        $this->dayRepository->update($day, $attributes);
    }
}