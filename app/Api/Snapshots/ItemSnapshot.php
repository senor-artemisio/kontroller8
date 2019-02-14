<?php

namespace App\Api\Snapshots;

use App\Api\Http\Requests\ItemStoreRequest;
use App\Api\Http\Requests\ItemUpdateRequest;

/**
 * Снимок для сущности «продукт».
 */
class ItemSnapshot
{
    /** @var array */
    private $attributes;

    /**
     * @param ItemStoreRequest $itemRequest
     * @return ItemSnapshot
     */
    public static function createFromStoreRequest(ItemStoreRequest $itemRequest): ItemSnapshot
    {
        $snapshot = new self();

        $snapshot->setId($itemRequest->get('id'));
        $snapshot->setTitle($itemRequest->get('title'));
        $snapshot->setProtein($itemRequest->get('protein'));
        $snapshot->setFat($itemRequest->get('fat'));
        $snapshot->setCarbohydrates($itemRequest->get('carbohydrates'));
        $snapshot->setFiber($itemRequest->get('fiber'));
        $snapshot->setUserId($itemRequest->get('user_id'));

        return $snapshot;
    }

    /**
     * @param ItemUpdateRequest $itemRequest
     * @return ItemSnapshot
     * @throws \ErrorException
     */
    public static function createFromUpdateRequest(ItemUpdateRequest $itemRequest): ItemSnapshot
    {
        $snapshot = new self();

        foreach ($itemRequest->all() as $attribute => $value) {
            switch ($attribute) {
                case 'title':
                    $snapshot->setTitle($value);
                    break;
                case 'protein':
                    $snapshot->setProtein($value);
                    break;
                case 'fat':
                    $snapshot->setFat($value);
                    break;
                case 'carbohydrates':
                    $snapshot->setCarbohydrates($value);
                    break;
                case 'fiber':
                    $snapshot->setFiber($value);
                    break;
                default:
                    throw new \ErrorException('Invalid item attribute');
            }
        }

        return $snapshot;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
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