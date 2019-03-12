<?php

namespace App\Api\Repositories;

use App\Api\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Repository for item.
 */
class ItemRepository
{
    /** @var Builder */
    private $item;

    /** @var int */
    private $perPage;

    /** @var array */
    private $columns = ['*'];

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->item = Item::query();
    }

    /**
     * @param int $perPage
     * @return ItemRepository
     */
    public function paginate(?int $perPage = 10): ItemRepository
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param array $columns
     * @return ItemRepository
     */
    public function columns(array $columns): ItemRepository
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param array $attributes
     * @return Item|Model
     */
    public function create(array $attributes): Item
    {
        return $this->item->create($attributes);
    }

    /**
     * @param Item $item
     * @param array $attributes
     * @return Item|Model
     */
    public function update(Item $item, array $attributes): Item
    {
        $item->update($attributes);

        return $item;
    }

    /**
     * @param Item $item
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Item $item): ?bool
    {
        return $item->delete();
    }

    /**
     * @param string $id
     * @return Item|Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(string $id): Item
    {
        return $this->item->findOrFail($id);
    }

    /**
     * @param string $id
     * @return Collection|LengthAwarePaginator
     */
    public function findByOwner(string $id)
    {
        $query = $this->item->where('user_id', $id);

        if ($this->perPage !== null) {
            return $query->paginate($this->perPage, $this->columns);
        }

        return $query->get($this->columns);
    }
}