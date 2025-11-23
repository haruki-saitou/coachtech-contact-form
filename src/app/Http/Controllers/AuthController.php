<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ログイン画面の表示 (GET /login)
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // 登録画面の表示 (GET /register)
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // ログイン処理 (POST /login)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // ★ 修正点: ログイン後のリダイレクト先を 'home' から 'contacts.index' に変更
            return redirect()->route('contacts.index');
        }

        return back()->withErrors([
            'email' => '認証情報が記録と一致しません。',
        ]);
    }

    // ログアウト処理 (POST /logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ユーザー登録処理 (POST /register)
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tel' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
        ]);

        // ユーザーを即座にログインさせ、homeへリダイレクト
        Auth::login($user);

        // ★ 修正点: 登録後のリダイレクト先を 'home' から 'contacts.index' に変更
        return redirect()->route('contacts.index')->with('status', '登録が完了しました！');
    }
}
