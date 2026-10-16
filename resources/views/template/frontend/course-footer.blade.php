<style>
    .thai-site-footer {
        padding: 26px 0;
        color: #e9efe9;
        background: #26342f;
        font-size: 13px;
    }

    .thai-site-footer-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .thai-site-footer a { color: #f2ce88; text-decoration: none; }
    .thai-site-footer a:hover { text-decoration: underline; }

    @media (max-width: 575px) {
        .thai-site-footer-inner { align-items: flex-start; flex-direction: column; }
    }
</style>
<footer class="thai-site-footer">
    <div class="container thai-site-footer-inner">
        <span>© {{ date('Y') }} ครัวขนมไทย · สูตรและความรู้ขนมไทยสำหรับทุกครัว</span>
        <a href="{{ route('recipes') }}">กลับไปที่คลังสูตร</a>
    </div>
</footer>
