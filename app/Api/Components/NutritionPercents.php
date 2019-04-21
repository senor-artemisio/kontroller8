<?php

namespace App\Api\Components;

/**
 * @property int $weight
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $weight_eaten
 * @property float $protein_eaten
 * @property float $fat_eaten
 * @property float $carbohydrates_eaten
 */
trait NutritionPercents
{
    /**
     * @return int
     */
    public function getProteinEatenPercent(): int
    {
        if ($this->protein === 0.0) {
            return 0;
        }

        return ceil($this->protein_eaten / ($this->protein / 100));
    }

    /**
     * @return int
     */
    public function getProteinPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->protein / ($this->weight / 100));
    }

    /**
     * @return int
     */
    public function getFatEatenPercent(): int
    {
        if ($this->fat === 0.0) {
            return 0;
        }

        return ceil($this->fat_eaten / ($this->fat / 100));
    }

    /**
     * @return int
     */
    public function getFatPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->fat / ($this->weight / 100));
    }

    /**
     * @return int
     */
    public function getCarbohydratesEatenPercent(): int
    {
        if ($this->carbohydrates === 0.0) {
            return 0;
        }

        return ceil($this->carbohydrates_eaten / ($this->carbohydrates / 100));
    }

    /**
     * @return int
     */
    public function getCarbohydratesPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->carbohydrates / ($this->weight / 100));
    }
}