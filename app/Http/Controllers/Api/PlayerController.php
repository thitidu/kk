<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;

class PlayerController extends Controller
{
    // GET: แสดงและค้นหานักฟุตบอล
    public function index(Request $request)
    {
        $query = Player::with('team');

        if ($request->query('name')) {
            $query->where(
                'name',
                'like',
                '%' . $request->query('name') . '%'
            );
        }

        if ($request->query('position')) {
            $query->where('position', $request->query('position'));
        }

        if ($request->query('team_id')) {
            $query->where('team_id', $request->query('team_id'));
        }

        $players = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'ค้นหานักฟุตบอลสำเร็จ',
            'total' => $players->count(),
            'data' => $players
        ], 200);
    }

    // GET: แสดงนักฟุตบอลตาม ID
    public function show($id)
    {
        $player = Player::with('team')->find($id);

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลนักฟุตบอล'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'พบข้อมูลนักฟุตบอล',
            'data' => $player
        ], 200);
    }

    // POST: เพิ่มนักฟุตบอลจาก Headers
    public function store(Request $request)
    {
        $data = [
            'team_id' => $request->header('team_id'),
            'name' => $request->header('name'),
            'position' => $request->header('position'),
            'nationality' => $request->header('nationality'),
            'shirt_number' => $request->header('shirt_number'),
            'age' => $request->header('age'),
        ];

        $validator = Validator::make($data, [
            'team_id' => 'required|integer|exists:teams,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'nationality' => 'required|string|max:100',
            'shirt_number' => 'nullable|integer|min:1|max:99',
            'age' => 'nullable|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ข้อมูลนักฟุตบอลไม่ถูกต้อง',
                'errors' => $validator->errors()
            ], 422);
        }

        $player = Player::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มนักฟุตบอลสำเร็จ',
            'data' => $player->load('team')
        ], 201);
    }

    // PUT: แก้ไขนักฟุตบอลจาก Headers
    public function update(Request $request, $id)
    {
        $player = Player::find($id);

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลนักฟุตบอล ID ' . $id
            ], 404);
        }

        $fields = [
            'team_id',
            'name',
            'position',
            'nationality',
            'shirt_number',
            'age'
        ];

        $data = [];

        foreach ($fields as $field) {
            if ($request->headers->has($field)) {
                $data[$field] = $request->header($field);
            }
        }

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'กรุณาระบุข้อมูลที่ต้องการแก้ไขใน Headers'
            ], 422);
        }

        $validator = Validator::make($data, [
            'team_id' => 'sometimes|required|integer|exists:teams,id',
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:100',
            'nationality' => 'sometimes|required|string|max:100',
            'shirt_number' => 'sometimes|nullable|integer|min:1|max:99',
            'age' => 'sometimes|nullable|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ข้อมูลที่แก้ไขไม่ถูกต้อง',
                'errors' => $validator->errors()
            ], 422);
        }

        $player->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขข้อมูลนักฟุตบอลสำเร็จ',
            'data' => $player->fresh()->load('team')
        ], 200);
    }

    // DELETE: ลบนักฟุตบอลตาม ID
    public function destroy($id)
    {
        $player = Player::with('team')->find($id);

        if (!$player) {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลนักฟุตบอล ID ' . $id
            ], 404);
        }

        // เก็บข้อมูลไว้ก่อนลบ เพื่อส่งกลับเป็น JSON
        $deletedPlayer = $player->toArray();

        $player->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบนักฟุตบอลสำเร็จ',
            'data' => $deletedPlayer
        ], 200);
    }
}