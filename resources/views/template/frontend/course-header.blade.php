<style>
    .thai-site-header {
        position: relative;
        z-index: 20;
        color: #26342f;
        background: #fff;
        border-bottom: 1px solid #e3e8e2;
    }

    .thai-site-header-inner {
        display: flex;
        min-height: 72px;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .thai-site-brand {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #285b48;
        font-family: Georgia, "Leelawadee UI", serif;
        font-size: 20px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .thai-site-brand:hover { color: #d66b4f; }

    .thai-site-nav {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 20px;
    }

    .thai-site-nav a {
        color: #4f5c54;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .thai-site-nav a:hover { color: #285b48; }

    .thai-site-nav .thai-site-cta {
        padding: 10px 14px;
        color: #fff;
        background: #285b48;
        border-radius: 3px;
    }

    .thai-site-nav .thai-site-cta:hover { color: #fff; background: #1e4938; }

    @media (max-width: 575px) {
        .thai-site-header-inner { min-height: 64px; gap: 10px; }
        .thai-site-brand { font-size: 17px; }
        .thai-site-nav { gap: 11px; }
        .thai-site-nav a { font-size: 12px; }
        .thai-site-nav .thai-site-cta { padding: 9px 10px; }
    }
</style>
<header class="thai-site-header">
    <div class="container thai-site-header-inner">
        <a class="thai-site-brand" href="{{ route('recipes') }}">
            <i class="fa fa-leaf" aria-hidden="true"></i>
            <span>ครัวขนมไทย</span>
        </a>
        {{-- ถ้ายังไม่ login จะแสดงปุ่มเข้าสู่ระบบ/สมัครสมาชิก แต่ถ้า login แล้วจะเห็นเมนูห้องเรียนและผู้เรียน --}}
        <nav class="thai-site-nav" aria-label="เมนูหลัก">
            <a href="{{ route('recipes') }}">คลังสูตร</a>
            @guest
                <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
                <a class="thai-site-cta" href="{{ route('register') }}">สมัครสมาชิก</a>
            @else
                <a href="{{ route('dashboard') }}">ห้องเรียน</a>
                <a href="{{ route('users') }}">ผู้เรียน</a>
            @endguest
        </nav>
    </div>
</header>
