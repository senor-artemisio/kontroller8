<?php

namespace App\Api\Repositories;

use App\Api\Models\Day;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Repository for day.
 */
class DayRepository
{
    /** @var Builder */
    private $day;

    /** @var array */
    private $columns = ['*'];

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
     * @param string $id
     * @return Day|Model
     * @throws ModelNotFoundException
     */
    public function findById(string $id): Day
    {
        return $this->day->findOrFail($id);
    }

    /**
     * Make collection of 7 days from a date.
     * For not existing days make empty day model.
     *
     * @param string $userId
     * @param Carbon $date
     * @return Collection
     */
    public function findWeekByOwner(string $userId, Carbon $date)
    {
        // get existing days from database
        $query = $this->day->where('user_id', $userId)
            ->whereBetween('date', [
                $date->copy()->subDays(3),
                $date->copy()->addDays(3)
            ]);
        $existsDays = $query->get($this->columns);
        $days = [];
        // set cursor to first day of week
        $dateCursor = $date->copy()->subDays(3);
        for ($i = 1; $i <= 7; $i++) {
            // find day in existing days
            $existDay = $existsDays->filter(function (Day $day) use ($dateCursor) {
                return $day->date->toDateString() === $dateCursor->toDateString();
            })->first();
            // if day not found replace it by new empty day model
            if ($existDay) {
                $days[] = $existDay;
            } else {
                $days[] = new Day(['date' => $dateCursor]);
            }
            // seek cursor to next day
            $dateCursor->addDay();
        }

        return collect($days);
    }
}