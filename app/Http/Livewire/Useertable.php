<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class Useertable extends Component
{
    public $search = '';

    // เมื่อได้รับ id ระบบค้นหาผู้ใช้ก่อน ถ้าพบจึงลบและส่งข้อความแจ้งผลกลับไปที่หน้า
    public function delete($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            session()->flash('message', 'ลบผู้ใช้งานเรียบร้อยแล้ว!');
        }
    }

    public function render()
    {
        // ถ้ามีคำค้น ระบบกรองชื่อแบบบางส่วน จากนั้นเรียงตามชื่อและส่งผลให้ตารางแสดง
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . trim($this->search) . '%');
            })
            ->orderBy('name')
            ->get();

        return view('livewire.useertable', [
            'users' => $users
        ]);
    }
}