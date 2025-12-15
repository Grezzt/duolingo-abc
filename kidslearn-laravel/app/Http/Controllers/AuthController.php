<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => "🎉 Hore! Selamat datang {$user->name}!",
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '❌ Ups! Nama atau kata sandi salah'
        ], 401);
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'avatar' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->name) . '@kidslearn.com',
            'password' => Hash::make($request->password),
            'avatar' => $request->avatar,
        ]);

        // Create initial progress
        $user->getOrCreateProgress();

        return response()->json([
            'success' => true,
            'message' => '🎉 Hore! Akun berhasil dibuat!',
            'redirect' => route('login')
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
