<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\ItemStoreRequest;
use App\Api\Http\Requests\ItemUpdateRequest;
use App\Api\Http\Resources\ItemResource;
use App\Api\Repositories\ItemRepository;
use App\Api\Services\ItemService;
use App\Api\Snapshots\ItemSnapshot;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * API сущности «продукт»
 */
class ItemController extends Controller
{
    /** @var ItemService */
    private $itemService;

    /** @var ItemRepository */
    private $itemRepository;

    /**
     * @param ItemService $itemService
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemService $itemService, ItemRepository $itemRepository)
    {
        $this->itemService = $itemService;
        $this->itemRepository = $itemRepository;
    }

    /**
     * Список продуктов текущего пользователя.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $userId = Auth::user()->getAuthIdentifier();
        $items = $this->itemRepository->paginate()->findByOwner($userId);

        return ResourceCollection::make($items);
    }

    /**
     * Создание продукта для текущего пользователя.
     *
     * @param ItemStoreRequest $request
     * @return ItemResource
     */
    public function store(ItemStoreRequest $request): ItemResource
    {
        $snapshot = ItemSnapshot::createFromStoreRequest($request);
        $snapshot->setId(\Ulid::generate());
        $snapshot->setUserId(Auth::user()->getAuthIdentifier());

        $this->itemService->create($snapshot);
        $item = $this->itemRepository->findById($snapshot->getId());
        $item->wasRecentlyCreated = true;

        return ItemResource::make($item);
    }


    /**
     * @param ItemUpdateRequest $request
     * @param Item $item
     * @return ItemResource
     * @throws \ErrorException
     */
    public function update(Item $item, ItemUpdateRequest $request): ItemResource
    {
        $snapshot = ItemSnapshot::createFromUpdateRequest($request);

        $this->itemService->update($snapshot, $item);

        $updatedItem = $this->itemRepository->findById($item->id);

        return ItemResource::make($updatedItem);
    }
}