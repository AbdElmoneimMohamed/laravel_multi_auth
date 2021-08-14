<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAPIController extends Controller
{
    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (auth()->guard('customers')->attempt($credentials)) {
            $customer = auth()->guard('customers')->user();
            if ($customer->deleted_at != Null) {
                return "validation error";
            } else {
                $token = $customer->createToken('token-name')->plainTextToken;
                return ["token" => $token];
            }
        }
        return "Username or password is wrong";
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();

        $customer = $this->create($data);
        return 'you have signed in';
    }

    public function create(array $data)
    {
        return Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout(Request $request)
    {
        $customer = auth('sanctum')->user();
        dd($customer->email);
        $customer->tokens()->where('id', $customer->currentAccessToken()->id)->delete();
        return 'Customer logged out';
    }
}
