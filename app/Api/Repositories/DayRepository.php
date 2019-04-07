<?php

namespace App\Api\Repositories;

use App\Api\Models\Day;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
     * Make collection of 7 days for a date.
     * For not existing days make empty day model.
     *
     * @param string $userId
     * @param Carbon $date
     * @return Collection
     */
    public function findWeekByOwner(string $userId, Carbon $date)
    {
        // get existing days with portions from database
        $query = $this->day
            ->with([
                'portions' => function (HasMany $query) {
                    $query->orderBy('time_plan', 'asc');
                },
                'portions.meal'
            ])
            ->where('user_id', $userId)
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
            $day = $existsDays->filter(function (Day $day) use ($dateCursor) {
                return $day->date->toDateString() === $dateCursor->toDateString();
            })->first();

            // if day not found replace it by new empty day model
            if ($day === null) {
                $day = new Day([
                    'protein' => 0,
                    'fat' => 0,
                    'carbohydrates' => 0,
                    'fiber' => 0,
                    'weight' => 0,
                    'protein_eaten' => 0,
                    'fat_eaten' => 0,
                    'carbohydrates_eaten' => 0,
                    'fiber_eaten' => 0,
                    'weight_eaten' => 0,
                    'date' => $dateCursor,
                ]);
                $day->created_at = $dateCursor;
                $day->updated_at = $dateCursor;
            }

            $days[] = $day;

            // seek cursor to next day
            $dateCursor->addDay();
        }

        return collect($days);
    }
}