<?php

namespace Tests\Feature;

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
     * @covers \App\Api\Http\Controllers\PortionController::markEaten()
     */
    public function testMarkEatenOwner(): void
    {
        $portion = factory(Portion::class)->create([
            'eaten' => false,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user, 'api')->postJson("/api/portions/mark-eaten/$portion->id");
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertEquals($portion->id, $data['id']);
        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'eaten' => true
        ]);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::markEaten()
     */
    public function testMarkEatenAuthorized(): void
    {
        $portion = factory(Portion::class)->create(['eaten' => false]);
        $response = $this->actingAs($this->user, 'api')->postJson("/api/portions/mark-eaten/$portion->id");
        $response->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::markEaten()
     */
    public function testMarkEatenUnauthorized(): void
    {
        $portion = factory(Portion::class)->create(['eaten' => false]);
        $response = $this->postJson("/api/portions/mark-eaten/$portion->id");
        $response->assertStatus(401);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::unmarkEaten()
     */
    public function testUnmarkEatenOwner(): void
    {
        $portion = factory(Portion::class)->create([
            'eaten' => true,
            'user_id' => $this->user->id
        ]);

        $response = $this->actingAs($this->user, 'api')->postJson("/api/portions/unmark-eaten/$portion->id");
        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);
        $this->assertEquals($portion->id, $data['id']);
        $this->assertDatabaseHas($this->portion->getTable(), [
            'id' => $portion->id,
            'eaten' => false
        ]);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::unmarkEaten()
     */
    public function testUnmarkEatenAuthorized(): void
    {
        $portion = factory(Portion::class)->create(['eaten' => true]);
        $response = $this->actingAs($this->user, 'api')->postJson("/api/portions/unmark-eaten/$portion->id");
        $response->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\PortionController::markEaten()
     */
    public function testUnmarkEatenUnauthorized(): void
    {
        $portion = factory(Portion::class)->create(['eaten' => true]);
        $response = $this->postJson("/api/portions/unmark-eaten/$portion->id");
        $response->assertStatus(401);
    }
}