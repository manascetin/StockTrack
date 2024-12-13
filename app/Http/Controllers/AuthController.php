<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Admin Login Page
    public function loginPage()
    {
        return view('login');
    }

    // Admin Login Functionality
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['login_error' => 'Kullanıcı bulunamadı.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Şifre doğrulama başarısız.']);
        }
        if ($user->remember_token !== '1') {
            return back()->withErrors(['login_error' => 'Hesap aktif değil. Giriş yapamazsınız.']);
        }

        // Şifre eşleşirse oturumu başlat ve yönlendir
        session(['user' => $user]);
        return redirect()->route('dashboard');
    }

    // User Login Page
    public function userLoginPage()
    {
        return view('userlogin');
    }

    // User Login Functionality
    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['login_error' => 'Kullanıcı bulunamadı.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login_error' => 'Şifre doğrulama başarısız.']);
        }
        

        // Şifre eşleşirse oturumu başlat ve yönlendir
        session(['user' => $user]);
        return redirect()->route('userdashboard');
    }


    // Logout Functionality
    public function logout()
    {
        session()->forget('user'); // Oturumu sıfırla
        return redirect()->route('login'); // Login sayfasına yönlendir
    }
}
