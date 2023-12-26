<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function getToken(Request $request)
    {
        if ($request->user() == null) {
            return response()->json(['error' => 'Unauthorized', 'redirect' => '/'], 401);
        }

        $user = $request->user();
        $user->tokens()->where('tokenable_id', $request->user()->staff_code)->delete();
        $token = $request->user()->createToken($request->user()->staff_code, [$user->role])->plainTextToken;
        $token = explode('|', $token)[1];

        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {
        if (!Auth::user() == null) {
            return response()->json(['message' => 'Already logged in']);
        }

        if (Auth::attempt($request->only(['staff_code', 'password']))) {
            $request->session()->regenerate();
            $user = Staff::find($request->staff_code);
            $user->tokens()->where('tokenable_id', $request->staff_code)->delete();
            $token = $request->user()->createToken($request->staff_code, [$user->role]);
            return response()->json([
                'message' => 'Login successful!',
                'redirect' => '/'
            ]);
        }
        return response()->json(['error' => 'Invalid credentials', 'redirect' => '/'], 401);
    }

    public function logout()
    {
        request()->user()->tokens()->delete();
        Auth::logout();
        return response()->json(['message' => 'Logout successful!', 'redirect' => '/']);
    }
}
