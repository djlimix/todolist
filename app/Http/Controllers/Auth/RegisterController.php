<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller {
    public function __invoke(RegisterRequest $request) {
        $user = User::create($request->validated());

        $name = $_SERVER['HTTP_USER_AGENT'].'_'.$_SERVER['REMOTE_ADDR'];

        return response()->json([
            'error' => false,
            'token' => $user->createToken($name)->plainTextToken
        ]);
    }
}
