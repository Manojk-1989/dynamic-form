<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(AdminLoginRequest $request)
    {
        $validated = $request->validated();

        // Attempt login with email & password (ignore is_admin here)
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $request->session()->regenerate();
            
            // Check is_admin flag on authenticated user
            if (Auth::user()->is_admin) {
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('admin.dashboard')
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('user.form')
                ]);
            }
        }

        // If login fails
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials.',
        ], 422);
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
