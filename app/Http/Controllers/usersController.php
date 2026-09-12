<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'invalid email or password'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'user registered successfully',
            'user' => $user
        ], 201);
    }


    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Logged out successfully"], 200);
    }

    public function getProfile(int $id)
    {
        $profile = User::find($id)->profile;
        return response()->json($profile, 200);
    }

    public function getUserTask(int $id)
    {
        $tasks = User::findOrFail($id)->tasks;
        return response()->json($tasks, 200);
    }

    public function getFavoritesTasks() {
        $tasks = Auth::user()->favoritesTasks;
        return response()->json($tasks, 200);
    }

    public function getUser(){
        $user_id =  Auth::user()->id ; 
        $userData = User::with('profile')->findOrFail($user_id) ; 
        return new UserResource($userData) ; 
    }
}