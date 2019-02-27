<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\ItemRequest;
use App\Api\Http\Resources\ItemResource;
use App\Api\Repositories\ItemRepository;
use App\Api\Services\ItemService;
use App\Api\Snapshots\ItemSnapshot;
use App\Http\Controllers\Controller;
use App\Api\Models\Item;
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
     * @param ItemRequest $request
     * @return ItemResource
     */
    public function store(ItemRequest $request): ItemResource
    {
        $snapshot = ItemSnapshot::createFromRequestStore($request);
        $snapshot->setId(\Ulid::generate());
        $snapshot->setUserId(Auth::user()->getAuthIdentifier());

        $this->itemService->create($snapshot);
        $item = $this->itemRepository->findById($snapshot->getId());
        $item->wasRecentlyCreated = true;

        return ItemResource::make($item);
    }


    /**
     * @param Item $item
     * @param ItemRequest $request
     * @return ItemResource
     * @throws \ErrorException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Item $item, ItemRequest $request): ItemResource
    {
        $this->authorize('update', $item);

        $snapshot = ItemSnapshot::createFromRequestUpdate($request);

        $this->itemService->update($item, $snapshot);

        $updatedItem = $this->itemRepository->findById($item->id);

        return ItemResource::make($updatedItem);
    }

    /**
     * @param Item $item
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $this->itemService->delete($item);

        return response()->json(null, 204);
    }
}