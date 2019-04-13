<?php

namespace App\Api\Repositories;

use App\Api\Models\Portion;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *  Working with portion database data.
 */
class PortionRepository
{
    use Rest;

    /** @var Builder */
    private $portion;

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->portion = Portion::query();
    }

    /**
     * @param array $attributes
     * @return Portion|Model
     */
    public function create(array $attributes): Portion
    {
        return $this->portion->create($attributes);
    }

    /**
     * @param Portion $portion
     * @param array $attributes
     * @return Portion
     */
    public function update(Portion $portion, array $attributes): Portion
    {
        $portion->update($attributes);

        return $portion;
    }

    /**
     * @param Portion $portion
     * @return bool|null
     * @throws Exception
     */
    public function delete(Portion $portion): ?bool
    {
        return $portion->delete();
    }

    /**
     * @param string $portionId
     * @return Portion
     */
    public function findById(string $portionId): Portion
    {
        return $this->portion->findOrFail($portionId);
    }

    /**
     * @param string $dayId
     * @return LengthAwarePaginator|Collection
     */
    public function findByDay(string $dayId)
    {
        $query = $this->portion->where('day_id', $dayId);


        return $this->buildQuery($query);
    }
}