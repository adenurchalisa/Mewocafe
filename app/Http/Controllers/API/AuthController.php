<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        try {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $data = [
                    "status" => true,
                    "message" => "Success Login",
                    "data" => [
                        "token" => $user->createToken('token')->plainTextToken,
                        "user" => [
                            "name" => $user->name,
                            "email" => $user->email,
                        ],
                    ],
                ];
                return response()->json($data, 200);
            } else {
                $data = [
                    "status" => false,
                    "message" => "Email or password incorrect"
                ];
                return response()->json($data, 400);
            }
        } catch(\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request){
        try {
            $request->user()->currentAccessToken()->delete();
            $data = [
                "status" => true,
                "message" => "Logout successful"
            ];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ], 500);
        }
    }
}
