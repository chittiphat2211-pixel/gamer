{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- หัวข้อและคำอธิบายของหน้าเข้าสู่ระบบ --}}
    <h2>ยินดีต้อนรับกลับ</h2>
    <p class="auth-intro">เข้าสู่ระบบเพื่อเก็บสูตรขนมไทยและจัดการการเรียนรู้ของคุณ</p>

    {{-- แสดงข้อความสถานะจากการทำงานก่อนหน้า เช่น การรีเซ็ตรหัสผ่าน --}}
    @if (session('status'))
        <div class="auth-alert" role="status">{{ session('status') }}</div>
    @endif

    {{-- แสดงรายการข้อผิดพลาดจากการตรวจสอบข้อมูล --}}
    @if ($errors->any())
        <ul class="auth-errors" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- เมื่อกดเข้าสู่ระบบ ฟอร์มส่งอีเมลกับรหัสผ่านให้ Fortify ตรวจ และใช้ CSRF token ป้องกันคำขอปลอม --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- ช่องกรอกอีเมล; old('email') เติมค่าที่เคยกรอกกลับเมื่อข้อมูลไม่ผ่านการตรวจสอบ --}}
        <div class="auth-field">
            <label for="email">อีเมล</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
        </div>
        {{-- ช่องกรอกรหัสผ่านปัจจุบัน โดยซ่อนตัวอักษรที่พิมพ์ --}}
        <div class="auth-field">
            <label for="password">รหัสผ่าน</label>
            <input class="auth-input" id="password" type="password" name="password" autocomplete="current-password" required>
        </div>
        {{-- เลือกเพื่อให้ระบบจดจำการเข้าสู่ระบบ --}}
        <label class="auth-remember"><input type="checkbox" name="remember" value="1"> จดจำฉันไว้</label>
        {{-- ปุ่มส่งอีเมลและรหัสผ่านไปตรวจสอบ --}}
        <div style="margin-top: 22px">
            <button class="auth-button" type="submit">เข้าสู่ระบบ</button>
        </div>
    </form>

    {{-- ลิงก์ไปหน้ากู้รหัสผ่านหรือสมัครบัญชีใหม่ --}}
    <div class="auth-links">
        <a class="auth-link" href="{{ route('password.request') }}">ลืมรหัสผ่าน?</a>
        <span>ยังไม่มีบัญชี? <a class="auth-link" href="{{ route('register') }}">สมัครสมาชิก</a></span>
    </div>
</x-guest-layout>