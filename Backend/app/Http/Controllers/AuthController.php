<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Validation
            $credentials = $request->validate([
                'login_pers' => 'required|string',
                'pwd_pers' => 'required|string',
            ]);

            // Vérification du login
            $personnel = Personnel::where('login_pers', $credentials['login_pers'])->first();

            if (! $personnel || ! Hash::check($credentials['pwd_pers'], $personnel->pwd_pers)) {
                return response()->json(['message' => 'Identifiants invalides'], 401);
            }

            // Supprime tous les anciens tokens
            $personnel->tokens()->delete();

            // Crée un nouveau token
            $token = $personnel->createToken('auth_token')->plainTextToken;

            return response()->json([
                'personnel' => $personnel,
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la connexion',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Déconnexion réussie'], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erreur lors de la déconnexion',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
