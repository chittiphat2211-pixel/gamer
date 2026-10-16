<!DOCTYPE html>
<!doctype html>
<html lang="th">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#285b48">
        <title>ครัวขนมไทย | @if (request()->routeIs('register')) สมัครสมาชิก @elseif (request()->routeIs('password.request')) ลืมรหัสผ่าน @elseif (request()->routeIs('password.reset')) ตั้งรหัสผ่านใหม่ @else เข้าสู่ระบบ @endif</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root { color-scheme: light; --auth-ink: #26342f; --auth-leaf: #285b48; --auth-coral: #d66b4f; --auth-paper: #fbf8f1; }
            * { box-sizing: border-box; }
            body { min-width: 320px; min-height: 100vh; margin: 0; color: var(--auth-ink); background: var(--auth-paper); font-family: "Leelawadee UI", Tahoma, sans-serif; }
            .auth-page { min-height: 100vh; display: grid; grid-template-columns: minmax(0, 1.05fr) minmax(400px, .95fr); }
            .auth-story { position: relative; display: flex; min-height: 100vh; flex-direction: column; justify-content: space-between; overflow: hidden; padding: clamp(28px, 5vw, 72px); color: #fff; background: #214d3c; }
            .auth-story-image { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
            .auth-story::after { position: absolute; inset: 0; content: ""; background: rgba(23, 57, 43, .68); }
            .auth-brand, .auth-story-copy, .auth-photo-credit { position: relative; z-index: 1; }
            .auth-brand { color: #fff; font-family: Georgia, "Leelawadee UI", serif; font-size: 22px; font-weight: 700; text-decoration: none; }
            .auth-brand:hover { color: #f2ce88; }
            .auth-story-copy { max-width: 600px; padding: 50px 0; }
            .auth-kicker { margin: 0 0 12px; color: #f2ce88; font-size: 13px; font-weight: 700; letter-spacing: .08em; }
            .auth-story-copy h1 { margin: 0 0 18px; color: #fff; font-family: Georgia, "Leelawadee UI", serif; font-size: clamp(34px, 4vw, 58px); line-height: 1.25; }
            .auth-story-copy p { max-width: 470px; margin: 0; color: rgba(255,255,255,.88); font-size: 17px; line-height: 1.8; }
            .auth-photo-credit { align-self: flex-start; max-width: 100%; padding: 7px 10px; color: #fff; background: rgba(15, 35, 27, .65); font-size: 11px; line-height: 1.5; }
            .auth-photo-credit a { color: #fff; text-decoration: underline; text-underline-offset: 2px; }
            .auth-content { display: flex; min-height: 100vh; flex-direction: column; justify-content: center; padding: clamp(28px, 6vw, 84px); background: #fff; }
            .auth-content-inner { width: 100%; max-width: 460px; margin: auto; }
            .auth-back { display: inline-block; margin-bottom: 38px; color: var(--auth-leaf); font-size: 14px; font-weight: 600; text-decoration: none; }
            .auth-back:hover, .auth-link:hover { color: var(--auth-coral); }
            .auth-content h2 { margin: 0 0 8px; color: var(--auth-ink); font-family: Georgia, "Leelawadee UI", serif; font-size: 31px; line-height: 1.35; }
            .auth-intro { margin: 0 0 28px; color: #66716a; font-size: 14px; line-height: 1.7; }
            .auth-field { margin-bottom: 17px; }
            .auth-field label { display: block; margin-bottom: 7px; color: #39463f; font-size: 14px; font-weight: 600; }
            .auth-input { display: block; width: 100%; min-height: 48px; padding: 11px 13px; color: var(--auth-ink); background: #fff; border: 1px solid #d7ded8; border-radius: 3px; font: inherit; }
            .auth-input:focus { border-color: var(--auth-leaf); outline: 3px solid rgba(40, 91, 72, .14); }
            .auth-button { display: inline-flex; min-height: 48px; align-items: center; justify-content: center; padding: 11px 20px; color: #fff; background: var(--auth-leaf); border: 1px solid var(--auth-leaf); border-radius: 3px; font: inherit; font-weight: 700; cursor: pointer; }
            .auth-button:hover { background: #1e4938; }
            .auth-links { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 12px 20px; margin-top: 21px; color: #66716a; font-size: 14px; }
            .auth-link { color: var(--auth-leaf); font-weight: 600; text-decoration: none; }
            .auth-alert { margin: 0 0 18px; padding: 12px 14px; color: #21553c; background: #eaf5ee; border-left: 3px solid #4c9867; font-size: 14px; line-height: 1.6; }
            .auth-errors { margin: 0 0 18px; padding: 12px 14px 12px 32px; color: #8a3425; background: #fff0eb; border-left: 3px solid var(--auth-coral); font-size: 13px; line-height: 1.7; }
            .auth-remember { display: inline-flex; align-items: center; gap: 8px; color: #5a655e; font-size: 14px; }
            .auth-remember input { width: 16px; height: 16px; accent-color: var(--auth-leaf); }
            .auth-content .max-w-md { width: 100%; max-width: 460px; }
            @media (max-width: 800px) {
                .auth-page { grid-template-columns: 1fr; }
                .auth-story { min-height: 300px; padding: 24px; }
                .auth-story-copy { padding: 34px 0 25px; }
                .auth-story-copy h1 { font-size: 34px; }
                .auth-story-copy p { font-size: 15px; }
                .auth-content { min-height: auto; padding: 34px 24px 48px; }
                .auth-back { margin-bottom: 24px; }
                .auth-photo-credit { align-self: flex-start; }
            }
        </style>
    </head>
    <body>
        <main class="auth-page">
            <aside class="auth-story">
                <img class="auth-story-image" src="https://thumb.wikimedia.org/wikipedia/commons/thumb/6/63/Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg/960px-Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg" alt="ขนมถ้วยมะพร้าวและขนมใบเตยแบบไทย">
                <a class="auth-brand" href="{{ route('recipes') }}">ครัวขนมไทย</a>
                <div class="auth-story-copy">
                    <p class="auth-kicker">สูตรพื้นบ้าน · เรียนรู้ได้ทุกวัน</p>
                    <h1>หอมกะทิ หวานพอดี ทำเองได้ที่บ้าน</h1>
                    <p>ค้นพบสูตรขนมไทย เรียนรู้เทคนิค และบันทึกเมนูโปรดไว้ทำในครัวของคุณ</p>
                </div>
                <small class="auth-photo-credit">ภาพโดย Peachyeung316 · <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener noreferrer">CC BY-SA 4.0</a> · <a href="https://commons.wikimedia.org/wiki/File:Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg" target="_blank" rel="noopener noreferrer">ที่มาภาพ</a></small>
            </aside>
            <section class="auth-content">
                <div class="auth-content-inner">
                    <a class="auth-back" href="{{ route('recipes') }}">← กลับไปดูสูตรขนม</a>
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
