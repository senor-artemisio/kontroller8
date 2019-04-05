<?php

namespace App\Api\DTO;

/**
 * Data transfer object for meal.
 *
 * @property string $id
 * @property string $title
 * @property string $userId
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 */
class MealDTO extends BaseDTO
{
    use NutritionAttributes;

    /** @var string */
    protected $id;

    /** @var string */
    protected $title;

    /** @var string */
    protected $userId;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
        return ['title', 'userId', 'protein', 'fat', 'carbohydrates', 'fiber'];
    }
}