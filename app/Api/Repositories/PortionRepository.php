<?php

namespace App\Api\Repositories;

use App\Api\Models\Portion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 *
 */
class PortionRepository
{
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
     * @param string $dayId
     * @return Builder[]|Collection
     */
    public function findByDayId(string $dayId): Collection
    {
        return $this->portion->where('day_id', $dayId)->orderBy('time_plan')->get(['*']);
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
}