<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Check if user already logged in via session
        if (session()->has('user_id')) {
            return redirect()->route('home');
        }

        // Check if remember me cookie exists
        $rememberToken = Cookie::get('remember_token');
        if ($rememberToken) {
            $user = User::where('remember_token', $rememberToken)->first();
            if ($user) {
                session(['user_id' => $user->id, 'user_name' => $user->name, 'user_email' => $user->email]);
                return redirect()->route('home');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Set session
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);

            // Handle remember me
            if ($request->has('remember')) {
                $rememberToken = bin2hex(random_bytes(32));
                $user->remember_token = $rememberToken;
                $user->save();

                // Set cookie for 7 days
                Cookie::queue('remember_token', $rememberToken, 7 * 24 * 60);
            }

            return redirect()->route('home')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function showRegister()
    {
        if (session()->has('user_id')) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto login after register
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    public function logout()
    {
        // Get current user to clear remember token
        $userId = session('user_id');
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
        }

        // Clear session
        session()->flush();

        // Clear remember me cookie
        Cookie::queue(Cookie::forget('remember_token'));

        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }
}