<?php

namespace Tests\Unit\Portion;

use App\Api\DTO\DTOException;
use App\Api\DTO\MealDTO;
use App\Api\DTO\PortionDTO;
use App\Api\Models\Day;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Models\User;
use App\Api\Services\PortionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Api\Services\PortionService
 */
class PortionServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var PortionService */
    private $service;

    /** @var Portion */
    private $portion;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->portion = new Portion();
        $this->service = app()->make(PortionService::class);
    }

    /**
     * @return void
     * @throws DTOException
     * @see PortionService::create()
     */
    public function testCreate(): void
    {
        $user = factory(User::class)->create();
        $day = factory(Day::class)->create(['user_id' => $user->id]);
        $meal = factory(Meal::class)->create(['user_id' => $user->id]);
        $portion = factory(Portion::class)->make([
            'meal_id' => $meal->id,
            'weight' => 100,
        ]);
        $attributes = $portion->attributesToArray();
        unset(
            $attributes['created_at'],
            $attributes['updated_at'],
            $attributes['user_id'],
            $attributes['calories'],
            $attributes['day_id']
        );

        $portionDTO = new PortionDTO($attributes);
        $mealDTO = MealDTO::createFromModel($meal);
        $this->service->create($portionDTO, $mealDTO, $user->id, $day->id);

        $attributes['user_id'] = $user->id;
        $attributes['day_id'] = $day->id;
        $this->assertDatabaseHas($this->portion->getTable(), $attributes);
    }

    /**
     * @throws DTOException
     * @throws \Exception
     * @covers  \App\Api\Services\PortionService::update()
     */
    public function testUpdate(): void
    {
        /** @var Portion $portion */
        $portion = factory(Portion::class)->create();
        $attributes = ['weight' => 100];
        $portionDTO = new PortionDTO($attributes);

        $this->service->update($portion, $portionDTO);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'weight' => 100,
            'protein' => $portion->meal->protein,
            'fat' => $portion->meal->fat,
            'carbohydrates' => $portion->meal->carbohydrates,
            'fiber' => $portion->meal->fiber,
        ]);
    }

    /**
     * @throws DTOException
     * @throws \Exception
     * @covers  \App\Api\Services\PortionService::update()
     */
    public function testUpdateMeal(): void
    {
        /** @var Portion $portion */
        $portion = factory(Portion::class)->create();
        $attributes = ['weight' => 100];
        $meal = factory(Meal::class)->create(['user_id' => $portion->user_id]);

        $portionDTO = new PortionDTO($attributes);
        $mealDTO = MealDTO::createFromModel($meal);

        $this->service->update($portion, $portionDTO, $mealDTO);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'weight' => 100,
            'protein' => $meal->protein,
            'fat' => $meal->fat,
            'carbohydrates' => $meal->carbohydrates,
            'fiber' => $meal->fiber,
        ]);
    }

    /**
     * @throws \Exception
     * @covers  \App\Api\Services\PortionService::delete()
     */
    public function testDelete(): void
    {
        $portion = factory(Portion::class)->create();
        $this->service->delete($portion);
        $this->assertDatabaseMissing($this->portion->getTable(), ['id' => $portion->id]);
    }
}