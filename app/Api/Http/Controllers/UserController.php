<?php

namespace App\Api\Http\Controllers;

use App\Api\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $v = validator($request->only('email', 'name', 'password'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($v->fails()) {
            return response()->json($v->errors()->all(), 400);
        }
        $data = request()->only('email','name','password');

        $user = User::create([
            'id' => \Ulid::generate(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
//
//        $client = \Laravel\Passport\Client::where('password_client', 1)->first();
//
//        $request->request->add([
//            'grant_type'    => 'password',
//            'client_id'     => $client->id,
//            'client_secret' => $client->secret,
//            'username'      => $data['email'],
//            'password'      => $data['password'],
//            'scope'         => null,
//        ]);
//
//        // Fire off the internal request.
//        $proxy = Request::create(
//            'oauth/token',
//            'POST'
//        );
//
//        return \Route::dispatch($proxy);
    }
}