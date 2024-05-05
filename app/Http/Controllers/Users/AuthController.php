<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            // Autenticação bem-sucedida
            $user = Auth::user();
            $token = $user->createToken($user->id);
    
            return response(['data' => $user, 'token' => $token->plainTextToken, 'message' => 'Successful login!'], 200);
        }
    
        // Autenticação falhou
        return response(['message' => 'Invalid access credentials'], 401);
    }


    public function signup()
    {
        request()->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Cadastra o usuário
        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => request()->password, 
        ]);

        return response(['data' => $user, 'message' => 'User registered successfully.'], 201);
    }
}
