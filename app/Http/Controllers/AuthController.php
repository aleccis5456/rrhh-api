<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PHPUnit\TextUI\Configuration\CodeCoverageReportNotConfiguredException;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ],[
            'name.*' => 'Error en el nombre',
            'email.*' => 'Error en el email',
            'password.*' => 'Error en la password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }
    
    public function login(Request $request){        
        $request->validate([           
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();        
        $credentials = $request->only('email', 'password');

        if(!$user and Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'las credenciales son ivalidas'], 404);
        }
        
        if(!Auth::attempt($credentials)){
            return response()->json(['message' => 'las credenciales son ivalidas'], 404);
        }

        $user = Auth::user();
        $token = $user->createToken($user)->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'logout successfully']);
    }
}
