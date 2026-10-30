<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLogin() {
        return view('auth.login');
    }

    // 2. Proses Login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role untuk Redirect
            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/dashboard');
            }

            // User biasa masuk ke Home App
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 3. Tampilkan Form Register (INI YANG KAMU CARI)
    public function showRegister() {
        return view('auth.register');
    }

    // 4. Proses Register (Khusus User Biasa)
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default selalu user
        ]);

        // Otomatis login setelah daftar
        Auth::login($user);

        // Langsung arahkan ke halaman aplikasi user
        return redirect('/home');
    }

    // 5. Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}