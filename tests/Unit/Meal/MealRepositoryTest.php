<?php

namespace Tests\Unit\Meal;

use App\Api\Repositories\MealRepository;
use App\Api\Models\Meal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @see MealRepository
 */
class MealRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @var MealRepository */
    protected $mealRepository;

    /** @var Meal */
    protected $meal;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->mealRepository = $this->app->make(MealRepository::class);
        $this->meal = new Meal();
    }

    /**
     * @return void
     * @see MealRepository::create()
     */
    public function testCreate(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->make();
        $attributes = $meal->attributesToArray();

        $this->mealRepository->create($attributes);

        $this->assertDatabaseHas($this->meal->getTable(), $attributes);
    }

    /**
     * @see MealRepository::update()
     */
    public function testUpdate(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->create();
        $attributes = $meal->attributesToArray();
        $attributes['title'] = 'chicken breast';

        $this->mealRepository->update($meal, $attributes);

        $this->assertDatabaseHas($this->meal->getTable(), [
            'id' => $meal->id,
            'title' => $attributes['title']
        ]);
    }

    /**
     * @throws \Exception
     *@see MealRepository::delete()
     */
    public function testDelete(): void
    {
        $meal = factory(Meal::class)->create();
        $this->mealRepository->delete($meal);
        $this->assertDatabaseMissing($this->meal->getTable(), ['id' => $meal->id]);
    }
}
