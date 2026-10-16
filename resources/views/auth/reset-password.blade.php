{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- หัวข้อและคำอธิบายการตั้งรหัสผ่านใหม่ --}}
    <h2>ตั้งรหัสผ่านใหม่</h2>
    <p class="auth-intro">ตั้งรหัสผ่านใหม่เพื่อกลับเข้าสู่ครัวขนมไทย</p>

    {{-- แสดงข้อผิดพลาดจากการตรวจสอบ token อีเมล หรือรหัสผ่าน --}}
    @if ($errors->any())
        <ul class="auth-errors" role="alert">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- ส่ง token จากอีเมลพร้อมรหัสผ่านใหม่ เพื่อให้ Fortify ตรวจลิงก์ก่อนบันทึก --}}
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        {{-- token ซ่อนจากหน้าจอ ใช้ยืนยันว่าคำขอมาจากลิงก์รีเซ็ตที่ถูกต้อง --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        {{-- รับอีเมลบัญชี; ใช้ค่าที่ส่งกลับมาก่อน แล้วจึงใช้ค่าอีเมลจากคำขอ --}}
        <div class="auth-field">
            <label for="email">อีเมล</label>
            <input class="auth-input" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" autocomplete="username" required autofocus>
        </div>
        {{-- รับรหัสผ่านใหม่ --}}
        <div class="auth-field">
            <label for="password">รหัสผ่านใหม่</label>
            <input class="auth-input" id="password" type="password" name="password" autocomplete="new-password" required>
        </div>
        {{-- รับรหัสผ่านใหม่ซ้ำเพื่อให้ระบบตรวจความตรงกัน --}}
        <div class="auth-field">
            <label for="password_confirmation">ยืนยันรหัสผ่านใหม่</label>
            <input class="auth-input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
        </div>
        {{-- ส่ง token และข้อมูลใหม่เพื่อบันทึกรหัสผ่าน --}}
        <button class="auth-button" type="submit">บันทึกรหัสผ่านใหม่</button>
    </form>
</x-guest-layout>
