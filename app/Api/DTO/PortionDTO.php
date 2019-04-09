<?php

namespace App\Api\DTO;

class PortionDTO extends BaseDTO
{
    /** @var string */
    private $id;

    /** @var string */
    private $dayId;

    /** @var string */
    private $mealId;

    /** @var string */
    private $userId;

    /** @var integer */
    private $protein;

    /** @var integer */
    private $fat;

    /** @var integer */
    private $carbohydrates;

    /** @var integer */
    private $fiber;

    /** @var integer */
    private $weight;

    /** @var bool */
    private $eaten;

    /** @var string|null */
    private $timePlan;

    /** @var string|null */
    private $timeEaten;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDayId(): string
    {
        return $this->dayId;
    }

    /**
     * @param string $dayId
     */
    public function setDayId(string $dayId): void
    {
        $this->dayId = $dayId;
    }

    /**
     * @return string
     */
    public function getMealId(): string
    {
        return $this->mealId;
    }

    /**
     * @param string $mealId
     */
    public function setMealId(string $mealId): void
    {
        $this->mealId = $mealId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getProtein(): int
    {
        return $this->protein;
    }

    /**
     * @param int $protein
     */
    public function setProtein(int $protein): void
    {
        $this->protein = $protein;
    }

    /**
     * @return int
     */
    public function getFat(): int
    {
        return $this->fat;
    }

    /**
     * @param int $fat
     */
    public function setFat(int $fat): void
    {
        $this->fat = $fat;
    }

    /**
     * @return int
     */
    public function getCarbohydrates(): int
    {
        return $this->carbohydrates;
    }

    /**
     * @param int $carbohydrates
     */
    public function setCarbohydrates(int $carbohydrates): void
    {
        $this->carbohydrates = $carbohydrates;
    }

    /**
     * @return int
     */
    public function getFiber(): int
    {
        return $this->fiber;
    }

    /**
     * @param int $fiber
     */
    public function setFiber(int $fiber): void
    {
        $this->fiber = $fiber;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return bool
     */
    public function isEaten(): bool
    {
        return $this->eaten;
    }

    /**
     * @param bool $eaten
     */
    public function setEaten(bool $eaten): void
    {
        $this->eaten = $eaten;
    }

    /**
     * @return string|null
     */
    public function getTimePlan(): ?string
    {
        return $this->timePlan;
    }

    /**
     * @param string|null $timePlan
     */
    public function setTimePlan(?string $timePlan): void
    {
        $this->timePlan = $timePlan;
    }

    /**
     * @return string|null
     */
    public function getTimeEaten(): ?string
    {
        return $this->timeEaten;
    }

    /**
     * @param string|null $timeEaten
     */
    public function setTimeEaten(?string $timeEaten): void
    {
        $this->timeEaten = $timeEaten;
    }

    /**
     * @return array list of changeable attributes
     */
    protected function getChangeableAttributes(): array
    {
        return [
            'mealId',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',
            'eaten',
            'timePlan',
            'timeEaten',
        ];
    }
}