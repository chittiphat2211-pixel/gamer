<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_search_requires_an_api_token(): void
    {
        // ถ้าไม่ส่ง token เข้ามา API ต้องตอบ unauthorized และไม่เปิดเผยรายชื่อผู้ใช้
        $this->getJson('/api/student?search=มะลิ')->assertUnauthorized();
    }

    public function test_read_token_can_search_students_by_name(): void
    {
        // token ที่ได้รับสิทธิ์ read ควรค้นหาชื่อได้ และผลลัพธ์ต้องตรงกับคำค้นที่ส่งมา
        User::factory()->create(['name' => 'มะลิ ใจดี']);
        User::factory()->create(['name' => 'ขวัญใจ พูนสุข']);
        $token = User::factory()->create()->createToken('student-search', ['read'])->plainTextToken;

        $this->withToken($token)
            ->getJson('/api/student?search=มะลิ')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'มะลิ ใจดี');
    }

    public function test_student_search_requires_read_permission(): void
    {
        // แม้ token จะยืนยันตัวตนได้ แต่ถ้าไม่มีสิทธิ์ read ระบบต้องปฏิเสธการค้นหา
        $token = User::factory()->create()->createToken('write-only', ['write'])->plainTextToken;

        $this->withToken($token)
            ->getJson('/api/student')
            ->assertForbidden();
    }

    public function test_student_table_can_be_filtered_by_name(): void
    {
        User::factory()->create(['name' => 'มะลิ ใจดี']);
        User::factory()->create(['name' => 'ขวัญใจ พูนสุข']);

        Livewire::test('useertable')
            ->assertSee('มะลิ ใจดี')
            ->assertSee('ขวัญใจ พูนสุข')
            ->set('search', 'มะลิ')
            ->assertSee('มะลิ ใจดี')
            ->assertDontSee('ขวัญใจ พูนสุข');
    }

    public function test_authenticated_user_can_open_api_token_manager(): void
    {
        $user = User::factory()->withPersonalTeam()->create();

        $this->actingAs($user)
            ->get(route('api-tokens.index'))
            ->assertOk()
            ->assertSee('Authorization: Bearer YOUR_TOKEN')
            ->assertSee('/api/student?search=');
    }
}
