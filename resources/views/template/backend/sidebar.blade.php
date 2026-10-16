<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ route('dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <i class="bi bi-flower1 brand-image opacity-75" aria-hidden="true"></i>
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">ครัวขนมไทย</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Search-->
        <div class="sidebar-search" role="search">
          <label for="sidebar-search-input" class="visually-hidden">ค้นหาเมนู</label>
          <input
            type="search"
            id="sidebar-search-input"
            class="form-control form-control-sm"
            placeholder="ค้นหาเมนู..."
            autocomplete="off"
            data-lte-toggle="sidebar-search"
            data-lte-target="#navigation"
          />
          <p class="fs-7 text-secondary mt-2 mb-0" data-lte-search-empty role="status" hidden>
            ไม่พบเมนูที่ค้นหา
          </p>
        </div>
        <!--end::Sidebar Search-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="nav-icon bi bi-house-heart"></i>
                  <p>ภาพรวมห้องเรียน</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('recipes') }}" class="nav-link">
                  <i class="nav-icon bi bi-journal-richtext"></i>
                  <p>สูตรขนมไทย</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('users') }}" class="nav-link">
                  <i class="nav-icon bi bi-people"></i>
                  <p>ผู้เรียน</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('api-tokens.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-key"></i>
                  <p>API token</p>
                </a>
              </li>

              
            <!--end::Sidebar Menu-->

            <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
              <a
                href="{{ route('recipes') }}"
                class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2"
              >
                <i class="bi bi-journal-richtext" aria-hidden="true"></i>
                เปิดคลังสูตร
              </a>
            </div>
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
</aside>