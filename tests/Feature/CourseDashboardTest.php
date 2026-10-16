<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_redirects_to_recipe_catalog(): void
    {
        // เมื่อเปิดหน้าแรก ระบบควรพาไปคลังสูตร เพื่อให้ผู้ใช้เริ่มดูเมนูได้ทันที
        $this->get('/')->assertRedirect(route('recipes'));
    }

    public function test_authenticated_dashboard_uses_recipe_catalog_data(): void
    {
        // หลัง login ผู้ใช้ควรเห็น dashboard ที่ดึงสถิติและหมวดจากข้อมูลสูตรชุดเดียวกัน
        $response = $this->actingAs(User::factory()->create())->get(route('dashboard'));

        $response->assertOk()
            ->assertSeeText('ห้องเรียนออนไลน์')
            ->assertSeeText('50')
            ->assertSeeText('ขนมต้มและขนมเปียก');
    }
}
