@extends('template.frontend.master')

@section('content')
<style>
    /* ส่วนนี้กำหนดสีหลักและรูปแบบพื้นฐาน เพื่อให้ทุกส่วนของหน้าสูตรใช้ธีมเดียวกัน */
    .thai-course {
        --course-ink: #26342f;
        --course-leaf: #285b48;
        --course-coral: #d66b4f;
        --course-gold: #d8a84e;
        --course-paper: #fbf8f1;
        color: var(--course-ink);
        background: var(--course-paper);
        padding-bottom: 72px;
    }

    .course-hero {
        position: relative;
        overflow: hidden;
        padding: 70px 0 58px;
        color: #fff;
        background-color: var(--course-leaf);
        background-image: radial-gradient(circle at 88% 20%, rgba(237, 193, 111, .25) 0 2px, transparent 3px), radial-gradient(circle at 92% 25%, rgba(237, 193, 111, .18) 0 1px, transparent 2px);
        background-size: 34px 34px, 21px 21px;
    }

    .course-hero h1 {
        max-width: 720px;
        margin: 0 0 14px;
        color: #fff;
        font-family: Georgia, 'Noto Serif Thai', serif;
        font-size: 42px;
        line-height: 1.25;
        font-weight: 700;
    }

    .course-hero p {
        max-width: 690px;
        margin: 0;
        color: rgba(255, 255, 255, .88);
        font-size: 17px;
        line-height: 1.8;
    }

    .course-kicker {
        display: inline-block;
        margin-bottom: 12px;
        color: #f2ce88;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* ส่วนนี้จัดแถบค้นหาและตัวกรองให้ติดด้านบน เพื่อให้เลือกหมวดได้แม้เลื่อนลงไปดูสูตรแล้ว */
    .course-tools {
        position: sticky;
        top: 0;
        z-index: 10;
        padding: 16px 0;
        background: rgba(251, 248, 241, .96);
        border-bottom: 1px solid #e5dfd2;
        backdrop-filter: blur(10px);
    }

    .course-search {
        min-width: 240px;
        height: 44px;
        border: 1px solid #d8d2c7;
        border-radius: 3px;
        box-shadow: none;
    }

    .course-filters {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding: 2px 0 5px;
        scrollbar-width: thin;
    }

    .course-filter {
        flex: 0 0 auto;
        padding: 9px 13px;
        color: var(--course-ink);
        background: transparent;
        border: 1px solid #d8d2c7;
        border-radius: 3px;
        font-size: 14px;
        cursor: pointer;
    }

    .course-filter:hover,
    .course-filter[aria-pressed="true"] {
        color: #fff;
        background: var(--course-leaf);
        border-color: var(--course-leaf);
    }

    .course-results {
        margin: 24px 0 14px;
        color: #59635d;
        font-size: 14px;
    }

    /* ส่วนนี้วางการ์ดเป็นตาราง และ CSS ด้านล่างจะลดจำนวนคอลัมน์เมื่อหน้าจอแคบลง */
    .recipe-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .recipe-card {
        min-width: 0;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e5dfd2;
        border-radius: 4px;
        box-shadow: 0 5px 18px rgba(38, 52, 47, .055);
    }

    .recipe-visual {
        position: relative;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #e8e2d5;
    }

    .recipe-photo {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity .25s ease;
    }

    .recipe-card.has-photo .recipe-photo {
        opacity: 1;
    }

    .recipe-placeholder {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 16px;
        color: #52635a;
        text-align: center;
        background: linear-gradient(135deg, #e9e3d6, #dce8df);
    }

    .recipe-placeholder i {
        color: var(--course-coral);
        font-size: 28px;
    }

    .recipe-card.has-photo .recipe-placeholder {
        display: none;
    }

    .image-credit {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        padding: 5px 9px;
        color: #fff;
        background: rgba(23, 31, 27, .74);
        font-size: 10px;
        line-height: 1.4;
    }

    .image-credit a {
        color: #fff;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .recipe-content {
        padding: 17px 18px 18px;
    }

    .recipe-category {
        margin-bottom: 7px;
        color: var(--course-coral);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .recipe-title {
        margin: 0 0 7px;
        color: var(--course-ink);
        font-family: Georgia, 'Noto Serif Thai', serif;
        font-size: 21px;
        line-height: 1.45;
    }

    .recipe-summary {
        min-height: 48px;
        margin-bottom: 12px;
        color: #5e6862;
        font-size: 14px;
        line-height: 1.7;
    }

    .recipe-time {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 14px;
        color: #59635d;
        font-size: 12px;
    }

    .recipe-details {
        border-top: 1px solid #ece7de;
    }

    .recipe-details summary {
        padding-top: 13px;
        color: var(--course-leaf);
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .recipe-details h4 {
        margin: 15px 0 7px;
        color: var(--course-ink);
        font-size: 14px;
        font-weight: 700;
    }

    .recipe-details ul,
    .recipe-details ol {
        padding-left: 20px;
        margin-bottom: 12px;
        color: #505b55;
        font-size: 13px;
        line-height: 1.75;
    }

    .recipe-card[hidden] {
        display: none !important;
    }

    .course-note {
        margin-top: 34px;
        padding: 16px 18px;
        color: #515d55;
        background: #f0eadc;
        border-left: 4px solid var(--course-gold);
        font-size: 13px;
        line-height: 1.7;
    }

    @media (max-width: 991px) {
        .recipe-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .course-hero h1 {
            font-size: 36px;
        }
    }

    @media (max-width: 575px) {
        .course-hero {
            padding: 48px 0 40px;
        }

        .course-hero h1 {
            font-size: 30px;
        }

        .course-hero p {
            font-size: 15px;
        }

        .recipe-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .course-search {
            min-width: 0;
            margin-bottom: 10px;
        }
    }
</style>

<main class="thai-course">
    {{-- ส่วนนี้แนะนำเว็บและบอกผู้ใช้ว่าคลังสูตรมีเนื้อหาเกี่ยวกับอะไร ก่อนเริ่มค้นหาสูตร --}}
    <section class="course-hero">
        <div class="container">
            <span class="course-kicker">ครัวขนมไทย · 5 หมวด · 50 เมนู</span>
            <h1>เรียนรู้ขนมไทย ทำเองได้ที่บ้าน</h1>
            <p>รวมสูตรขนมต้ม ขนมมงคล ของเชื่อม ขนมน้ำกะทิ และของว่างไทย พร้อมส่วนผสมและวิธีทำที่เรียบเรียงใหม่สำหรับทำตามทีละขั้น</p>
        </div>
    </section>

    {{-- ส่วนนี้รับคำค้นและหมวดที่ผู้ใช้เลือก แล้ว JavaScript จะนำค่าไปกรองการ์ดสูตรด้านล่าง --}}
    {{-- ช่องค้นหาดึงคำค้นจาก URL กลับมา และปุ่มด้านข้างใช้เลือกหมวดสูตร --}}
    <section class="course-tools" aria-label="ค้นหาและกรองสูตร">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <label class="sr-only" for="recipe-search">ค้นหาสูตรขนมไทย</label>
                    <input id="recipe-search" class="form-control course-search" type="search" value="{{ request()->query('search') }}" placeholder="ค้นหาชื่อขนมหรือวัตถุดิบ..." autocomplete="off">
                </div>
                <div class="col-lg-8">
                    <div class="course-filters" role="group" aria-label="เลือกหมวดขนม">
                        <button class="course-filter" type="button" data-category-filter="all" aria-pressed="{{ request()->query('category') ? 'false' : 'true' }}">ทั้งหมด</button>
                        @foreach ($categories as $category)
                            <button class="course-filter" type="button" data-category-filter="{{ $category['id'] }}" aria-pressed="{{ request()->query('category') === $category['id'] ? 'true' : 'false' }}">{{ $category['name'] }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container" aria-label="รายการสูตรขนมไทย">
        {{-- JavaScript อัปเดตจำนวนผลลัพธ์ในจุดนี้เมื่อค้นหาหรือเปลี่ยนหมวด --}}
        <p class="course-results" id="recipe-results" aria-live="polite"></p>
        {{-- วนข้อมูลทุกหมวดจาก config แล้วสร้างการ์ดของแต่ละสูตร จึงเพิ่มเมนูได้โดยไม่ต้องเขียน HTML ซ้ำ --}}
        <div class="recipe-grid">
            @foreach ($categories as $category)
                @foreach ($category['recipes'] as $recipe)
                    <article class="recipe-card" data-category="{{ $category['id'] }}" data-search="{{ $recipe['name'] }} {{ $recipe['summary'] }} {{ $recipe['ingredients'] }}" data-image-query="{{ $recipe['image_query'] }}" data-title="{{ $recipe['name'] }}">
                        <div class="recipe-visual">
                            <img class="recipe-photo" alt="ภาพประกอบ {{ $recipe['name'] }}">
                            <div class="recipe-placeholder" aria-live="polite">
                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                                <span>กำลังค้นหาภาพที่อนุญาตให้ใช้</span>
                            </div>
                            <small class="image-credit" hidden></small>
                        </div>
                        {{-- แสดงหมวด ชื่อ คำอธิบาย เวลา และรายละเอียดวัตถุดิบ/ขั้นตอนทำ --}}
                        <div class="recipe-content">
                            <div class="recipe-category">{{ $category['name'] }}</div>
                            <h2 class="recipe-title">{{ $recipe['name'] }}</h2>
                            <p class="recipe-summary">{{ $recipe['summary'] }}</p>
                            <span class="recipe-time"><i class="fa fa-clock-o" aria-hidden="true"></i> ประมาณ {{ $recipe['minutes'] }} นาที</span>
                            <details class="recipe-details">
                                <summary>ดูวัตถุดิบและวิธีทำ</summary>
                                <h4>วัตถุดิบ</h4>
                                <ul>
                                    @foreach (explode('|', $recipe['ingredients']) as $ingredient)
                                        <li>{{ $ingredient }}</li>
                                    @endforeach
                                </ul>
                                <h4>วิธีทำ</h4>
                                <ol>
                                    @foreach (explode('|', $recipe['steps']) as $step)
                                        <li>{{ $step }}</li>
                                    @endforeach
                                </ol>
                            </details>
                        </div>
                    </article>
                @endforeach
            @endforeach
        </div>
        {{-- หมายเหตุเรื่องการปรับสูตรและเครดิตภาพประกอบ --}}
        <p class="course-note">สูตรเป็นแนวทางสำหรับทำรับประทานในครัวเรือน ปรับความหวานและเวลาปรุงได้ตามวัตถุดิบและอุปกรณ์ ภาพประกอบค้นจาก Wikimedia Commons และแสดงเครดิต/สัญญาอนุญาตจากเจ้าของภาพแต่ละรายการ</p>
    </section>
</main>

<script>
    (() => {
        // ส่วนนี้เก็บช่องค้นหา ปุ่มหมวด และการ์ดไว้ เพื่อให้ฟังก์ชันด้านล่างเรียกใช้ร่วมกัน
        const cards = [...document.querySelectorAll('.recipe-card')];
        const filters = [...document.querySelectorAll('[data-category-filter]')];
        const search = document.querySelector('#recipe-search');
        const resultCount = document.querySelector('#recipe-results');
        const imageQueue = [];
        let activeImageRequests = 0;
        const maxImageRequests = 3;

        function updateRecipes() {
            // ส่วนนี้แสดงเฉพาะสูตรที่ตรงทั้งหมวดและคำค้น จากนั้นจึงเริ่มโหลดภาพของรายการที่เห็นได้
            const selectedCategory = document.querySelector('[data-category-filter][aria-pressed="true"]')?.dataset.categoryFilter || 'all';
            const searchTerm = search.value.trim().toLocaleLowerCase();
            let visibleCount = 0;

            for (const card of cards) {
                const matchesCategory = selectedCategory === 'all' || card.dataset.category === selectedCategory;
                const matchesSearch = card.dataset.search.toLocaleLowerCase().includes(searchTerm);
                card.hidden = !(matchesCategory && matchesSearch);
                if (!card.hidden) visibleCount += 1;
            }

            resultCount.textContent = `แสดง ${visibleCount} จาก ${cards.length} สูตร`;
            queueVisibleImages();
        }

        for (const filter of filters) {
            filter.addEventListener('click', () => {
                for (const button of filters) button.setAttribute('aria-pressed', String(button === filter));
                updateRecipes();
            });
        }

        search.addEventListener('input', updateRecipes);
        updateRecipes();

        function pumpImageQueue() {
            // ส่วนนี้จำกัดการโหลดภาพพร้อมกันไม่เกิน 3 รายการ เพื่อลดจำนวนคำขอไปยัง Wikimedia ในเวลาเดียวกัน
            while (activeImageRequests < maxImageRequests && imageQueue.length > 0) {
                const card = imageQueue.shift();
                activeImageRequests += 1;
                loadCommonsImage(card).finally(() => {
                    activeImageRequests -= 1;
                    pumpImageQueue();
                });
            }
        }

        async function loadCommonsImage(card) {
            const placeholder = card.querySelector('.recipe-placeholder span');
            const photo = card.querySelector('.recipe-photo');
            const credit = card.querySelector('.image-credit');
            try {
                // เริ่มค้นด้วยชื่อเมนู แล้วลองคำค้นที่กว้างขึ้นทีละระดับหากยังไม่พบภาพ
                const categoryQueries = {
                    steamed: 'Thai steamed dessert',
                    gold: 'Thai golden dessert',
                    syrup: 'Thai candied dessert',
                    coconut: 'Thai coconut dessert',
                    'baked-mixed': 'Thai traditional dessert',
                };
                const shortName = card.dataset.imageQuery.split(' ').slice(0, 2).join(' ');
                const queries = [...new Set([
                    card.dataset.imageQuery,
                    `${shortName} Thai dessert`,
                    categoryQueries[card.dataset.category],
                    'Thai dessert',
                ])];
                let image;

                for (const query of queries) {
                    const apiUrl = new URL('https://commons.wikimedia.org/w/api.php');
                    apiUrl.search = new URLSearchParams({
                        action: 'query',
                        generator: 'search',
                        gsrsearch: `filetype:bitmap ${query}`,
                        gsrnamespace: '6',
                        gsrwhat: 'text',
                        gsrlimit: '1',
                        prop: 'imageinfo',
                        iiprop: 'url|extmetadata',
                        iiurlwidth: '640',
                        format: 'json',
                        origin: '*',
                    });

                    try {
                        const response = await fetch(apiUrl);
                        if (!response.ok) continue;
                        const result = await response.json();
                        const file = Object.values(result.query?.pages || {})[0];
                        image = file?.imageinfo?.[0];
                        if (image?.thumburl) break;
                    } catch {
                        continue;
                    }
                }

                if (!image?.thumburl) throw new Error('No image found');

                // เมื่อได้ภาพแล้ว ส่วนนี้แสดงที่มา ผู้สร้าง และสัญญาอนุญาตตามข้อมูลของไฟล์ Commons
                photo.addEventListener('load', () => {
                    card.classList.add('has-photo');
                    placeholder.textContent = '';
                }, { once: true });
                photo.addEventListener('error', () => {
                    placeholder.textContent = 'โหลดภาพไม่สำเร็จ ลองเปิดแหล่งที่มาของภาพ';
                }, { once: true });
                photo.src = image.thumburl;
                const metadata = image.extmetadata || {};
                const artist = metadata.Artist?.value
                    ? new DOMParser().parseFromString(metadata.Artist.value, 'text/html').body.textContent.trim()
                    : 'ไม่ระบุชื่อผู้สร้าง';
                const imageDescription = metadata.ImageDescription?.value
                    ? new DOMParser().parseFromString(metadata.ImageDescription.value, 'text/html').body.textContent.trim()
                    : file.title.replace(/^File:/, '');
                const licenseName = metadata.LicenseShortName?.value || 'ตรวจสอบใบอนุญาต';
                const licenseUrl = metadata.LicenseUrl?.value || image.descriptionurl;
                photo.alt = imageDescription;

                const sourceLink = document.createElement('a');
                sourceLink.href = image.descriptionurl;
                sourceLink.target = '_blank';
                sourceLink.rel = 'noopener noreferrer';
                sourceLink.textContent = `ภาพ: ${imageDescription} · ${artist}`;

                const licenseLink = document.createElement('a');
                licenseLink.href = licenseUrl;
                licenseLink.target = '_blank';
                licenseLink.rel = 'noopener noreferrer';
                licenseLink.textContent = licenseName;

                credit.replaceChildren(sourceLink, document.createTextNode(' · '), licenseLink);
                credit.hidden = false;
            } catch {
                placeholder.textContent = 'ยังค้นหาภาพที่ตรงเมนูนี้ไม่พบ';
            }
        }

        function queueVisibleImages() {
            // เพิ่มเฉพาะการ์ดที่อยู่ใกล้หน้าจอลงคิว และทำเครื่องหมายไว้เพื่อไม่ให้โหลดภาพเดิมซ้ำ
            for (const card of cards) {
                if (card.hidden || card.dataset.imageState) continue;
                const bounds = card.getBoundingClientRect();
                if (bounds.bottom < -320 || bounds.top > window.innerHeight + 320) continue;
                card.dataset.imageState = 'queued';
                imageQueue.push(card);
            }
            pumpImageQueue();
        }

        window.addEventListener('scroll', queueVisibleImages, { passive: true });
        window.addEventListener('resize', queueVisibleImages);
    })();
</script>
@endsection
