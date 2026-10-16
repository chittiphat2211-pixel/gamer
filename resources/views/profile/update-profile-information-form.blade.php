{{-- ฟอร์ม Livewire ส่งข้อมูลไปจัดการด้วยเมธอด updateProfileInformation --}}
<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    {{-- ช่องข้อมูลและรูปภาพที่ใช้แก้ไขโปรไฟล์ --}}
    <x-slot name="form">
        {{-- ส่วนรูปโปรไฟล์จะแสดงเมื่อ Jetstream เปิดใช้การจัดการรูปภาพ --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                {{-- รับไฟล์รูปและใช้ Alpine.js สร้างตัวอย่างก่อนอัปโหลด --}}
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                {{-- แสดงรูปโปรไฟล์ปัจจุบันเมื่อยังไม่มีตัวอย่างรูปใหม่ --}}
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                {{-- แสดงตัวอย่างรูปใหม่หลังเลือกไฟล์ --}}
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                {{-- เปิดหน้าต่างเลือกไฟล์รูปภาพ --}}
                <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                {{-- แสดงปุ่มลบเมื่อบัญชีมีรูปโปรไฟล์ที่บันทึกไว้ --}}
                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        {{-- ช่องแก้ไขชื่อที่แสดงในบัญชี --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        {{-- ช่องแก้ไขอีเมลและแสดงสถานะการยืนยัน --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            {{-- ถ้ายังไม่ยืนยันอีเมลและเปิดฟีเจอร์นี้ ให้แสดงปุ่มส่งลิงก์ยืนยันใหม่ --}}
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                {{-- แจ้งผลเมื่อส่งลิงก์ยืนยันอีเมลฉบับใหม่แล้ว --}}
                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    {{-- แสดงผลเมื่อบันทึกสำเร็จและปุ่มบันทึก; ปิดปุ่มระหว่างอัปโหลดรูป --}}
    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
