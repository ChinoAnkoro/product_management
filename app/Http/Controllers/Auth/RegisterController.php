<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            // カスタムメッセージ
            'email.unique' => 'このメールアドレスはすでに使用されています。',
            'password.confirmed' => 'パスワードが一致しません。',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        
        $user = $this->create($request->all());

        // 成功メッセージをセッションに保存
        session()->flash('status', '登録が成功しました！ログインしてください。');

        // ユーザーをログインさせる
        Auth::login($user);

        return redirect($this->redirectTo);
    }
}