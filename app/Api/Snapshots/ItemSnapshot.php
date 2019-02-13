<?php

namespace App\Api\Snapshots;

use App\Api\Http\Requests\ItemCreateRequest;

/**
 * Снимок для сущности «продукт».
 */
class ItemSnapshot
{
    /** @var array */
    private $attributes;

    /**
     * @param ItemCreateRequest $itemRequest
     * @return ItemSnapshot
     */
    public static function createFromRequest(ItemCreateRequest $itemRequest): ItemSnapshot
    {
        $snapshot = new self();

        $snapshot->setId($itemRequest->get('id'));
        $snapshot->setTitle($itemRequest->get('title'));
        $snapshot->setProtein((float)$itemRequest->get('protein'));
        $snapshot->setFat((float)$itemRequest->get('fat'));
        $snapshot->setCarbohydrates((float)$itemRequest->get('carbohydrates'));
        $snapshot->setFiber((float)$itemRequest->get('fiber'));
        $snapshot->setUserId($itemRequest->get('user_id'));

        return $snapshot;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->attributes['id'] ?? null;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->attributes['id'] = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->attributes['title'] ?? null;
    }

    /**
     * @param  string|null
     */
    public function setTitle(?string $title): void
    {
        $this->attributes['title'] = $title;
    }

    /**
     * @return float|null
     */
    public function getProtein(): ?float
    {
        return $this->attributes['protein'] ?? null;
    }

    /**
     * @param float|null
     */
    public function setProtein(?float $protein): void
    {
        $this->attributes['protein'] = $protein;
    }

    /**
     * @return float|null
     */
    public function getFat(): ?float
    {
        return $this->attributes['fat'] ?? null;
    }

    /**
     * @param float|null
     */
    public function setFat(?float $fat): void
    {
        $this->attributes['fat'] = $fat;
    }

    /**
     * @return float|null
     */
    public function getCarbohydrates(): ?float
    {
        return $this->attributes['carbohydrates'] ?? null;
    }

    /**
     * @param float|null
     */
    public function setCarbohydrates(?float $carbohydrates): void
    {
        $this->attributes['carbohydrates'] = $carbohydrates;
    }

    /**
     * @return float|null
     */
    public function getFiber(): ?float
    {
        return $this->attributes['fiber'] ?? null;
    }

    /**
     * @param float|null
     */
    public function setFiber(?float $fiber): void
    {
        $this->attributes['fiber'] = $fiber;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->attributes['user_id'] ?? null;
    }

    /**
     * @param string|null
     */
    public function setUserId(?string $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }
}