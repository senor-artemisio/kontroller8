<?php

namespace App\Api\DTO;

trait NutritionAttributes
{
    /** @var float */
    protected $protein;

    /** @var float */
    protected $fat;

    /** @var float */
    protected $carbohydrates;

    /** @var float */
    protected $fiber;

    /**
     * @return float
     */
    public function getProtein(): float
    {
        return $this->protein;
    }

    /**
     * @param float $protein
     */
    public function setProtein(float $protein): void
    {
        $this->protein = $protein;
    }

    /**
     * @return float
     */
    public function getFat(): float
    {
        return $this->fat;
    }

    /**
     * @param float $fat
     */
    public function setFat(float $fat): void
    {
        $this->fat = $fat;
    }

    /**
     * @return float
     */
    public function getCarbohydrates(): float
    {
        return $this->carbohydrates;
    }

    /**
     * @param float $carbohydrates
     */
    public function setCarbohydrates(float $carbohydrates): void
    {
        $this->carbohydrates = $carbohydrates;
    }

    /**
     * @return float
     */
    public function getFiber(): float
    {
        return $this->fiber;
    }

    /**
     * @param float $fiber
     */
    public function setFiber(float $fiber): void
    {
        $this->fiber = $fiber;
    }
}