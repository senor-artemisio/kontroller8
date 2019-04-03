<?php

namespace App\Api\DTO;

/**
 * Data transfer object for day.
 */
class DayDTO extends BaseDTO
{
    use NutritionAttributes;

    /** @var string */
    protected $id;

    /** @var string */
    protected $date;

    /** @var string */
    protected $userId;

    /** @var float */
    protected $weight;

    /** @var float */
    protected $weight_eaten;

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
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return float
     */
    public function getWeightEaten(): float
    {
        return $this->weight_eaten;
    }

    /**
     * @param float $weightEaten
     */
    public function setWeightEaten(float $weightEaten): void
    {
        $this->weight_eaten = $weightEaten;
    }

    /**
     * {@inheritdoc}
     */
    protected function getChangeableAttributes(): array
    {
        return [];
    }
}