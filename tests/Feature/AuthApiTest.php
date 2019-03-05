<?php

namespace Tests\Feature;

use App\Api\DTO\UserDTO;
use App\Api\Models\User;
use App\Api\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * @covers \App\Api\Http\Controllers\AuthController
 */
class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Api\Http\Controllers\AuthController::signup()
     */
    public function testSignupUnauthorized(): void
    {
        $data = [
            'name' => 'Boo',
            'email' => 'foo@foo.foo',
            'password' => 'secret'
        ];

        $this->postJson('/api/auth/signup', ['name' => 'boo'])
            ->assertStatus(422);

        $response = $this->postJson('/api/auth/signup', $data);
        $response->assertStatus(201);

        unset($data['password']);

        $this->assertDatabaseHas(factory(User::class)->make()->getTable(), $data);
    }

    /**
     * @covers \App\Api\Http\Controllers\AuthController::signup()
     */
    public function testSignupAuthorized(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->postJson('/api/auth/signup', [
                'name' => 'Boo',
                'email' => 'foo@foo.foo',
                'password' => 'secret'
            ])->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\AuthController::login()
     * @throws \App\Api\DTO\DTOException
     */
    public function testLoginUnauthorized(): void
    {
        Artisan::call('passport:client', ['--personal' => 1, '--name' => 'web']);
        /** @var UserService $userService */
        $userService = $this->app->make(UserService::class);
        $dto = new UserDTO([
            'id' => \Ulid::generate(),
            'name' => 'Boo',
            'email' => 'foo@foo.foo',
            'password' => 'secret'
        ]);
        $userService->create($dto);

        $this->postJson('/api/auth/login', ['email' => 'foo@foo.foo'])->assertStatus(422);

        $this->postJson('/api/auth/login', [
            'email' => 'foo@foo.foo',
            'password' => 'wrong',
            'remember_me' => false
        ])->assertStatus(401);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'foo@foo.foo',
            'password' => 'secret',
            'remember_me' => false
        ]);

        $response->assertStatus(200);

        $data = $response->decodeResponseJson('data');
        $this->assertNotNull($data);

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('expires_at', $data);
    }

    /**
     * @covers \App\Api\Http\Controllers\AuthController::login()
     */
    public function testLoginAuthorized(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->postJson('/api/auth/login', [
                'email' => 'foo@foo.foo',
                'password' => 'secret'
            ])->assertStatus(403);
    }
}