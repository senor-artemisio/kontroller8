<?php

namespace App\Api\DTO;

use App\Api\Models\Meal;

/**
 * Data transfer object for meal.
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

    /** @var int */
    protected $calories;

    /**
     * @param Meal $meal
     * @return MealDTO
     * @throws DTOException
     */
    public static function createFromModel(Meal $meal): MealDTO
    {
        $attributes = $meal->attributesToArray();
        unset($attributes['updated_at'], $attributes['created_at']);
        return new static($attributes);
    }

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
     * @return int
     */
    public function getCalories(): int
    {
        return $this->calories;
    }

    /**
     * @param int $calories
     */
    public function setCalories(int $calories): void
    {
        $this->calories = $calories;
    }

    /**
     * {@inheritdoc}
     */
    protected function getChangeableAttributes(): array
    {
        return ['title', 'userId', 'protein', 'fat', 'carbohydrates', 'fiber', 'calories'];
    }
}