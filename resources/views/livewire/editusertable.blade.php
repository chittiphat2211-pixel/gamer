<div>
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">Form Validation</h1>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Validation</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-4">


                    <!-- Custom validation -->
                    <div class="col-lg-6">
                        <div class="card card-info card-outline mb-4">
                            <div class="card-header">
                                <div class="card-title">Custom Validation</div>
                            </div>
                            {{-- ฟอร์มนี้แก้ข้อมูลของผู้ใช้ที่เลือกไว้ เมื่อกดบันทึก Livewire จะส่งค่ามาที่ updateUser โดยไม่ต้องโหลดหน้าใหม่ --}}
                            <form wire:submit.prevent="updateUser" class="needs-validation">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            {{-- wire:model ผูกช่องนี้กับตัวแปร name ใน component เพื่อให้ตรวจสอบและบันทึกชื่อใหม่ได้ --}}
                                            <label for="validationCustom01" class="form-label">Name</label>
                                            <input type="text" wire:model="name" class="form-control"
                                                id="validationCustom01" required />
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            {{-- อีเมลถูกผูกกับ component เพื่อเช็กความถูกต้องและป้องกันอีเมลซ้ำก่อนบันทึก --}}
                                            <label for="validationCustom02" class="form-label">Email</label>
                                            <input type="email" wire:model="email" class="form-control"
                                                id="validationCustom02" required />
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6">
                                            {{-- รหัสผ่านเป็นตัวเลือก: ถ้าเว้นว่าง ระบบจะคงรหัสผ่านเดิมไว้ --}}
                                            <label for="validationCustom03" class="form-label">Password</label>
                                            <input type="password" wire:model="password" class="form-control"
                                                id="validationCustom03" placeholder="Leave blank to keep the current password" />
                                            <div class="valid-feedback">Looks good!</div>
                                            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    {{-- ปุ่มนี้ส่งฟอร์มให้ Livewire เรียก updateUser ตามที่กำหนดไว้ด้านบน --}}
                                    <button class="btn btn-info" type="submit">Submit form</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>
</main>
</div>