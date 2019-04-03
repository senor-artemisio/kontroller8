<?php

namespace Tests\Unit;

use App\Api\Models\Day;
use App\Api\Repositories\DayRepository;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    protected $day;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->dayRepository = $this->app->make(DayRepository::class);
        $this->day = new Day();
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

        $this->assertDatabaseHas($this->day->getTable(), $attributes);
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->create();
        $attributes = $day->attributesToArray();
        $attributes['fat'] = 2.9;

        $this->dayRepository->update($day, $attributes);

        $this->assertDatabaseHas($this->day->getTable(), [
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
        $this->assertDatabaseMissing($this->day->getTable(), ['id' => $day->id]);
    }
}