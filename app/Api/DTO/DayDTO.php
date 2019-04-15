<?php

namespace App\Api\DTO;

/**
 * Data transfer object for day.
 *
 * @property string $id
 * @property string $date
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property float $proteinEaten
 * @property float $fatEaten
 * @property float $carbohydratesEaten
 * @property float $fiberEaten
 * @property integer $weightEaten
 * @property integer $weight
 *
 * @property string $userId
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
    protected $weightEaten;

    /** @var float */
    protected $proteinEaten;

    /** @var float */
    protected $fatEaten;

    /** @var float */
    protected $carbohydratesEaten;

    /** @var float */
    protected $fiberEaten;

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
            'proteinEaten',
            'fatEaten',
            'carbohydratesEaten',
            'fiberEaten',
            'weightEaten',
        ];
    }
}