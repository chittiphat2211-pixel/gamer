<?php

namespace Tests\Feature;

use App\Http\Livewire\Editusertable;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_open_the_edit_user_form(): void
    {
        // เมื่อ login แล้ว ผู้ใช้ควรเปิดฟอร์มได้ และเห็นว่าช่องรหัสผ่านเว้นว่างเพื่อคงค่าเดิมได้
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create();

        $this->get(route('edituser', $user->id))
            ->assertOk()
            ->assertSee('Leave blank to keep the current password');
    }

    public function test_user_can_be_updated_without_changing_the_password(): void
    {
        // การทดสอบนี้ยืนยันว่าแก้ชื่อกับอีเมลได้ โดยไม่เปลี่ยนรหัสผ่านถ้าไม่ได้กรอกค่าใหม่
        $this->actingAs(User::factory()->create());
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        Livewire::test(Editusertable::class, ['userId' => $user->id])
            ->set('name', 'Updated Name')
            ->set('email', 'updated@example.com')
            ->call('updateUser')
            ->assertHasNoErrors()
            ->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}