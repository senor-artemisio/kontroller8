<?php

namespace Tests\Feature;

use App\Api\Models\Day;
use App\Api\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Api\Http\Controllers\DayController
 */
class DayApiTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private $user;

    /** @var Day */
    protected $day;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->day = new Day();
    }

    /**
     * Check view days list for unauthorized user.
     *
     * @covers \App\Api\Http\Controllers\DayController::index()
     */
    public function testIndexUnauthorized(): void
    {
        factory(Day::class)->create();
        $this->getJson('/api/days')->assertStatus(401);
    }

    /**
     * Check view days list for owner.
     *
     * @covers \App\Api\Http\Controllers\DayController::index()
     */
    public function testIndexOwner(): void
    {
        factory(Day::class, 3)->create();
        $days = factory(Day::class, 3)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/days?page=1&perPage=10&sortBy=date&sortDirection=desc');

        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(3, $data);

        $dayIds = array_column($data, 'id');

        $days->each(function (Day $day) use ($dayIds) {
            $this->assertContains($day->id, $dayIds);
        });
    }

    public function testIndexFilterDate(): void
    {
        factory(Day::class, 3)->create(['user_id' => $this->user->id]);
        $day = factory(Day::class)->create(['user_id' => $this->user->id, 'date' => '2000-01-01']);

        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/days?page=1&perPage=10&sortBy=date&sortDirection=desc&date=2000-01-01');

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(1, $data);
        $this->assertEquals($day->id, $data[0]['id']);
    }

    /**
     * Check view days list for authorized user.
     *
     * @covers \App\Api\Http\Controllers\DayController::index()
     */
    public function testIndexAuthorized(): void
    {
        factory(Day::class)->create();
        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/days?page=1&perPage=10&sortBy=date&sortDirection=desc');

        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(0, $data);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::index()
     */
    public function testPagination(): void
    {
        factory(Day::class, 3)->create();
        factory(Day::class)->create(['user_id' => $this->user->id, 'date' => '1999-01-01']);
        factory(Day::class)->create(['user_id' => $this->user->id, 'date' => '2001-01-01']);
        $day = factory(Day::class)->create(['user_id' => $this->user->id, 'date' => '2000-01-01']);

        $response = $this->actingAs($this->user, 'api')
            ->getJson('/api/days?page=2&perPage=1&sortBy=date&sortDirection=desc');

        $response->assertStatus(200);
        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertCount(1, $data);
        $this->assertEquals($day->id, $data[0]['id']);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::store()
     */
    public function testCreateAuthorized(): void
    {
        $day = factory(Day::class)->create(['date' => '1999-01-01']);

        $this->actingAs($this->user, 'api')
            ->postJson('/api/days', ['date' => '2000-01-01'])
            ->assertStatus(201);

        $this->assertDatabaseHas($this->day->getTable(), ['id' => $day->id, 'date' => $day->date]);
        $this->assertDatabaseHas($this->day->getTable(), ['date' => '2000-01-01', 'user_id' => $this->user->id]);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::store()
     */
    public function testCreateUnauthorized(): void
    {
        $day = factory(Day::class)->create(['date' => '1999-01-01']);

        $this->postJson('/api/days', ['date' => '2000-01-01'])
            ->assertStatus(401);

        $this->assertDatabaseHas($this->day->getTable(), ['id' => $day->id, 'date' => $day->date]);
        $this->assertDatabaseMissing($this->day->getTable(), ['date' => '2000-01-01']);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::destroy()
     */
    public function testDeleteOwner(): void
    {
        $day = factory(Day::class)->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/days/$day->id");
        $response->assertStatus(200);

        $this->assertDatabaseMissing($this->day->getTable(), ['id' => $day->id]);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::destroy()
     */
    public function testDeleteAuthorized(): void
    {
        $day = factory(Day::class)->create();

        $response = $this->actingAs($this->user, 'api')->deleteJson("/api/days/$day->id");
        $response->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\DayController::destroy()
     */
    public function testDeleteUnauthorized(): void
    {
        $day = factory(Day::class)->create();

        $response = $this->deleteJson("/api/days/$day->id");
        $response->assertStatus(401);
    }
}