<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller {
    public function __invoke(LoginRequest $request) {
        $data = $request->validated();
        $user = User::whereEmail($data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Nesprávny email alebo heslo.'],
            ]);
        }

        $name = $_SERVER['HTTP_USER_AGENT'].'_'.$_SERVER['REMOTE_ADDR'];

        return response()->json([
            'error' => false,
            'token' => $user->createToken($name)->plainTextToken
        ]);
    }
}
