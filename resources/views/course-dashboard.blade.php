@extends('template.backend.master')

@section('content')
<style>
    /* ส่วนนี้กำหนดหน้าตาเฉพาะของแดชบอร์ด ส่วนโครงหน้าใหญ่ยังใช้ layout backend ร่วมกัน */
    .course-dashboard {
        --dashboard-ink: #26342f;
        --dashboard-leaf: #285b48;
        --dashboard-coral: #d66b4f;
        --dashboard-gold: #d8a84e;
        color: var(--dashboard-ink);
    }

    .dashboard-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 26px;
    }

    .dashboard-kicker {
        margin: 0 0 5px;
        color: var(--dashboard-coral);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
    }

    .dashboard-heading h1 {
        margin: 0;
        color: var(--dashboard-ink);
        font-family: Georgia, "Leelawadee UI", serif;
        font-size: 30px;
        line-height: 1.3;
    }

    .dashboard-heading p {
        margin: 6px 0 0;
        color: #66716a;
        font-size: 14px;
    }

    .dashboard-primary-link {
        display: inline-flex;
        min-height: 42px;
        align-items: center;
        gap: 8px;
        padding: 9px 14px;
        color: #fff;
        background: var(--dashboard-leaf);
        border-radius: 3px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
    }

    .dashboard-primary-link:hover { color: #fff; background: #1e4938; }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        margin-bottom: 34px;
        background: #fff;
        border: 1px solid #e0e5e0;
        border-radius: 4px;
    }

    .dashboard-stat {
        min-height: 100px;
        padding: 20px 22px;
        border-right: 1px solid #e8ece8;
    }

    .dashboard-stat:last-child { border-right: 0; }
    .dashboard-stat strong { display: block; color: var(--dashboard-leaf); font-size: 27px; line-height: 1.2; }
    .dashboard-stat span { display: block; margin-top: 7px; color: #68736c; font-size: 13px; }

    .dashboard-section { margin-top: 32px; }

    .dashboard-section-heading {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dfe5df;
    }

    .dashboard-section-heading h2 {
        margin: 0;
        color: var(--dashboard-ink);
        font-family: Georgia, "Leelawadee UI", serif;
        font-size: 21px;
    }

    .dashboard-section-heading a { color: var(--dashboard-leaf); font-size: 13px; font-weight: 700; text-decoration: none; }

    .category-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; }

    .category-link {
        display: flex;
        min-height: 118px;
        flex-direction: column;
        justify-content: space-between;
        padding: 16px;
        color: var(--dashboard-ink);
        background: #fff;
        border: 1px solid #e0e5e0;
        border-radius: 4px;
        text-decoration: none;
        transition: border-color .18s ease, transform .18s ease;
    }

    .category-link:hover { color: var(--dashboard-ink); border-color: var(--dashboard-leaf); transform: translateY(-2px); }
    .category-link strong { font-size: 15px; line-height: 1.5; }
    .category-link span { color: #6d7971; font-size: 12px; line-height: 1.6; }
    .category-link small { color: var(--dashboard-coral); font-size: 12px; font-weight: 700; }

    .dashboard-feature {
        display: grid;
        grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr);
        overflow: hidden;
        background: #fff;
        border: 1px solid #e0e5e0;
        border-radius: 4px;
    }

    .dashboard-feature-visual { position: relative; min-height: 270px; background: #e7e1d4; }
    .dashboard-feature-visual img { display: block; width: 100%; height: 100%; min-height: 270px; object-fit: cover; }
    .dashboard-feature-credit { position: absolute; right: 0; bottom: 0; left: 0; padding: 7px 10px; color: #fff; background: rgba(23, 35, 29, .75); font-size: 10px; }
    .dashboard-feature-credit a { color: #fff; text-decoration: underline; }
    .dashboard-feature-copy { align-self: center; padding: 24px 28px; }
    .dashboard-feature-copy h3 { margin: 0 0 9px; color: var(--dashboard-ink); font-family: Georgia, "Leelawadee UI", serif; font-size: 24px; }
    .dashboard-feature-copy p { color: #657169; font-size: 14px; line-height: 1.75; }
    .dashboard-feature-copy h4 { margin: 17px 0 8px; font-size: 13px; }
    .dashboard-feature-copy ul { padding-left: 18px; margin: 0 0 18px; color: #566259; font-size: 13px; line-height: 1.8; }
    .dashboard-feature-copy .dashboard-primary-link { min-height: 38px; }

    @media (max-width: 991px) {
        .dashboard-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dashboard-stat:nth-child(2) { border-right: 0; }
        .dashboard-stat:nth-child(-n + 2) { border-bottom: 1px solid #e8ece8; }
        .category-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 575px) {
        .dashboard-heading { align-items: flex-start; flex-direction: column; }
        .dashboard-heading h1 { font-size: 25px; }
        .dashboard-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .dashboard-stat { min-height: 86px; padding: 15px; }
        .dashboard-stat strong { font-size: 23px; }
        .category-grid { grid-template-columns: 1fr; }
        .dashboard-feature { grid-template-columns: 1fr; }
        .dashboard-feature-visual, .dashboard-feature-visual img { min-height: 210px; }
        .dashboard-feature-copy { padding: 20px; }
    }
</style>

<main class="app-main course-dashboard">
    <div class="app-content-header">
        <div class="container-fluid dashboard-heading">
            <div>
                <p class="dashboard-kicker">ครัวขนมไทย · ห้องเรียนออนไลน์</p>
                <h1>สวัสดี {{ auth()->user()->name }}</h1>
                <p>เลือกหมวดที่สนใจ หรือเริ่มทำเมนูแนะนำประจำครัววันนี้</p>
            </div>
            <a class="dashboard-primary-link" href="{{ route('recipes') }}"><i class="bi bi-journal-richtext" aria-hidden="true"></i> เปิดคลังสูตร</a>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            {{-- ส่วนนี้แสดงจำนวนสูตร หมวด และช่วงเวลาทำอาหาร ซึ่ง route คำนวณจากข้อมูลใน config แล้วส่งมาให้ --}}
            <section class="dashboard-stats" aria-label="ภาพรวมคลังสูตร">
                <div class="dashboard-stat"><strong>{{ $recipeCount }}</strong><span>สูตรขนมไทย</span></div>
                <div class="dashboard-stat"><strong>{{ count($categories) }}</strong><span>หมวดการเรียน</span></div>
                <div class="dashboard-stat"><strong>{{ $quickRecipeCount }}</strong><span>เมนูทำเสร็จใน 40 นาทีหรือน้อยกว่า</span></div>
                <div class="dashboard-stat"><strong>{{ $minimumMinutes }}–{{ $maximumMinutes }}</strong><span>ช่วงเวลาโดยประมาณ (นาที)</span></div>
            </section>

            <section class="dashboard-section" aria-labelledby="course-categories-title">
                <div class="dashboard-section-heading">
                    <h2 id="course-categories-title">เลือกเรียนตามหมวด</h2>
                    <a href="{{ route('recipes') }}">ดูทั้ง 50 สูตร <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>
                {{-- เมื่อเลือกหมวด ลิงก์จะเปิดคลังสูตรพร้อมส่ง id ของหมวดไปเป็น query string --}}
                <div class="category-grid">
                    @foreach ($categories as $category)
                        <a class="category-link" href="{{ route('recipes', ['category' => $category['id']]) }}">
                            <strong>{{ $category['name'] }}</strong>
                            <span>{{ $category['description'] }}</span>
                            <small>{{ count($category['recipes']) }} สูตร · เปิดหมวดเรียน</small>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="dashboard-section" aria-labelledby="featured-recipe-title">
                <div class="dashboard-section-heading">
                    <h2 id="featured-recipe-title">เมนูแนะนำจากครัว</h2>
                    <a href="{{ route('recipes') }}">ค้นหาเมนูอื่น</a>
                </div>
                {{-- ส่วนนี้แสดงสูตรแนะนำจาก route พร้อมส่วนผสมบางส่วนและลิงก์ไปดูวิธีทำเต็ม --}}
                <article class="dashboard-feature">
                    <div class="dashboard-feature-visual">
                        <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/6/63/Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg/960px-Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg" alt="ขนมถ้วยมะพร้าวและขนมใบเตยแบบไทย">
                        <small class="dashboard-feature-credit">Peachyeung316 · <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener noreferrer">CC BY-SA 4.0</a> · <a href="https://commons.wikimedia.org/wiki/File:Thai_Coconut_Puddings_and_Green_Pandan_Puddings_at_Gold_Basil_Thai_Restaurant.jpg" target="_blank" rel="noopener noreferrer">ที่มาภาพ</a></small>
                    </div>
                    <div class="dashboard-feature-copy">
                        <p class="dashboard-kicker">เริ่มจากเมนูพื้นฐาน</p>
                        <h3>{{ $featuredRecipe['name'] }}</h3>
                        <p>{{ $featuredRecipe['summary'] }}</p>
                        <h4>วัตถุดิบหลัก</h4>
                        <ul>
                            @foreach (array_slice(explode('|', $featuredRecipe['ingredients']), 0, 4) as $ingredient)
                                <li>{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                        <a class="dashboard-primary-link" href="{{ route('recipes', ['search' => $featuredRecipe['name']]) }}">ดูวิธีทำ <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </article>
            </section>
        </div>
    </div>
</main>
@endsection
