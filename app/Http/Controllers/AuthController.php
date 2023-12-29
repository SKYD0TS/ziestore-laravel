<?php

namespace App\Http\Controllers;

use App\Models\User\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // dd(Auth::check());
        $user = Staff::find($request->staff_code);

        if ($user->tokens()->where('tokenable_id', $user->staff_code)->first()) {
            return response()->json(['message' => 'Already logged in']);
        }

        if (Auth::attempt($request->only(['staff_code', 'password']))) {
            $user->tokens()->where('tokenable_id', $user->staff_code)->delete();
            $token = $request->user()->createToken($user->staff_code, [$user->role])->plainTextToken;
            $token = explode('|', $token)[1];
            return response()->json([
                'message' => 'Login successful!',
                'redirect' => '/'
            ])->cookie('token', $token, 60 * 24);
        }
        return response()->json(['error' => 'Invalid credentials', 'redirect' => '/']);
    }

    public function logout(Request $request)
    {
        dd($request->user());
        $request->user()->tokens()->delete();
        Auth::logout();
        return response()->json(['message' => 'Logout successful!', 'redirect' => '/']);
    }
}
