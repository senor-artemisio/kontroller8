<?php

namespace Tests\Feature;

use App\Api\Models\Day;
use App\Api\Models\Meal;
use App\Api\Models\Portion;
use App\Api\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature test for portion API.
 *
 * @covers \App\Api\Http\Controllers\PortionController
 */
class PortionApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var Portion */
    private $portion;

    /** @var Day */
    private $day;

    /** @var User */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->portion = new Portion();
        $this->day = new Day();
    }

    /**
     * Check view portions list for unauthorized user.
     *
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testIndexUnauthorized(): void
    {
        $day = factory(Day::class)->create();
        $this->getJson("/api/days/{$day->id}/portions?page=1&perPage=10&sortBy=time&sortDirection=asc")
            ->assertStatus(401);
    }

    /**
     * Check view portions list for not exists day.
     *
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testIndexNotExists(): void
    {
        $dayId = \Ulid::generate();
        $this->getJson("/api/days/$dayId/portions")->assertStatus(401);
        $this->actingAs($this->user, 'api')
            ->getJson("/api/days/$dayId/portions?page=1&perPage=10&sortBy=time&sortDirection=asc")
            ->assertStatus(404);
    }

    /**
     * Check view portions list for day owner.
     *
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testIndexOwner(): void
    {
        factory(Portion::class, 3)->create();
        $day = factory(Day::class)->create(['user_id' => $this->user->id]);
        $portions = factory(Portion::class, 3)->create(['day_id' => $day->id, 'user_id' => $day->user_id]);

        $response = $this->actingAs($this->user, 'api')
            ->getJson("/api/days/{$day->id}/portions?page=1&perPage=10&sortBy=time&sortDirection=asc");

        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(3, $data);
        $portionsIds = array_column($data, 'id');

        $portions->each(function (Portion $portion) use ($portionsIds) {
            $this->assertContains($portion->id, $portionsIds);
        });
    }

    /**
     * Check view portions list for authorized user.
     *
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testIndexAuthorized(): void
    {
        $day = factory(Day::class)->create();
        $this->actingAs($this->user, 'api')
            ->getJson("/api/days/{$day->id}/portions?page=1&perPage=10&sortBy=time&sortDirection=asc")
            ->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testPagination(): void
    {
        factory(Portion::class, 3)->create();
        $day = factory(Day::class)->create(['user_id' => $this->user->id]);

        factory(Portion::class)->create(['day_id' => $day->id, 'user_id' => $day->user_id, 'time' => '10:00']);
        factory(Portion::class)->create(['day_id' => $day->id, 'user_id' => $day->user_id, 'time' => '12:00']);
        $portion = factory(Portion::class)->create([
            'day_id' => $day->id,
            'user_id' => $day->user_id,
            'time' => '11:00'
        ]);

        $response = $this->actingAs($this->user, 'api')
            ->getJson("/api/days/{$day->id}/portions?page=2&perPage=1&sortBy=time&sortDirection=asc");

        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($day);
        $this->assertCount(1, $data);

        $this->assertEquals($portion->id, $data[0]['id']);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::store()
     */
    public function testCreateOwner(): void
    {
        /** @var Day $day */
        $day = factory(Day::class)->create(['user_id' => $this->user->id]);
        /** @var Meal $meal */
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);

        $postData = [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true
        ];

        $response = $this->actingAs($this->user, 'api')
            ->postJson("/api/days/{$day->id}/portions", $postData);

        $response->assertStatus(201);

        $protein = round($meal->protein * 2, 1);
        $fat = round($meal->fat * 2, 1);
        $carbohydrates = round($meal->carbohydrates * 2, 1);
        $fiber = round($meal->fiber * 2, 1);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true,
            'protein' => $protein,
            'fat' => $fat,
            'carbohydrates' => $carbohydrates,
            'fiber' => $fiber,
        ]);

        $this->assertDatabaseHas($day->getTable(), [
            'id' => $day->id,
            'weight' => 200,
            'weight_eaten' => 200,
            'protein' => $protein,
            'fat' => $fat,
            'carbohydrates' => $carbohydrates,
            'fiber' => $fiber,
            'protein_eaten' => $protein,
            'fat_eaten' => $fat,
            'carbohydrates_eaten' => $carbohydrates,
            'fiber_eaten' => $fiber
        ]);
    }


    /**
     * @covers \App\Api\Http\Controllers\PortionController::store()
     */
    public function testCreateAuthorizedForeignDayMeal(): void
    {
        $day = factory(Day::class)->create();
        $meal = factory(Meal::class)->create();
        $postData = [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true
        ];

        $this->actingAs($this->user, 'api')
            ->postJson("/api/days/{$day->id}/portions", $postData)
            ->assertStatus(403);
    }


    /**
     * @covers \App\Api\Http\Controllers\PortionController::store()
     */
    public function testCreateAuthorizedForeignMeal(): void
    {
        $day = factory(Day::class)->create(['user_id' => $this->user->id]);
        $meal = factory(Meal::class)->create();
        $postData = [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true
        ];

        $this->actingAs($this->user, 'api')
            ->postJson("/api/days/{$day->id}/portions", $postData)
            ->assertStatus(403);
    }


    /**
     * @covers \App\Api\Http\Controllers\PortionController::store()
     */
    public function testCreateAuthorizedForeignDay(): void
    {
        $day = factory(Day::class)->create();
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $postData = [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true
        ];

        $this->actingAs($this->user, 'api')
            ->postJson("/api/days/{$day->id}/portions", $postData)
            ->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::store()
     */
    public function testCreateUnauthorized(): void
    {
        $day = factory(Day::class)->create();
        $meal = factory(Meal::class)->create(['user_id' => $day->user_id]);
        $data = [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true
        ];
        $this->postJson("/api/days/{$day->id}/portions", $data)
            ->assertStatus(401);
    }


    /**
     * @covers \App\Api\Http\Controllers\PortionController::update()
     */
    public function testUpdateOwner(): void
    {
        /** @var Portion $portion */
        $portion = factory(Portion::class)->create(['user_id' => $this->user->id]);

        $data = ['weight' => 10];

        $this->actingAs($this->user, 'api')
            ->patchJson("/api/days/{$portion->day_id}/portions/{$portion->id}", $data)
            ->assertStatus(200);

        $protein = round($portion->meal->protein / 10, 1);
        $fat = round($portion->meal->fat / 10, 1);
        $carbohydrates = round($portion->meal->carbohydrates / 10, 1);
        $fiber = round($portion->meal->fiber / 10, 1);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'weight' => 10,
            'protein' => $protein,
            'fat' => $fat,
            'carbohydrates' => $carbohydrates,
            'fiber' => $fiber,
        ]);

        $this->assertDatabaseHas($this->day->getTable(), [
            'id' => $portion->day_id,
            'protein' => $protein,
            'fat' => $fat,
            'carbohydrates' => $carbohydrates,
            'fiber' => $fiber,
        ]);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::update()
     */
    public function testUpdateMealOwner(): void
    {
        $portion = factory(Portion::class)->create(['user_id' => $this->user->id, 'weight' => 10]);
        $meal = factory(Meal::class)->create(['user_id' => $portion->user_id]);
        $data = ['meal_id' => $meal->id];

        $this->actingAs($this->user, 'api')
            ->patchJson("/api/days/{$portion->day_id}/portions/{$portion->id}", $data)
            ->assertStatus(200);

        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'weight' => 10,
            'protein' => round($meal->protein / 10, 1),
            'fat' => round($meal->fat / 10, 1),
            'carbohydrates' => round($meal->carbohydrates / 10, 1),
            'fiber' => round($meal->fiber / 10, 1),
        ]);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::update()
     */
    public function testUpdateAuthorizedForeignDayMeal(): void
    {
        $portion = factory(Portion::class)->create();
        $meal = factory(Meal::class)->create();
        $data = ['meal_id' => $meal->id];

        $this->actingAs($this->user, 'api')
            ->patchJson("/api/days/{$portion->day_id}/portions/{$portion->id}", $data)
            ->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::update()
     */
    public function testUpdateAuthorizedForeignDay(): void
    {
        $portion = factory(Portion::class)->create();
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $data = ['meal_id' => $meal->id];

        $this->actingAs($this->user, 'api')
            ->patchJson("/api/days/{$portion->day_id}/portions/{$portion->id}", $data)
            ->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::update()
     */
    public function testUpdateUnauthorized(): void
    {
        $portion = factory(Portion::class)->create();
        $meal = factory(Meal::class)->create();
        $data = ['meal_id' => $meal->id];

        $this->patchJson("/api/days/{$portion->day_id}/portions/{$portion->id}", $data)
            ->assertStatus(401);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::destroy()
     */
    public function testDeleteOwner(): void
    {
        $portion = factory(Portion::class)->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user, 'api')
            ->deleteJson("/api/days/{$portion->day_id}/portions/{$portion->id}")
            ->assertStatus(200);
        $this->assertDatabaseMissing($this->portion->getTable(), ['id' => $portion->id]);
        $this->assertDatabaseHas($this->day->getTable(), [
            'id' => $portion->day_id,
            'weight' => 0,
            'protein' => 0,
            'fat' => 0,
            'carbohydrates' => 0,
            'weight_eaten' => 0,
            'protein_eaten' => 0,
            'fat_eaten' => 0,
            'carbohydrates_eaten' => 0,
            'calories' => 0,
            'calories_eaten' => 0,
        ]);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::destroy()
     */
    public function testDeleteAuthorizedForeignDay(): void
    {
        $portion = factory(Portion::class)->create();
        $this->actingAs($this->user, 'api')
            ->deleteJson("/api/days/{$portion->day_id}/portions/{$portion->id}")
            ->assertStatus(403);
        $this->assertDatabaseHas($this->portion->getTable(), ['id' => $portion->id]);
    }
}