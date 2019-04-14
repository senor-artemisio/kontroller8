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
    }

    /**
     * Check view portions list for unauthorized user.
     *
     * @covers \App\Api\Http\Controllers\PortionController::index()
     */
    public function testIndexUnauthorized(): void
    {
        $day = factory(Day::class)->create();
        $this->getJson("/api/days/{$day->id}/portions")->assertStatus(401);
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
            ->getJson("/api/days/$dayId/portions")
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
        $this->assertNotNull($day);
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
        $portion = factory(Portion::class)->create(['day_id' => $day->id, 'user_id' => $day->user_id, 'time' => '11:00']);

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

        $this->assertDatabaseHas($this->portion->getTable(), [
            'meal_id' => $meal->id,
            'weight' => 200,
            'eaten' => true,
            'protein' => (int)($meal->protein * 2),
            'fat' => (int)($meal->fat * 2),
            'carbohydrates' => (int)($meal->carbohydrates * 2),
            'fiber' => (int)($meal->fiber * 2),
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

}