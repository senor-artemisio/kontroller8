<?php

namespace App\Api\Repositories;

use App\Api\Models\Day;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Working with day database data.
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
     * @throws Exception
     */
    public function delete(Day $day): ?bool
    {
        return $day->delete();
    }

    /**
     * @param string $dayId
     * @return Day|Model
     * @throws ModelNotFoundException
     */
    public function findById(string $dayId): Day
    {
        return $this->day->findOrFail($dayId);
    }


    /**
     * @param string $userId
     * @return Collection|LengthAwarePaginator
     */
    public function findByOwner(string $userId)
    {
        $query = $this->day->where('user_id', $userId);

        return $this->buildQuery($query);
    }


}