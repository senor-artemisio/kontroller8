<?php

namespace Tests\Unit\Day;

use App\Api\Models\Day;
use App\Api\Models\User;
use App\Api\Repositories\DayRepository;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Api\Repositories\DayRepository
 */
class DayRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var DayRepository */
    protected $dayRepository;

    /** @var Day */
    protected $dayModel;

    /** @var User */
    private $user;

    /** @var */
    private $weekDates;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->dayRepository = $this->app->make(DayRepository::class);
        $this->dayModel = new Day();
        $this->user = factory(User::class)->create();
        $this->weekDates = [
            '1999-12-29', '1999-12-30', '1999-12-31', '2000-01-01', '2000-01-02', '2000-01-03', '2000-01-04'
        ];
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::create
     */
    public function testCreate(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->make();
        $attributes = $day->attributesToArray();

        $this->dayRepository->create($attributes);

        $this->assertDatabaseHas($this->dayModel->getTable(), $attributes);
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->create();
        $attributes = $day->attributesToArray();
        $attributes['fat'] = 3;

        $this->dayRepository->update($day, $attributes);

        $this->assertDatabaseHas($this->dayModel->getTable(), [
            'id' => $day->id,
            'fat' => $attributes['fat']
        ]);
    }

    /**
     * @covers  \App\Api\Repositories\DayRepository::delete()
     * @throws Exception
     */
    public function testDelete(): void
    {
        $day = factory(Day::class)->create();
        $this->dayRepository->delete($day);
        $this->assertDatabaseMissing($this->dayModel->getTable(), ['id' => $day->id]);
    }

    /**
     * Check find week for date without existing days.
     */
    public function testFindWeekByOwnerNotExists(): void
    {
        $date = Carbon::parse('2000-01-01 00:00:00');
        $days = $this->dayRepository->findWeekByOwner($this->user->id, $date);

        foreach ($this->weekDates as $key => $date) {
            $this->assertEquals($days->get($key)->date, Carbon::parse($date));
        }
    }

    /**
     * Check find week for date with existing days.
     */
    public function testFindWeekByOwnerExists(): void
    {
        $expectedDays = collect([]);

        foreach ($this->weekDates as $date) {
            $expectedDays->push(factory(Day::class)->create([
                'user_id' => $this->user->id,
                'date' => Carbon::parse($date)
            ]));
        }

        $days = $this->dayRepository->findWeekByOwner($this->user->id, Carbon::parse('2000-01-01'));

        $expectedDays->each(function (Day $day, int $key) use ($days) {
            $this->assertEquals($day->toArray(), $days->get($key)->toArray());
        });
    }

    /**
     * Check find week for date with partially existing days.
     */
    public function testFindWeekByOwnerPartialExists(): void
    {
        $expectedDays = collect([]);

        foreach ($this->weekDates as $key => $date) {
            if ($key === 3 || $key === 5) {
                $expectedDay = new Day(['date' => Carbon::parse($date)]);
            } else {
                $expectedDay = factory(Day::class)->create([
                    'user_id' => $this->user->id,
                    'date' => Carbon::parse($date)
                ]);
            }
            $expectedDays->push($expectedDay);
        }

        $days = $this->dayRepository->findWeekByOwner($this->user->id, Carbon::parse('2000-01-01'));

        $expectedDays->each(function (Day $day, int $key) use ($days) {
            $this->assertEquals($day->toArray(), $days->get($key)->toArray());
        });
    }
}