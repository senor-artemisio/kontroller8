<?php

namespace Tests\Unit\Meal;

use App\Api\DTO\DTOException;
use App\Api\DTO\MealDTO;
use App\Api\Models\User;
use App\Api\Services\MealService;
use App\Api\Models\Meal;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @covers \App\Api\Services\MealService
 */
class MealServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var MealService */
    protected $service;

    /** @var Meal */
    protected $meal;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(MealService::class);
        $this->meal = new Meal();
    }

    /**
     * @return void
     * @throws DTOException
     * @covers  \App\Api\Services\MealService::create()
     */
    public function testCreate(): void
    {
        $meal = factory(Meal::class)->make();
        $user = factory(User::class)->create();

        $attributes = $meal->attributesToArray();
        unset($attributes['created_at'], $attributes['updated_at'], $attributes['user_id']);

        $dto = new MealDTO($attributes);
        $this->service->create($dto, $user->id);

        $attributes['user_id'] = $user->id;
        $this->assertDatabaseHas($this->meal->getTable(), $attributes);
    }

    /**
     * @throws DTOException
     * @covers  \App\Api\Services\MealService::update()
     */
    public function testUpdate(): void
    {
        $meal = factory(Meal::class)->create();
        $attributes = ['title' => 'chicken breast'];
        $dto = new MealDTO($attributes);

        $this->service->update($meal, $dto);

        $this->assertDatabaseHas($this->meal->getTable(), [
            'id' => $meal->id,
            'title' => $attributes['title']
        ]);
    }

    /**
     * @throws \Exception
     * @covers  \App\Api\Services\MealService::delete()
     */
    public function testDelete(): void
    {
        $meal = factory(Meal::class)->create();
        $this->service->delete($meal);
        $this->assertDatabaseMissing($this->meal->getTable(), ['id' => $meal->id]);
    }
}
