<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//ADMIN KONTROLER
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }


    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => false]);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        if ($user->role == "admin") {

            $token = $user->createToken("auth_token", ['server:admin'])->plainTextToken;

            return response()->json(['success' => true, 'access_token' => $token, 'token_type' => 'Beraer',   "role" => $user->role, 'message' => 'Welcome ' . $user->name]);
        }

        $token = $user->createToken('auth_token', [''])->plainTextToken;

        return response()->json(['success' => true, 'access_token' => $token, 'token_type' => 'Beraer',   "role" => $user->role, 'message' => 'Welcome ' . $user->name]);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'You have logged out. The Token was deleted'
        ];
    }
}
