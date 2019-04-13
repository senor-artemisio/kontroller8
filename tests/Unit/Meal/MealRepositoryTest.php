<?php

namespace Tests\Unit\Meal;

use App\Api\Repositories\MealRepository;
use App\Api\Models\Meal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @covers \App\Api\Repositories\MealRepository
 */
class MealRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var MealRepository */
    protected $repository;

    /** @var Meal */
    protected $meal;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(MealRepository::class);
        $this->meal = new Meal();
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::create()
     */
    public function testCreate(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->make();
        $attributes = $meal->attributesToArray();

        $this->repository->create($attributes);

        $this->assertDatabaseHas($this->meal->getTable(), $attributes);
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->create();
        $attributes = $meal->attributesToArray();
        $attributes['title'] = 'chicken breast';

        $this->repository->update($meal, $attributes);

        $this->assertDatabaseHas($this->meal->getTable(), [
            'id' => $meal->id,
            'title' => $attributes['title']
        ]);
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::delete()
     * @throws \Exception
     */
    public function testDelete(): void
    {
        $meal = factory(Meal::class)->create();
        $this->repository->delete($meal);
        $this->assertDatabaseMissing($this->meal->getTable(), ['id' => $meal->id]);
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::findById()
     */
    public function testFindById(): void
    {
        $meal = factory(Meal::class)->create();
        $mealFounded = $this->repository->findById($meal->id);

        $this->assertEquals($meal->id, $mealFounded->id);
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::findById()
     */
    public function testFindByIdNotExists(): void
    {
        factory(Meal::class)->create();
        $this->expectException(ModelNotFoundException::class);
        $this->repository->findById(\Ulid::generate());
    }

    /**
     * @covers \App\Api\Repositories\MealRepository::findByOwner()
     */
    public function testFindByOwner(): void
    {
        factory(Meal::class, 3)->create();
        $meal = factory(Meal::class)->create();

        $meals = $this->repository->findByOwner($meal->user_id);
        $this->assertCount(1, $meals);
        $this->assertEquals($meal->id, $meals->first()->id);
    }
}
