<?php

namespace App\Api\DTO;


/**
 * Data transfer object for meal.
 */
class PortionDTO extends BaseDTO
{
    use NutritionAttributes;

    /** @var string */
    protected $id;

    /** @var string */
    protected $mealId;

    /** @var integer */
    protected $weight;

    /** @var bool */
    protected $eaten;

    /** @var string|null */
    protected $time;

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
    public function getEaten(): bool
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
    public function getTime(): ?string
    {
        return $this->time;
    }

    /**
     * @param string|null $time
     */
    public function setTime(?string $time): void
    {
        $this->time = $time;
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
            'time',
        ];
    }
}