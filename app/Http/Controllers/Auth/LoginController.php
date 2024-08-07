<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';
    
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('makanan.index');
            } 
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return redirect()->route('makanan')->with('error', 'Password yang Anda masukkan salah.');
            } else {
                return redirect()->route('makanan')->with('error', 'Email yang Anda masukkan tidak terdaftar.');
            }
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('masuk');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}