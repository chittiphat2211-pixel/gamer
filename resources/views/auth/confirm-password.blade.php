{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- แสดงเนื้อหาการยืนยันตัวตนภายในการ์ด พร้อมโลโก้ของแอป --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- แจ้งให้ผู้ใช้ยืนยันรหัสผ่านก่อนเข้าถึงส่วนที่ปลอดภัย --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        {{-- แสดงข้อผิดพลาดที่เกิดจากการตรวจสอบรหัสผ่าน --}}
        <x-validation-errors class="mb-4" />

        {{-- ส่งรหัสผ่านไปยังเส้นทางยืนยันรหัสผ่านของ Laravel --}}
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            {{-- ช่องกรอกรหัสผ่านปัจจุบัน; required บังคับให้กรอกก่อนส่ง --}}
            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            {{-- ปุ่มส่งรหัสผ่านเพื่อยืนยันตัวตน --}}
            <div class="flex justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
