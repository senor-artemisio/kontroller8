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
 * @property integer $proteinEaten
 * @property integer $fatEaten
 * @property integer $carbohydratesEaten
 * @property integer $fiberEaten
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

    /** @var integer */
    protected $weight;

    /** @var integer */
    protected $weightEaten;

    /** @var integer */
    protected $proteinEaten;

    /** @var integer */
    protected $fatEaten;

    /** @var integer */
    protected $carbohydratesEaten;

    /** @var integer */
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
     * @return int
     */
    public function getProteinEaten(): int
    {
        return $this->proteinEaten;
    }

    /**
     * @param int $proteinEaten
     */
    public function setProteinEaten(int $proteinEaten): void
    {
        $this->proteinEaten = $proteinEaten;
    }

    /**
     * @return int
     */
    public function getFatEaten(): int
    {
        return $this->fatEaten;
    }

    /**
     * @param int $fatEaten
     */
    public function setFatEaten(int $fatEaten): void
    {
        $this->fatEaten = $fatEaten;
    }

    /**
     * @return int
     */
    public function getCarbohydratesEaten(): int
    {
        return $this->carbohydratesEaten;
    }

    /**
     * @param int $carbohydratesEaten
     */
    public function setCarbohydratesEaten(int $carbohydratesEaten): void
    {
        $this->carbohydratesEaten = $carbohydratesEaten;
    }

    /**
     * @return int
     */
    public function getFiberEaten(): int
    {
        return $this->fiberEaten;
    }

    /**
     * @param int $fiberEaten
     */
    public function setFiberEaten(int $fiberEaten): void
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