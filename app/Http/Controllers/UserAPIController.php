<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAPIController extends Controller
{
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (auth()->guard('users')->attempt($credentials)) {
            $user = auth()->guard('users')->user();
            if ($user->deleted_at != Null) {
                return "validation error";
            } else {
                $token = $user->createToken('token-name')->plainTextToken;
                return ["token" => $token];
            }
        }
        return "Username or password is wrong";
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $user = $this->create($data);
        return 'you have signed in';
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout(Request $request)
    {
        $user = auth('sanctum')->user();
        dd($user->email);
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return 'User logged out';
    }
}
