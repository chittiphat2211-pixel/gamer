<div>
    <x-form-section submit="createApiToken">
        <x-slot name="title">
            สร้าง API token
        </x-slot>

        <x-slot name="description">
            สร้าง token เพื่อให้ Thunder Client หรือระบบอื่นเรียก API ในนามบัญชีนี้
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="ชื่อ token" />
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="createApiTokenForm.name" autofocus />
                <x-input-error for="name" class="mt-2" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <div class="col-span-6">
                    <x-label for="permissions" value="สิทธิ์การใช้งาน" />
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <label class="flex items-center">
                                <x-checkbox wire:model.defer="createApiTokenForm.permissions" :value="$permission" />
                                <span class="ml-2 text-sm text-gray-600">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="created">สร้าง token แล้ว</x-action-message>
            <x-button>สร้าง token</x-button>
        </x-slot>
    </x-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <x-section-border />
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">จัดการ token ที่มีอยู่</x-slot>
                <x-slot name="description">ลบ token ที่ไม่ต้องการใช้งานแล้วเพื่อยกเลิกสิทธิ์การเข้าถึง</x-slot>
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="flex items-center justify-between">
                                <div class="break-all">{{ $token->name }}</div>
                                <div class="flex items-center ml-2">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-gray-400">ใช้ล่าสุด {{ $token->last_used_at->diffForHumans() }}</div>
                                    @endif
                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <button class="cursor-pointer ml-6 text-sm text-gray-400 underline" wire:click="manageApiTokenPermissions({{ $token->id }})">สิทธิ์</button>
                                    @endif
                                    <button class="cursor-pointer ml-6 text-sm text-red-500" wire:click="confirmApiTokenDeletion({{ $token->id }})">ลบ</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <x-dialog-modal wire:model="displayingToken">
        <x-slot name="title">API token</x-slot>
        <x-slot name="content">
            <div>คัดลอก token นี้เก็บไว้ ระบบจะแสดงให้เห็นครั้งนี้ครั้งเดียว</div>
            <x-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                class="mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500 w-full break-all"
                autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)" />
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">ปิด</x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="managingApiTokenPermissions">
        <x-slot name="title">สิทธิ์ API token</x-slot>
        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <label class="flex items-center">
                        <x-checkbox wire:model.defer="updateApiTokenForm.permissions" :value="$permission" />
                        <span class="ml-2 text-sm text-gray-600">{{ $permission }}</span>
                    </label>
                @endforeach
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">ยกเลิก</x-secondary-button>
            <x-button class="ml-3" wire:click="updateApiToken" wire:loading.attr="disabled">บันทึก</x-button>
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal wire:model="confirmingApiTokenDeletion">
        <x-slot name="title">ลบ API token</x-slot>
        <x-slot name="content">ต้องการลบ API token นี้หรือไม่?</x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">ยกเลิก</x-secondary-button>
            <x-danger-button class="ml-3" wire:click="deleteApiToken" wire:loading.attr="disabled">ลบ token</x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
                    คัดลอก token นี้เก็บไว้ ระบบจะแสดงให้เห็นครั้งนี้ครั้งเดียว
