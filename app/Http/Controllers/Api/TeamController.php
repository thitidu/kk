<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    // GET /api/teams
    public function index()
    {
        //
        // $teams = Team::with('players')->get();
         $teams = Team::all();

        return response()->json([
            'message' => 'แสดงข้อมูลทีมทั้งหมด',
            'data' => $teams
        ]);
    }

    // GET /api/teams/{id}
    public function show($id)
    {
        $team = Team::with('players')->find($id);

        if (!$team) {
            return response()->json([
                'message' => 'ไม่พบข้อมูลทีม'
            ], 404);
        }

        return response()->json([
            'message' => 'พบข้อมูลทีม',
            'data' => $team
        ]);
    }

public function store(\Illuminate\Http\Request $request)
{
    $data = [
        'name' => $request->header('name'),
        'short_name' => $request->header('short_name'),
        'stadium' => $request->header('stadium'),
        'city' => $request->header('city'),
    ];

    $validator = \Illuminate\Support\Facades\Validator::make(
        $data,
        [
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:10',
            'stadium' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'ข้อมูลทีมไม่ถูกต้อง',
            'errors' => $validator->errors(),
        ], 422);
    }

    try {
        $team = \App\Models\Team::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'บันทึกทีมสำเร็จ',
            'data' => $team,
        ], 201);
    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'บันทึกทีมไม่สำเร็จ',
            'error' => config('app.debug')
                ? $e->getMessage()
                : 'เกิดข้อผิดพลาดในระบบ',
        ], 500);
    }
}


    // PUT /api/teams/{id}
  
public function update(Request $request, $id)
{
    $team = \App\Models\Team::find($id);

    if (!$team) {
        return response()->json([
            'success' => false,
            'message' => 'ไม่พบทีม ID ' . $id
        ], 404);
    }

    // อ่านค่าจาก Headers
    $data = [];

    foreach (['name', 'short_name', 'stadium', 'city'] as $field) {
        if ($request->hasHeader($field)) {
            $data[$field] = $request->header($field);
        }
    }

    if (empty($data)) {
        return response()->json([
            'success' => false,
            'message' => 'กรุณากรอกข้อมูลใน Headers'
        ], 422);
    }

    $validator = \Illuminate\Support\Facades\Validator::make(
        $data,
        [
            'name' => 'sometimes|required|string|max:255',
            'short_name' => 'sometimes|required|string|max:10',
            'stadium' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'ข้อมูลไม่ถูกต้อง',
            'errors' => $validator->errors()
        ], 422);
    }

    $team->update($data);

    return response()->json([
        'success' => true,
        'message' => 'แก้ไขทีมสำเร็จ',
        'data' => $team->fresh()
    ], 200);
}

    // DELETE /api/teams/{id}
    public function destroy($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json([
                'message' => 'ไม่พบข้อมูลทีม'
            ], 404);
        }

        $team->delete();

        return response()->json([
            'message' => 'ลบข้อมูลทีมสำเร็จ'
        ]);
    }
}