<?php

namespace Tests\Feature;

use App\Api\DTO\UserDTO;
use App\Api\Http\Controllers\AuthController;
use App\Api\Models\User;
use App\Api\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * @see AuthController
 */
class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @see AuthController::signup()
     */
    public function testSignup(): void
    {
        $data = [
            'name' => 'Boo',
            'email' => 'foo@foo.foo',
            'password' => 'secret'
        ];

        $response = $this->postJson('/api/auth/signup', $data);
        $response->assertStatus(201);

        unset($data['password']);

        $this->assertDatabaseHas(factory(User::class)->make()->getTable(), $data);
    }

    /**
     * @see AuthController::login()
     * @throws \App\Api\DTO\DTOException
     */
    public function testLogin(): void
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

        $response = $this->postJson('/api/auth/login', [
            'email' => 'foo@foo.foo',
            'password' => 'secret',
            'remember_me' => false
        ]);

        dd($response->decodeResponseJson());
    }
}