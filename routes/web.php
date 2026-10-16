<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // เมื่อผู้ใช้เปิด URL หลัก ระบบจะพาไปหน้าคลังสูตรซึ่งเป็นหน้าหลักของแอป
    return redirect()->route('recipes');
});
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// route นี้อ่านหมวดสูตรจาก config แล้วส่งให้ Blade วนสร้างตัวกรองและรายการเมนู
Route::get('/recipes', function () {
    return view('recipes', ['categories' => config('thai_dessert_course.categories')]);
})->name('recipes');

// ก่อนเปิด dashboard หรือหน้าจัดการผู้ใช้ กลุ่ม middleware นี้จะตรวจ login และสถานะยืนยันอีเมล
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $categories = config('thai_dessert_course.categories');
        $recipes = [];

        // ส่วนนี้รวมสูตรทุกหมวดไว้ชุดเดียว เพื่อคำนวณจำนวนเมนูและเวลาทำอาหารสำหรับ dashboard
        foreach ($categories as $category) {
            foreach ($category['recipes'] as $recipe) {
                $recipes[] = $recipe;
            }
        }

        $minutes = array_column($recipes, 'minutes');

        // หลังคำนวณเสร็จ ระบบส่งหมวด สถิติ และเมนูแนะนำไปให้ Blade แสดงผล
        return view('course-dashboard', [
            'categories' => $categories,
            'recipeCount' => count($recipes),
            'quickRecipeCount' => count(array_filter($recipes, function ($recipe) {
                return $recipe['minutes'] <= 40;
            })),
            'minimumMinutes' => min($minutes),
            'maximumMinutes' => max($minutes),
            'featuredRecipe' => $recipes[2],
        ]);
    })->name('dashboard');
    
    // routes เหล่านี้เปิดหน้า wrapper ที่ฝัง Livewire สำหรับแสดง เพิ่ม และแก้ไขข้อมูลผู้ใช้
    Route::get('/users', function () {
        return view('users');
    })->name('users');

     Route::get('/adduser', function () {
        return view('adduser');
    })->name('adduser');

      Route::get('/edituser/{id}', function ($id) {
        return view('edituser', compact('id'));
    })->name('edituser');
});
