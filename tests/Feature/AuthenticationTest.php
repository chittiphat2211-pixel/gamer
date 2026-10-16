<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        // ก่อนทดสอบการ login จริง ตรวจว่าผู้ใช้เปิดหน้าเข้าสู่ระบบได้ก่อน
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        // เมื่ออีเมลกับรหัสผ่านถูกต้อง ระบบต้องตั้งสถานะ login และพาไปหน้าเริ่มต้น
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        // ถ้ารหัสผ่านไม่ตรง ระบบต้องคงสถานะผู้ใช้เป็น guest และไม่สร้าง session login
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
