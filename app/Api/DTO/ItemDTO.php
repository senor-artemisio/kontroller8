<?php

namespace App\Api\DTO;

/**
 * Data transfer object for item.
 */
class ItemDTO extends BaseDTO
{
    use NutritionAttributes;

    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $userId;

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
     * @return array
     */
    public function getChangedAttributes(): array
    {
        $attributes = [];
        foreach (['title', 'userId', 'protein', 'fat', 'carbohydrates', 'fiber'] as $attribute) {
            if ($this->$attribute !== null) {
                $attributes[snake_case($attribute)] = $this->$attribute;
            }
        }

        return $attributes;
    }
}