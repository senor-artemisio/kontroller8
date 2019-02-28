<?php

namespace App\Api\Repositories;

use App\Api\Models\Day;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Repository for day entity.
 */
class DayRepository
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
        $this->item = Day::query();
    }

    /**
     * @param int $perPage
     * @return DayRepository
     */
    public function paginate(?int $perPage = 20): DayRepository
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param array $columns
     * @return DayRepository
     */
    public function columns(array $columns): DayRepository
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param ItemSnapshot $snapshot
     * @return Item|Model
     */
    public function create(ItemSnapshot $snapshot): Item
    {
        return $this->item->create([
            'id' => $snapshot->getId(),
            'title' => $snapshot->getTitle(),
            'protein' => $snapshot->getProtein(),
            'fat' => $snapshot->getFat(),
            'carbohydrates' => $snapshot->getCarbohydrates(),
            'fiber' => $snapshot->getFiber(),
            'user_id' => $snapshot->getUserId(),
        ]);
    }

    /**
     * @param Item $item
     * @param ItemSnapshot $snapshot
     * @return Item|Model
     */
    public function update(Item $item, ItemSnapshot $snapshot): Item
    {
        $item->update($snapshot->getAttributes());

        return $item;
    }

    /**
     * @param Item $item
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Item $item): ?bool
    {
        return $item->delete($item);
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