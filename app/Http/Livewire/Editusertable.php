<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Editusertable extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password; // รับรหัสผ่านใหม่จากฟอร์ม แต่เว้นว่างได้ถ้าไม่ต้องการเปลี่ยน

    public function mount($userId)
    {
        // เมื่อเปิดหน้า ระบบใช้ id จาก route ค้นหาผู้ใช้ แล้วเติมชื่อและอีเมลเดิมลงในฟอร์ม
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        
        $this->name = $user->name;
        $this->email = $user->email;
        // ไม่ดึงรหัสผ่านเดิมมาใส่ฟอร์ม เพราะฐานข้อมูลเก็บเป็น hash และไม่ควรเปิดเผยกลับมา
    }

    public function updateUser()
    {
        // กฎนี้ยอมให้อีเมลเดิมของผู้ใช้นี้อยู่ต่อ แต่ป้องกันไม่ให้เปลี่ยนไปใช้อีเมลของคนอื่น
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            // ช่องนี้ไม่บังคับกรอก; ถ้ากรอกเพื่อเปลี่ยนรหัสใหม่ ต้องมีอย่างน้อย 6 ตัว
            'password' => 'nullable|min:6',
        ];

        $this->validate($rules);

        // หลังตรวจผ่าน ระบบเตรียมชื่อและอีเมลใหม่ ส่วนรหัสผ่านจะเพิ่มเมื่อผู้ใช้กรอกค่าใหม่เท่านั้น
        $user = User::findOrFail($this->userId);
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        // ถ้ากรอกรหัสผ่านใหม่ ระบบ hash ค่านั้นก่อนบันทึก; ถ้าเว้นว่างรหัสผ่านเดิมจะคงอยู่
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        session()->flash('message', 'อัปเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว!');

        return redirect()->to('/users');
    }

    public function render()
    {
        return view('livewire.editusertable');
    }
}