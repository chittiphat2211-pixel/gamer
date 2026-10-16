{{-- แสดงเอกสารข้อกำหนดการใช้งานใน layout สำหรับผู้เยี่ยมชม --}}
<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            {{-- แสดงเนื้อหาข้อกำหนดที่ backend ส่งมาในรูป HTML ที่จัดรูปแบบแล้ว --}}
            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
