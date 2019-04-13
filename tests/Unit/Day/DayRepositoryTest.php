<?php

namespace Tests\Unit\Day;

use App\Api\Models\Day;
use App\Api\Repositories\DayRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Api\Repositories\DayRepository
 */
class DayRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var DayRepository */
    protected $repository;

    /** @var Day */
    protected $day;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(DayRepository::class);
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

        $this->repository->create($attributes);

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
        $attributes['fat'] = 3;

        $this->repository->update($day, $attributes);

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
        $this->repository->delete($day);
        $this->assertDatabaseMissing($this->day->getTable(), ['id' => $day->id]);
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::findById()
     */
    public function testFindById(): void
    {
        $day = factory(Day::class)->create();
        $dayFounded = $this->repository->findById($day->id);

        $this->assertEquals($day->id, $dayFounded->id);
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::findById()
     */
    public function testFindByIdNotExists(): void
    {
        factory(Day::class)->create();
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(\Ulid::generate());
    }

    /**
     * @covers \App\Api\Repositories\DayRepository::findByOwner()
     */
    public function testFindByOwner(): void
    {
        factory(Day::class, 3)->create();
        $day = factory(Day::class)->create();

        $meals = $this->repository->findByOwner($day->user_id);
        $this->assertCount(1, $meals);
        $this->assertEquals($day->id, $meals->first()->id);
    }
}