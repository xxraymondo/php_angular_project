<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart; // Don't forget to import the Cart model

class UserController extends Controller
{
    // User registration
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response(['user' => $user, 'message' => 'Registration successful'], 201);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response(['message' => 'Invalid credentials'], 401);
        }

        $user = $request->user();

        // Check if the user has a cart; if not, create one
        if (!$user->hasCart()) {
            $cart = new Cart();
            $user->cart()->save($cart);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 200);
    }




    // User logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(['message' => 'Logged out successfully'], 200);
    }

    public function adminPanel()
    {
        return response()->json([
            'message' => 'Welcome to the Admin Panel!',
            'status_code' => 200,
        ]);
    }
    public function listUsers()
    {
        // Retrieve all users
        $users = User::all();

        return response()->json(['data' => $users], Response::HTTP_OK);
    }

}
