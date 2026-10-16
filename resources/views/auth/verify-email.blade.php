{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- แสดงหน้าตรวจสอบอีเมลภายในการ์ด พร้อมโลโก้ของแอป --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- อธิบายให้ผู้ใช้กดลิงก์ยืนยันที่ส่งไปทางอีเมล --}}
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        {{-- แจ้งผลเมื่อส่งลิงก์ยืนยันฉบับใหม่สำเร็จ --}}
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        {{-- วางปุ่มส่งลิงก์ใหม่และตัวเลือกจัดการบัญชีไว้ในแถวเดียวกัน --}}
        <div class="mt-4 flex items-center justify-between">
            {{-- ขอให้ระบบส่งอีเมลยืนยันใหม่ --}}
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <div>
                {{-- ไปหน้าแก้ไขข้อมูลโปรไฟล์ --}}
                <a
                    href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('Edit Profile') }}</a>

                {{-- ส่งคำขอออกจากระบบ --}}
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ml-2">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
