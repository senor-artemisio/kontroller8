<?php

namespace App\Api\Repositories;

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
}