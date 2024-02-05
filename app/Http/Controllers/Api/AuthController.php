<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'max:255'],
            ], [
                'email.required' => 'O campo de email é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.max' => 'O campo de email não pode ter mais de :max caracteres.',
                'password.required' => 'O campo de password é obrigatório.',
                'password.max' => 'O campo de password não pode ter mais de :max caracteres.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }
            $credentials = $request->only(['email', 'password']);
            $user = User::where('email', $credentials['email'])->first();
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $token = $user->createToken($request->email)->plainTextToken;

            return response()->json(['token' => $token], 200);
        } catch (\Exception $excecao) {
            // Código para lidar com a exceção
            return response()->json(['error' => $excecao], 500);
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }
}
