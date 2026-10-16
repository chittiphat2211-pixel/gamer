{{-- ใช้โครงหน้าสำหรับผู้ใช้ที่ยังไม่ได้เข้าสู่ระบบ --}}
<x-guest-layout>
    {{-- แสดงหน้าตรวจสอบสองขั้นตอนภายในการ์ด พร้อมโลโก้ของแอป --}}
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        {{-- Alpine.js ใช้ recovery ควบคุมว่าจะกรอกรหัสจากแอปหรือรหัสสำรอง --}}
        <div x-data="{ recovery: false }">
            {{-- ข้อความแนะนำเมื่อใช้รหัสจากแอปยืนยันตัวตน --}}
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            {{-- ข้อความแนะนำเมื่อเลือกใช้รหัสสำรอง --}}
            <div class="mb-4 text-sm text-gray-600" x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            {{-- แสดงข้อผิดพลาดของรหัสยืนยัน --}}
            <x-validation-errors class="mb-4" />

            {{-- ส่งรหัสยืนยันไปตรวจสอบก่อนเข้าสู่ระบบ --}}
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                {{-- ช่องกรอกรหัสจากแอป; แสดงเมื่อไม่ได้อยู่ในโหมดรหัสสำรอง --}}
                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" class="block mt-1 w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                {{-- ช่องกรอกรหัสสำรอง; แสดงเมื่อเปิดโหมด recovery --}}
                <div class="mt-4" x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                    <x-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- สลับไปกรอกรหัสสำรองและโฟกัสช่องรหัสนั้น --}}
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    {{-- สลับกลับไปกรอกรหัสจากแอปและโฟกัสช่องรหัสนั้น --}}
                    <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    {{-- ส่งรหัสที่เลือกไปตรวจสอบเพื่อเข้าสู่ระบบ --}}
                    <x-button class="ml-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
