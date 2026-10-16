<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                จัดการ API token
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div class="mb-8 rounded-lg border border-green-200 bg-green-50 p-5 text-sm text-green-950">
                    <h3 class="mb-2 text-base font-semibold">ค้นหารายชื่อผู้เรียนผ่าน API</h3>
                    <p class="mb-2">สร้าง token ที่มีสิทธิ์ <strong>read</strong> แล้วส่ง token ใน header นี้:</p>
                    <code class="block overflow-x-auto rounded bg-white p-3">Authorization: Bearer YOUR_TOKEN</code>
                    <p class="mt-3 mb-1">ค้นหาด้วยชื่อผู้เรียน:</p>
                    <code class="block overflow-x-auto rounded bg-white p-3">GET {{ url('/api/student') }}?search=มะลิ</code>
                </div>
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-app-layout>
