<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->has('user'))
            return redirect()->back();
        return view('auth.login');
    }
    public function _login(LoginRequest $request)
    {
        $user = $request->only('username', 'password');
        $user = auth()->attempt($user);
        if ($user) {
            $request->session()->put('user', auth()->user());
            return redirect('/');
        }
        return redirect()->back()->with('login_failed', 'عفوا لا يوجد تطابق للإيميل و كلمة السر');
    }
    public function changePassword()
    {
        return view('auth.change-password');
    }
    public function _changePassword(ChangePasswordRequest $request)
    {
        $session_user = session()->get('user');
        $user = User::find($session_user->id);
        if (Hash::check($request->oldPassword, $user->password)) {
            $user = $user->update(['password' => $request->password]);
            if ($user)
                return redirect()->back()->with('success', 'تم تغيير كلمة السر بنجاح');
        }
        return redirect()->back()->with('password-error', 'كلمة السر القديمة غير صحيحه');
    }
    public function register()
    {
        $user = session()->get('user');
        if ($user->role == 'admin')
            return view('auth.add-user');
        return redirect()->back();
    }
    public function _register(RegisterRequest $request)
    {
        $user = session()->get('user');
        if ($user->role == 'admin') {
            $user = User::create($request->all());
            return redirect()->back()->with('success', 'تم اضافة المستخدم بنجاح');
        }
    }
    public function logout()
    {
        session()->forget('user');
        return redirect('login');
    }
}
