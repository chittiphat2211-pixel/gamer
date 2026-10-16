<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Addusertable extends Component
{
    public $name, $email, $password;

    // กฎเหล่านี้กำหนดว่าต้องมีชื่อ อีเมลที่ถูกต้องและไม่ซ้ำ รวมถึงรหัสผ่านอย่างน้อย 6 ตัว
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    // ฟังก์ชันนี้ทำงานเมื่อส่งฟอร์มเพิ่มผู้ใช้ โดยตรวจข้อมูลก่อนสร้าง record ใหม่
    public function addUser()
    {
        // ถ้าข้อมูลไม่ผ่านกฎ ระบบจะแสดงข้อผิดพลาดและไม่ทำขั้นตอนบันทึกต่อ
        $this->validate();

        // ก่อนบันทึกบัญชี ระบบ hash รหัสผ่านเพื่อไม่เก็บรหัสจริงลงฐานข้อมูล
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'เพิ่มผู้ใช้งานสำเร็จแล้ว!');

        return redirect()->to('/users');
    }

    // ฟังก์ชันนี้ใช้ลบผู้ใช้ตาม id และแจ้งผลเมื่อพบข้อมูลที่ต้องการลบ
    public function deleteUser($id)
    {
        $user = User::find($id);
        
        if ($user) {
            $user->delete();
            session()->flash('message', 'ลบผู้ใช้งานเรียบร้อยแล้ว!');
        }
    }

    public function render()
    {
        // ทุกครั้งที่ component แสดงผล ระบบอ่านรายชื่อปัจจุบันแล้วส่งให้ Blade สร้างตาราง
        return view('livewire.addusertable', [
            'users' => User::all()
        ]);
    }
}