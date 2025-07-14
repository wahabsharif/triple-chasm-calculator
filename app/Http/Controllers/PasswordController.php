<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function showForm()
    {
        return view('password');
    }

    public function check(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
        // Set your password here
        $correctPassword = 'password123'; // Change this to your actual password
        if ($request->password === $correctPassword) {
            $request->session()->put('password_authenticated', true);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Incorrect password.'], 401);
    }
}
