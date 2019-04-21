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

    /** @var integer */
    protected $calories;

    /** @var float */
    protected $proteinEaten;

    /** @var float */
    protected $fatEaten;

    /** @var float */
    protected $carbohydratesEaten;

    /** @var float */
    protected $fiberEaten;

    /** @var float */
    protected $weightEaten;

    /** @var integer */
    protected $caloriesEaten;

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
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getProteinEaten(): float
    {
        return $this->proteinEaten;
    }

    /**
     * @param float $proteinEaten
     */
    public function setProteinEaten(float $proteinEaten): void
    {
        $this->proteinEaten = $proteinEaten;
    }

    /**
     * @return float
     */
    public function getFatEaten(): float
    {
        return $this->fatEaten;
    }

    /**
     * @param float $fatEaten
     */
    public function setFatEaten(float $fatEaten): void
    {
        $this->fatEaten = $fatEaten;
    }

    /**
     * @return float
     */
    public function getCarbohydratesEaten(): float
    {
        return $this->carbohydratesEaten;
    }

    /**
     * @param float $carbohydratesEaten
     */
    public function setCarbohydratesEaten(float $carbohydratesEaten): void
    {
        $this->carbohydratesEaten = $carbohydratesEaten;
    }

    /**
     * @return float
     */
    public function getFiberEaten(): float
    {
        return $this->fiberEaten;
    }

    /**
     * @param float $fiberEaten
     */
    public function setFiberEaten(float $fiberEaten): void
    {
        $this->fiberEaten = $fiberEaten;
    }

    /**
     * @return int
     */
    public function getWeightEaten(): int
    {
        return $this->weightEaten;
    }

    /**
     * @param int $weightEaten
     */
    public function setWeightEaten(int $weightEaten): void
    {
        $this->weightEaten = $weightEaten;
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
    public function getCalories(): float
    {
        return $this->calories;
    }

    /**
     * @param float $calories
     */
    public function setCalories(float $calories): void
    {
        $this->calories = $calories;
    }

    /**
     * @return int
     */
    public function getCaloriesEaten(): int
    {
        return $this->caloriesEaten;
    }

    /**
     * @param int $caloriesEaten
     */
    public function setCaloriesEaten(int $caloriesEaten): void
    {
        $this->caloriesEaten = $caloriesEaten;
    }

    /**
     * {@inheritdoc}
     */
    protected function getChangeableAttributes(): array
    {
        return [
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',
            'calories',
            'proteinEaten',
            'fatEaten',
            'carbohydratesEaten',
            'fiberEaten',
            'weightEaten',
            'caloriesEaten',
        ];
    }
}