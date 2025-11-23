<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| LaravelアプリケーションのWebインターフェース用のルートが登録されます。
|
*/

// --- 1. 未認証ユーザー向けの公開ルート ---
Route::group([], function () {
    // ログイン画面 (GET /login)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // ログイン処理 (POST /login)
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // 登録画面 (GET /register)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // 登録処理 (POST /register)
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});


// 2. お問い合わせ完了画面 (GET /thanks)
// ★ 修正点: 認証済みグループの前に配置し、確実にルーティングを読み込ませる
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');


// --- 3. 認証済みユーザー向けの保護されたルート ---
Route::middleware('auth')->group(function () {

    // ログアウト処理 (POST /logout)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ★★★ お問い合わせ機能のルート ★★★

    // 1. お問い合わせフォーム入力画面 (GET /)
    // アプリケーションの認証済みユーザー向けメインルート
    Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

    // 2. お問い合わせ内容確認画面 (POST /confirm)
    Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

    // 3. お問い合わせデータ保存処理 (POST /store)
    Route::post('/store', [ContactController::class, 'store'])->name('contacts.store');

    // 4. お問い合わせ履歴一覧表示ルート (GET /history)
    Route::get('/history', [ContactController::class, 'history'])->name('contacts.history');
});
