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
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->filled('remember'))) {
            // Đăng nhập thành công, chuyển hướng đến trang chủ
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
