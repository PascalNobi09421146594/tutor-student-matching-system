<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'student') {
                 return redirect('/student/dashboard')
                    ->with('success', 'Welcome back! You have logged in successfully.');
            }

            if (Auth::user()->role === 'tutor') {
                return redirect('/tutor/dashboard')
                    ->with('success', 'Welcome back! You have logged in successfully.');
            }

            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard')
                    ->with('success', 'Welcome back! You have logged in successfully.');
            }

            Auth::logout();

            return redirect('/login')
                ->withErrors(['email' => 'Your account role is not recognised.']);
        }

        return back()
            ->withErrors(['email' => 'The email or password is incorrect.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
