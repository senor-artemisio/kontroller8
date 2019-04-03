<?php

namespace App\Api\Repositories;

use App\Api\DTO\DayDTO;
use App\Api\Models\Day;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Repository for day.
 */
class DayRepository
{
    use Rest;

    /** @var Builder */
    private $day;

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->day = Day::query();
    }

    /**
     * @param array $attributes
     * @return Day|Model
     */
    public function create(array $attributes): Day
    {
        return $this->day->create($attributes);
    }

    /**
     * @param Day $day
     * @param array $attributes
     * @return Day|Model
     */
    public function update(Day $day, array $attributes): Day
    {
        $day->update($attributes);

        return $day;
    }

    /**
     * @param Day $day
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Day $day): ?bool
    {
        return $day->delete();
    }

    /**
     * @param string $id
     * @return Day|Model
     * @throws ModelNotFoundException
     */
    public function findById(string $id): Day
    {
        return $this->day->findOrFail($id);
    }

    /**
     * @param string $id
     * @return Collection|LengthAwarePaginator
     */
    public function findByOwner(string $id)
    {
        $query = $this->day->where('user_id', $id);

        if ($this->sortBy !== null) {
            $query = $query->orderBy(snake_case($this->sortBy), $this->sortDirection);
        }

        if ($this->perPage !== null) {
            return $query->paginate($this->perPage, $this->columns);
        }

        return $query->get($this->columns);
    }
}