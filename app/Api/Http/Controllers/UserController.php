<?php

namespace App\Api\Http\Controllers;

use App\Api\Http\Resources\UserResource;
use App\Api\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * API for users.
 */
class UserController extends Controller
{
    /**
     * Logged user info.
     *
     * @return UserResource
     */
    public function me(): UserResource
    {
        return UserResource::make(Auth::user());
    }
}