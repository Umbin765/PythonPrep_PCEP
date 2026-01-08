<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $adminEmail = config('admin.email');
        $hash = config('admin.password_hash');
        $plain = config('admin.password');

        $emailMatch = $adminEmail && strtolower($validated['email']) === strtolower($adminEmail);
        $passwordMatch = false;

        if ($hash) {
            $passwordMatch = password_verify($validated['password'], $hash);
        } elseif ($plain) {
            $passwordMatch = hash_equals($plain, $validated['password']);
        }

        if (!$emailMatch || !$passwordMatch) {
            return back()->withErrors(['email' => 'Admin login failed.'])->withInput();
        }

        $request->session()->put('is_admin', true);
        $request->session()->put('admin_email', $adminEmail);

        return redirect()->route('questions.create');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['is_admin', 'admin_email']);

        return redirect()->route('home');
    }
}
