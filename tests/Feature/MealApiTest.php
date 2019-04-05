<?php

namespace Tests\Feature;

use App\Api\Http\Controllers\MealController;
use App\Api\Models\User;
use App\Api\Models\Meal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Feature test for meal API.
 *
 * @see MealController
 */
class MealApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var Meal */
    private $meal;

    /** @var User */
    private $user;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->meal = new Meal();
    }

    /**
     * Check view meals list for unauthorized user.
     *
     * @see MealController::index()
     */
    public function testIndexUnauthorized(): void
    {
        $this->getJson('/api/meals')->assertStatus(401);
    }

    /**
     * Check view meals list for authorized user.
     *
     * @see MealController::index()
     */
    public function testIndexAuthorized(): void
    {
        /** @var Collection $meals */
        $meals = factory(Meal::class, 5)->create(['user_id' => $this->user->id]);
        factory(Meal::class, 10)->create();

        $response = $this->actingAs($this->user, 'api')->getJson(
            '/api/meals?page=1&perPage=10&sortBy=title&sortDirection=asc'
        );
        $response->assertStatus(200);


        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(5, $data);

        $dataIDs = array_column($data, 'id');
        $meals->each(function (Meal $meal) use ($dataIDs) {
            $this->assertContains($meal->id, $dataIDs);
        });

        $meta = $response->decodeResponseJson('meta');
        $this->assertNotNull($meta);
        $this->assertArrayHasKey('total', $meta);
        $this->assertEquals(5, $meta['total']);
    }

    /**
     * Check view meal for unauthorized user.
     *
     * @see MealController::show()
     */
    public function testShowUnauthorized(): void
    {
        $meal = factory(Meal::class)->create();
        $this->getJson("/api/meals/{$meal->id}")->assertStatus(401);
    }

    /**
     * Check view meal for authorized user.
     *
     * @see MealController::show()
     */
    public function testShowAuthorized(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->create();
        $response = $this->actingAs($this->user, 'api')->getJson("/api/meals/$meal->id");
        $response->assertStatus(403);
    }

    /**
     * Check view meal for owner.
     *
     * @see MealController::show()
     */
    public function testShowOwner(): void
    {
        /** @var Meal $meal */
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user, 'api')->getJson("/api/meals/$meal->id");
        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $mealData = $meal->toArray();

        unset($data['type'], $mealData['user_id']);

        $this->assertNotNull($data);
        $this->assertEquals($mealData, $data);
    }


    /**
     * Check pagination for meals.
     *
     * @see MealController::index()
     */
    public function testPagination(): void
    {
        /** @var Collection $meals */
        $meals = factory(Meal::class, 35)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'api')->getJson(
            '/api/meals?page=1&perPage=20&sortBy=title&sortDirection=asc'
        );
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(20, $data);

        $mealsIDS = $meals->pluck('id')->toArray();

        foreach ($data as $meal) {
            $this->assertContains($meal['id'], $mealsIDS);
        }
    }

    /**
     * Check create meal for authorized user.
     *
     * @see MealController::store()
     */
    public function testCreateAuthorized(): void
    {
        $mealData = [
            'title' => 'chicken breast',
            'protein' => 23.5,
            'fat' => 1.2,
            'carbohydrates' => 4.3,
            'fiber' => 0
        ];
        $response = $this->actingAs($this->user, 'api')->postJson('/api/meals', $mealData);
        $response->assertStatus(201);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $mealData['id'] = $data['id'];
        $mealData['created_at'] = $data['created_at'];
        $mealData['updated_at'] = $data['updated_at'];

        unset($data['type']);

        $this->assertEquals($data, $mealData);
        $this->assertDatabaseHas($this->meal->getTable(), $data);
    }

    /**
     * Check create meal for unauthorized user.
     *
     * @see MealController::store()
     */
    public function testCreateUnauthorized(): void
    {
        $mealData = [
            'title' => 'chicken breast',
            'protein' => 23.5,
            'fat' => 1.2,
            'carbohydrates' => 4.3,
            'fiber' => 0
        ];
        $response = $this->postJson('/api/meals', $mealData);
        $response->assertStatus(401);
    }

    /**
     * Check update meals for authorized user.
     *
     * @see MealController::update()
     */
    public function testUpdateAuthorized(): void
    {
        $meal = factory(Meal::class)->create();
        $mealData = ['title' => 'not chicken breast'];

        $response = $this->actingAs($this->user, 'api')->patchJson("/api/meals/$meal->id", $mealData);
        $response->assertStatus(403);
    }

    /**
     * Check update meal for owner.
     *
     * @see MealController::update()
     */
    public function testUpdateOwner(): void
    {
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $mealData = ['title' => 'not chicken breast'];

        $response = $this->actingAs($this->user, 'api')->patchJson("/api/meals/$meal->id", $mealData);
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $this->assertEquals($data['title'], $mealData['title']);
        $this->assertEquals($data['id'], $meal->id);
        $this->assertDatabaseHas($this->meal->getTable(), [
            'id' => $meal->id,
            'title' => $mealData['title']
        ]);
    }

    /**
     * Check update meal for unauthorized user.
     *
     * @see MealController::update()
     */
    public function testUpdateUnauthorized(): void
    {
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $mealData = ['title' => 'not chicken breast'];

        $response = $this->patchJson("/api/meals/$meal->id", $mealData);
        $response->assertStatus(401);
    }

    /**
     * Check delete meal for authorized user.
     *
     * @see MealController::destroy()
     */
    public function testDeleteAuthorized(): void
    {
        $meal = factory(Meal::class)->create();
        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/meals/$meal->id");
        $response->assertStatus(403);
    }

    /**
     * Check delete meal for owner.
     *
     * @see MealController::destroy()
     */
    public function testDeleteOwner(): void
    {
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/meals/$meal->id");
        $response->assertStatus(204);
        $this->assertDatabaseMissing($this->meal->getTable(), ['id' => $meal->id]);
    }

    /**
     * Check delete meal for unauthorized user.
     *
     * @see MealController::destroy()
     */
    public function testDeleteUnauthorized(): void
    {
        $meal = factory(Meal::class)->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson("/api/meals/$meal->id");
        $response->assertStatus(401);
        $this->assertDatabaseHas($this->meal->getTable(), ['id' => $meal->id]);
    }
}
