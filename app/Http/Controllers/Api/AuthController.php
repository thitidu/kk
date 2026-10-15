<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // รับข้อมูลจาก Headers
        $name = $request->header('name');
        $email = $request->header('email');
        $password = $request->header('password');

        // ตรวจสอบข้อมูล
        if (!$name || !$email || !$password) {
            return response()->json([
                'success' => false,
                'message' => 'กรุณากรอก name, email และ password ใน Headers'
            ], 400);
        }

        // ตรวจสอบ Email ซ้ำ
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email นี้มีผู้ใช้งานแล้ว'
            ], 409);
        }

        // สร้าง User
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        
        return response()->json([
            'success' => true,
            'message' => 'สมัครสมาชิกสำเร็จ',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]
        ], 201);
    }


    // =========================
    // LOGIN
    // =========================
    public function login(Request $request)
    {
        // รับข้อมูลจาก Headers
        $email = $request->header('email');
        $password = $request->header('password');

        // ตรวจสอบข้อมูล
        if (!$email || !$password) {
            return response()->json([
                'success' => false,
                'message' => 'กรุณากรอก email และ password ใน Headers'
            ], 400);
        }

        // ค้นหา User
        $user = User::where('email', $email)->first();

        // ตรวจสอบ Password
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email หรือ Password ไม่ถูกต้อง'
            ], 401);
        }

        // สร้าง Token
        $token = $user->createToken(
            'premierleague-token'
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login สำเร็จ',

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],

            'token' => $token
        ], 200);
    }


    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        $request->user()
                ->currentAccessToken()
                ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout สำเร็จ'
        ], 200);
    }
}
