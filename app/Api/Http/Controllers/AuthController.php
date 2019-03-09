<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\UserDTO;
use App\Api\Http\Requests\LoginRequest;
use App\Api\Http\Requests\SignupRequest;
use App\Api\Http\Resources\TokenResource;
use App\Api\Http\Resources\UserResource;
use App\Api\Repositories\UserRepository;
use App\Api\Services\TokenService;
use App\Api\Services\UserService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;

/**
 * API for users.
 */
class AuthController extends Controller
{
    /** @var UserService */
    private $userService;

    /** @var UserRepository */
    private $userRepository;

    /** @var TokenService */
    protected $tokenService;

    /**
     * @param UserService $userService
     * @param UserRepository $userRepository
     * @param TokenService $tokenService
     */
    public function __construct(UserService $userService, UserRepository $userRepository, TokenService $tokenService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
        $this->tokenService = $tokenService;
    }

    /**
     * Sign up for unauthorized users.
     *
     * @param SignupRequest $request
     *
     * @return UserResource
     * @throws \App\Api\DTO\DTOException
     */
    public function signup(SignupRequest $request): UserResource
    {
        $dto = new UserDTO($request->all());
        $dto->setId(\Ulid::generate());

        $this->userService->create($dto);

        $user = $this->userRepository->findById($dto->getId());
        $user->wasRecentlyCreated = true;

        return UserResource::make($user);
    }

    /**
     * Sign in user and create token.
     *
     * @param LoginRequest $request
     * @return TokenResource
     * @throws AuthenticationException
     */
    public function signin(LoginRequest $request): TokenResource
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'password' => ['Incorrect credentials.'],
            ]);
        }

        $tokenResult = $this->userRepository->token($request->user());

        $this->tokenService->create($tokenResult, (bool)$request->get('remember_me'));

        return TokenResource::make($tokenResult);
    }
}