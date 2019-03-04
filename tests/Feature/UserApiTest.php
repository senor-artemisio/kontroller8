<?php

namespace Tests\Feature;

use App\Api\Http\Controllers\UserController;
use App\Api\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see UserController
 */
class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @see UserController::store()
     */
    public function testRegister(): void
    {
        $data = ['name' => 'Boo', 'email' => 'foo@foo.foo', 'password' => 'secret'];

        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201);

        unset($data['password']);

        $this->assertDatabaseHas(factory(User::class)->make()->getTable(), $data);
    }

    public function testLogin():void
    {

    }
}