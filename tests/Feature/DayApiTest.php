<?php

namespace Tests\Feature;

use App\Api\Models\Day;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Api\Http\Controllers\DayController
 */
class DayApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private $user;

    /** @var Day */
    protected $dayModel;

    /** @var */
    private $weekDates;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->dayModel = new Day();
        $this->user = factory(User::class)->create();
        $this->weekDates = [
            '1999-12-29', '1999-12-30', '1999-12-31', '2000-01-01', '2000-01-02', '2000-01-03', '2000-01-04'
        ];
    }

    /**
     * Check get week for date without existing days.
     *
     * @covers \App\Api\Http\Controllers\DayController::week()
     */
    public function testIndexNotExists(): void
    {
        factory(Day::class)->create();

        $response = $this->actingAs($this->user, 'api')->getJson('/api/days/week/2000-01-01');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(7, $data);

        foreach ($this->weekDates as $key => $date) {
            $this->assertEquals($date, $data[$key]['date']);
        }
    }

    /**
     * Check get week for date with existing days.
     *
     * @covers \App\Api\Http\Controllers\DayController::week()
     */
    public function testWeekExists(): void
    {
        $expectedDays = collect([]);

        foreach ($this->weekDates as $date) {
            $expectedDays->push(factory(Day::class)->create([
                'user_id' => $this->user->id,
                'date' => Carbon::parse($date)
            ]));
        }

        $response = $this->actingAs($this->user, 'api')->getJson('/api/days/week/2000-01-01');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(7, $data);

        $expectedDays->each(function (Day $day, int $key) use ($data) {
            $this->assertEquals($day->id, $data[$key]['id']);
            $this->assertEquals($day->date->toDateString(), $data[$key]['date']);
        });
    }

    /**
     * Check get week for date with partially existing days.
     *
     * @covers \App\Api\Http\Controllers\DayController::week()
     */
    public function testWeekPartiallyExists(): void
    {
        $expectedDays = collect([]);

        foreach ($this->weekDates as $key => $date) {
            if ($key === 3 || $key === 5) {
                $expectedDay = new Day([
                    'id' => null,
                    'date' => Carbon::parse($date),
                ]);
            } else {
                $expectedDay = factory(Day::class)->create([
                    'user_id' => $this->user->id,
                    'date' => Carbon::parse($date),
                ]);
            }
            $expectedDays->push($expectedDay);
        }

        $response = $this->actingAs($this->user, 'api')->getJson('/api/days/week/2000-01-01');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(7, $data);

        $expectedDays->each(function (Day $expectedDay, int $key) use ($data) {
            $this->assertEquals($expectedDay->id, $data[$key]['id']);
            $this->assertEquals($expectedDay->date->toDateString(), $data[$key]['date']);
        });
    }

    /**
     * Check day with portions.
     *
     * @covers \App\Api\Http\Controllers\DayController::week()
     */
    public function testWeekWithPortions(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->create([
            'user_id' => $this->user->id,
            'date' => '2000-01-01'
        ]);

        /** @var Collection $meals */
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);

        /** @var Collection $portions */
        $portion = factory(Portion::class)->create([
            'day_id' => $day->id,
            'user_id' => $this->user->id,
            'meal_id' => $meal->id
        ]);

        $response = $this->actingAs($this->user, 'api')->getJson('/api/days/week/2000-01-01');
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $portionsData = $data[3]['portions'];
        $this->assertEquals($portion->id, $portionsData[0]['id']);
    }
}