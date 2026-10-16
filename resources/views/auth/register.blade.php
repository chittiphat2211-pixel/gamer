{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- หัวข้อและคำอธิบายการสร้างบัญชี --}}
    <h2>สมัครสมาชิก</h2>
    <p class="auth-intro">สร้างบัญชีเพื่อเริ่มเก็บสูตรและเรียนรู้ขนมไทย</p>

    {{-- แสดงข้อผิดพลาดจากการตรวจสอบข้อมูลสมัครสมาชิก --}}
    @if ($errors->any())
        <ul class="auth-errors" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- เมื่อสมัคร ฟอร์มส่งข้อมูลให้ Fortify เรียก CreateNewUser ตรวจความถูกต้องและบันทึกบัญชี --}}
    <form method="POST" action="{{ route('register') }}">
        @csrf
        {{-- รับชื่อที่ใช้แสดงและคืนค่าที่กรอกไว้หากข้อมูลไม่ผ่านการตรวจสอบ --}}
        <div class="auth-field">
            <label for="name">ชื่อที่ใช้แสดง</label>
            <input class="auth-input" id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus>
        </div>
        {{-- รับอีเมลสำหรับใช้เข้าสู่ระบบ --}}
        <div class="auth-field">
            <label for="email">อีเมล</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required>
        </div>
        {{-- รับรหัสผ่านใหม่ โดยเบราว์เซอร์จะจัดการในฐานะรหัสผ่านที่สร้างใหม่ --}}
        <div class="auth-field">
            <label for="password">รหัสผ่าน</label>
            <input class="auth-input" id="password" type="password" name="password" autocomplete="new-password" required>
        </div>
        {{-- รับรหัสผ่านซ้ำเพื่อให้ระบบตรวจว่าตรงกับช่องรหัสผ่าน --}}
        <div class="auth-field">
            <label for="password_confirmation">ยืนยันรหัสผ่าน</label>
            <input class="auth-input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        {{-- ส่งข้อมูลเพื่อสร้างบัญชีใหม่ --}}
        <button class="auth-button" type="submit">สมัครสมาชิก</button>
    </form>

    {{-- ลิงก์ไปหน้าเข้าสู่ระบบสำหรับผู้ที่มีบัญชีอยู่แล้ว --}}
    <div class="auth-links">
        <span>มีบัญชีแล้ว? <a class="auth-link" href="{{ route('login') }}">เข้าสู่ระบบ</a></span>
    </div>
</x-guest-layout>