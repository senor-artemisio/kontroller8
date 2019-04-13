<?php

namespace App\Api\Repositories;

use App\Api\Models\Meal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Working with meal database data.
 */
class MealRepository
{
    use Rest;

    /** @var Builder */
    private $meal;

    /**
     * Init repo.
     */
    public function __construct()
    {
        $this->meal = Meal::query();
    }

    /**
     * @param array $attributes
     * @return Meal|Model
     */
    public function create(array $attributes): Meal
    {
        return $this->meal->create($attributes);
    }

    /**
     * @param Meal $meal
     * @param array $attributes
     * @return Meal|Model
     */
    public function update(Meal $meal, array $attributes): Meal
    {
        $meal->update($attributes);

        return $meal;
    }

    /**
     * @param Meal $meal
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Meal $meal): ?bool
    {
        return $meal->delete();
    }

    /**
     * @param string $mealId
     * @return Meal|Model
     * @throws ModelNotFoundException
     */
    public function findById(string $mealId): Meal
    {
        return $this->meal->findOrFail($mealId);
    }

    /**
     * @param string $userId
     * @return Collection|LengthAwarePaginator
     */
    public function findByOwner(string $userId)
    {
        $query = $this->meal->where('user_id', $userId);

        return $this->buildQuery($query);
    }
}