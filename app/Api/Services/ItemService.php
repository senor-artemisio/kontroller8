<?php

namespace App\Api\Services;

use App\Api\Repositories\ItemRepository;
use App\Api\Snapshots\ItemSnapshot;
use App\Api\Models\Item;

/**
 * Сервис для сущности «продукт»
 */
class ItemService
{
    /** @var ItemRepository */
    private $itemRepository;

    /**
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param ItemSnapshot $itemSnapshot
     */
    public function create(ItemSnapshot $itemSnapshot): void
    {
        $this->itemRepository->create($itemSnapshot);
    }

    /**
     * @param ItemSnapshot $itemSnapshot
     * @param Item $item
     */
    public function update(Item $item, ItemSnapshot $itemSnapshot): void
    {
        $this->itemRepository->update($item, $itemSnapshot);
    }

    /**
     * @param Item $item
     * @throws \Exception
     */
    public function delete(Item $item): void
    {
        $this->itemRepository->delete($item);
    }
}