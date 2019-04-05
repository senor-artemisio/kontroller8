<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Base HTTP request for any elements list.
 */
abstract class ItemsRequest extends FormRequest
{
    /**
     * @return array list of sortable attributes
     */
    abstract protected function getSortableAttributes(): array;

    /**
     * Validation rules for any elements list.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'page' => 'integer|required',
            'perPage' => 'integer|required',
            'sortBy' => ['string', 'required', Rule::in($this->getSortableAttributes())],
            'sortDirection' => 'string|required|in:asc,desc',
        ];

        return $rules;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return (int)$this->get('perPage');
    }

    /**
     * @return string
     */
    public function getSortBy(): string
    {
        return $this->get('sortBy');
    }

    /**
     * @return string
     */
    public function getSortDirection(): string
    {
        return $this->get('sortDirection');
    }
}