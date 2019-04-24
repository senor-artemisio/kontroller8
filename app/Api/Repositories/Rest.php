<?php

namespace App\Api\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * REST features for repository.
 */
trait Rest
{
    /** @var int */
    protected $perPage;

    /** @var string */
    protected $sortBy;

    /** @var string */
    protected $sortDirection;

    /** @var array */
    protected $columns = ['*'];

    /** @var array */
    protected $where = [];

    /**
     * @param int $perPage
     * @return static
     */
    public function paginate(int $perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @param string $attribute
     * @param string $direction
     * @return static
     */
    public function sort(string $attribute, string $direction)
    {
        $this->sortBy = $attribute;
        $this->sortDirection = $direction;

        return $this;
    }

    /**
     * @param array $columns
     * @return static
     */
    public function columns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @param string $column
     * @param $value
     * @return static
     */
    public function filter(string $column, $value)
    {
        $this->where[$column] = $value;

        return $this;
    }

    /**
     * @param Builder $query
     * @return LengthAwarePaginator|Collection
     */
    protected function buildQuery(Builder $query)
    {
        if ($this->sortBy !== null) {
            $query = $query->orderBy(snake_case($this->sortBy), $this->sortDirection);
        }

        if (!empty($this->where)) {
            foreach ($this->where as $attribute => $value) {
                $query->where($attribute, $value);
            }
        }

        if ($this->perPage !== null) {
            return $query->paginate($this->perPage, $this->columns);
        }

        return $query->get($this->columns);
    }
}