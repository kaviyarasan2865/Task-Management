<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   // Show login form
   public function showLoginForm()
   {
       return view('auth.login');
   }

   // Handle login
   public function login(Request $request)
   {
       $credentials = $request->only('email', 'password');

       if (Auth::attempt($credentials)) {
           $user = Auth::user();
           if ($user->role == 1) {
               return redirect()->route('dash');
           } elseif ($user->role == 2) {
               return redirect()->route('employee.dashboard');
           }
       }

       return redirect()->route('login')->withErrors('Invalid Credentials');
   }

   // Logout
   public function logout(Request $request)
   {
       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();
       return redirect()->route('login');
   }
}
