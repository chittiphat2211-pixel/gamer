{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- หัวข้อและคำอธิบายวิธีขอลิงก์ตั้งรหัสผ่านใหม่ --}}
    <h2>ลืมรหัสผ่าน</h2>
    <p class="auth-intro">กรอกอีเมลที่ใช้สมัคร เราจะส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ให้</p>

    {{-- แสดงผลการส่งลิงก์หรือสถานะจากคำขอก่อนหน้า --}}
    @if (session('status'))
        <div class="auth-alert" role="status">{{ session('status') }}</div>
    @endif

    {{-- แสดงข้อผิดพลาดจากการตรวจสอบอีเมล --}}
    @if ($errors->any())
        <ul class="auth-errors" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- เมื่อส่งอีเมล Fortify จะสร้างลิงก์ตั้งรหัสผ่านใหม่และส่ง notification ไปให้เจ้าของบัญชี --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        {{-- รับอีเมลบัญชี; old('email') คืนค่าที่กรอกไว้หากการตรวจสอบไม่ผ่าน --}}
        <div class="auth-field">
            <label for="email">อีเมล</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        </div>
        <button class="auth-button" type="submit">ส่งลิงก์ตั้งรหัสผ่านใหม่</button>
    </form>

    {{-- ให้กลับไปเข้าสู่ระบบหรือไปหน้าสมัครสมาชิกได้ --}}
    <div class="auth-links">
        <a class="auth-link" href="{{ route('login') }}">กลับไปเข้าสู่ระบบ</a>
        <a class="auth-link" href="{{ route('register') }}">สมัครสมาชิก</a>
    </div>
</x-guest-layout>
