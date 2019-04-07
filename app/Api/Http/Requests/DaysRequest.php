<?php

namespace App\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

/**
 * HTTP-request for days request.
 */
class DaysRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => 'date|required'
        ];
    }

    /**
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        $date = $this->all(['date'])['date'] ?? null;
        if ($date === null) {
            return null;
        }

        return Carbon::parse($date);
    }

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['date'] = $this->route('date');

        return $data;
    }
}