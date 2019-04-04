<?php

namespace App\Api\Services;

use App\Api\DTO\ItemDTO;
use App\Api\Repositories\ItemRepository;
use App\Api\Models\Item;

/**
 * Business logic for item.
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
     * @param ItemDTO $dto
     * @param string $userId
     */
    public function create(ItemDTO $dto, string $userId): void
    {
        $dto->userId=$userId;
        $this->itemRepository->create([
            'id' => $dto->id,
            'title' => $dto->title,
            'user_id' => $dto->userId,
            'protein' => $dto->protein,
            'fat' => $dto->fat,
            'carbohydrates' => $dto->carbohydrates,
            'fiber' => $dto->fiber,
        ]);
    }

    /**
     * @param ItemDTO $dto
     * @param Item $item
     */
    public function update(Item $item, ItemDTO $dto): void
    {
        $this->itemRepository->update($item, $dto->getChangedValues());
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