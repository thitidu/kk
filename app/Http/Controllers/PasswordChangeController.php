<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function update(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user) {
            return back()
                ->withErrors(['email' => 'ไม่พบบัญชีที่ใช้อีเมลนี้'])
                ->withInput($request->only('email'));
        }

        $user->forceFill([
            'password' => Hash::make($data['password']),
            'remember_token' => null,
        ])->save();
        $user->tokens()->delete();
        \Illuminate\Support\Facades\Password::broker()->deleteToken($user);

        return redirect()->route('login')->with('status', 'เปลี่ยนรหัสผ่านสำเร็จ กรุณาเข้าสู่ระบบด้วยรหัสผ่านใหม่');
    }
}
