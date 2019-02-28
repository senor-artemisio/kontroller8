<?php

namespace App\Api\Services;

use App\Api\Repositories\ItemRepository;
use App\Api\Models\Item;
use Illuminate\Support\Facades\Auth;

/**
 * Service for item entity.
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
     * @param array $attributes
     */
    public function create(array $attributes): void
    {
        $attributes['user_id'] = Auth::user()->getAuthIdentifier();
        $this->itemRepository->create($attributes);
    }

    /**
     * @param array $attributes
     * @param Item $item
     */
    public function update(Item $item, array $attributes): void
    {
        $this->itemRepository->update($item, $attributes);
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