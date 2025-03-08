<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
            
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $refreshToken = base64_encode(random_bytes(40));

        
        Cookie::queue('refresh_token', $refreshToken, 1440, '/', null, false, true);
        
        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); 
        return response()->json(['message' => 'Logged out successfully']);
    }


    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');

        if (!$refreshToken) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('refresh_token', $refreshToken)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        $newToken = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $newToken]);
    }


    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(uniqid()), 
                ]
            );

            $token = $user->createToken('auth_token')->plainTextToken;

            return redirect("http://localhost:5173/auth-success?token={$token}");
        } catch (\Exception $e) {
            return response()->json(['message' => 'Authentication failed'], 401);
        }
    }

}
