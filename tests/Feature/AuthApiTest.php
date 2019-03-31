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
    public function testSignUpUnauthorized(): void
    {
        $this->postJson('/api/auth/sign-up', ['name' => 'boo'])
            ->assertStatus(422);

        $data = [
            'name' => 'Boo',
            'email' => 'foo@foo.foo',
            'password' => 'secret',
        ];
        $response = $this->postJson('/api/auth/sign-up', $data);
        $response->assertStatus(422);

        $data['password_confirmation'] = $data['password'];

        $response = $this->postJson('/api/auth/sign-up', $data);
        $response->assertStatus(201);

        unset($data['password'], $data['password_confirmation']);

        $this->assertDatabaseHas(factory(User::class)->make()->getTable(), $data);
    }

    /**
     * @covers \App\Api\Http\Controllers\AuthController::signup()
     */
    public function testSignUpAuthorized(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->postJson('/api/auth/sign-up', [
                'name' => 'Boo',
                'email' => 'foo@foo.foo',
                'password' => 'secret'
            ])->assertStatus(403);
    }

    /**
     * @covers \App\Api\Http\Controllers\AuthController::signin()
     * @throws \App\Api\DTO\DTOException
     */
    public function testSignInUnauthorized(): void
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

        $this->postJson('/api/auth/sign-in', ['email' => 'foo@foo.foo'])->assertStatus(422);

        $this->postJson('/api/auth/sign-in', [
            'email' => 'foo@foo.foo',
            'password' => 'wrong'
        ])->assertStatus(422);

        $response = $this->postJson('/api/auth/sign-in', [
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
    public function testSignInAuthorized(): void
    {
        $this->actingAs(factory(User::class)->create())
            ->postJson('/api/auth/sign-in', [
                'email' => 'foo@foo.foo',
                'password' => 'secret'
            ])->assertStatus(403);
    }
}