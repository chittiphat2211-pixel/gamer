<div>

    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="mb-0 fs-3">รายชื่อผู้เรียน</h1>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">ภาพรวม</a></li>
                                <li class="breadcrumb-item active" aria-current="page">ผู้เรียน</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">ค้นหาและจัดการผู้เรียน</h3>
                                <div class="card-tools d-flex flex-wrap gap-2">
                                    {{-- Livewire รอ 300 มิลลิวินาทีหลังพิมพ์ จึงค่อยค้นหา เพื่อลด request ที่ไม่จำเป็น --}}
                                    <label class="visually-hidden" for="student-search">ค้นหาชื่อผู้เรียน</label>
                                    <input id="student-search" type="search" class="form-control form-control-sm" placeholder="ค้นหาชื่อผู้เรียน..." wire:model.debounce.300ms="search">
                                    <a href="{{ route('adduser') }}" class="btn btn-sm btn-success">เพิ่มผู้เรียน</a>
                                    <a href="{{ route('api-tokens.index') }}" class="btn btn-sm btn-outline-primary">จัดการ API token</a>
                                </div>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">Id</th>
                                            <th>ชื่อผู้เรียน</th>
                                            <th>อีเมล</th>
                                            <th>วันที่สมัคร</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- วนแสดงผู้ใช้ที่ component ค้นหาได้ และมีปุ่มไปหน้าแก้ไขหรือสั่งลบแต่ละรายการ --}}
                                        @forelse ($users as $data)
                                            <tr class="align-middle">
                                                <td>{{ $data->id }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ $data->created_at ? $data->created_at->format('d/m/Y H:i') : '-' }}</td>

                                                <td>
                                                    <!-- <span class="badge text-bg-danger">55%</span> -->
                                                    <div class="btn-group">
                                                        <a href="{{ route('edituser', $data->id) }}" class="btn btn-sm btn-info">แก้ไข</a>
                                                        <button type="button" wire:click="delete({{ $data->id }})" class="btn btn-sm btn-danger">ลบ</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="text-center text-body-secondary py-4">ไม่พบรายชื่อผู้เรียน</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->


                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
</div>