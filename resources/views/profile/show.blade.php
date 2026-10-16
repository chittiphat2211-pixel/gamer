{{-- ใช้โครงหน้าหลักของแอปสำหรับหน้าบัญชีผู้ใช้ --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- รวมแบบฟอร์มจัดการโปรไฟล์และความปลอดภัยไว้ในหน้าตั้งค่าบัญชี --}}
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- แสดงแบบฟอร์มข้อมูลโปรไฟล์เมื่อเปิดใช้ฟีเจอร์นี้ใน Fortify --}}
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            {{-- แสดงแบบฟอร์มเปลี่ยนรหัสผ่านเมื่อเปิดใช้ฟีเจอร์ --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            {{-- แสดงส่วนจัดการการยืนยันตัวตนสองขั้นตอนเมื่ออนุญาต --}}
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            {{-- แสดงส่วนตรวจสอบและออกจากระบบบนเบราว์เซอร์อื่น --}}
            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            {{-- แสดงส่วนลบบัญชีเมื่อ Jetstream เปิดใช้ความสามารถนี้ --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
