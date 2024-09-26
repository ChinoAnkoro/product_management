<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/products';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');  // 'auth.login'はログイン画面のBladeテンプレート
    }

    protected function authenticated($user)
    {
        // リクエスト情報をログに記録（デバッグ用）
        Log::info('User logged in:', ['user' => $user->id, 'email' => $user->email]);

        // ログイン成功メッセージをセッションに保存
        session()->flash('status', 'ログインに成功しました！');

        // リダイレクトを防ぐために null を返します。
        return null;
    }
}
