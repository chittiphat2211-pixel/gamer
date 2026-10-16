<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// เมื่อรับอีเมลกับรหัสผ่าน ระบบจะตรวจบัญชีก่อนออก token ที่อนุญาตให้อ่านรายชื่อผู้เรียน
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $user = User::query()
        ->where('email', Str::lower(trim($credentials['email'])))
        ->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง'], 422);
    }

    $token = $user->createToken('student-search', ['read']);

    return response()->json([
        'access_token' => $token->plainTextToken,
        'token_type' => 'Bearer',
    ], 201);
})->middleware('throttle:5,1');

// route นี้ตรวจ token และสิทธิ์ read ก่อนค้นหาตามชื่อ แล้วส่งผลกลับครั้งละไม่เกิน 20 รายการ
Route::middleware('auth:sanctum')->get('/student', function (Request $request) {
    abort_unless($request->user()->tokenCan('read'), 403);

    $filters = $request->validate([
        'search' => ['nullable', 'string', 'max:100'],
    ]);

    $students = User::query()
        ->select(['id', 'name'])
        ->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('name')
        ->paginate(20)
        ->appends($request->query());

    return response()->json($students);
});
