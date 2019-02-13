<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Requests\ItemCreateRequest;
use App\Api\Http\Resources\ItemResource;
use App\Api\Repositories\ItemRepository;
use App\Api\Services\ItemService;
use App\Api\Snapshots\ItemSnapshot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $userId = Auth::user()->getAuthIdentifier();
        $items = $this->itemRepository->paginate()->findByOwner($userId);

        return ItemResource::collection($items);
    }

    /**
     * Создание продукта для текущего пользователя.
     *
     * @param ItemCreateRequest $request
     * @return ItemResource
     */
    public function create(ItemCreateRequest $request): ItemResource
    {
        $id = Ulid::generate();
        $request->merge([
            'id' => $id,
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);

        $snapshot = ItemSnapshot::createFromRequest($request);
        $this->itemService->create($snapshot);
        $item = $this->itemRepository->findById($id);

        return ItemResource::make($item);
    }
}