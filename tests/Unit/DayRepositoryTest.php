<?php

namespace Tests\Unit;

use App\Api\Models\Day;
use App\Api\Repositories\DayRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
     * @see DayRepository::create()
     */
    public function testCreate(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->make();
        $attributes = $day->attributesToArray();

        $this->dayRepository->create($attributes);

        $this->assertDatabaseHas($this->day->getTable(), $attributes);
    }
}