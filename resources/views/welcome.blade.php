<!doctype html>
<html lang="th">
@include('auth.head', ['pageTitle' => 'ข่าวสารพรีเมียร์ลีก — PL HUB'])
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('news') }}" aria-label="PL HUB หน้าแรก">
            <img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="eager">
            <span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE NEWS & STORIES</small></span>
        </a>
        <nav class="main-nav" aria-label="เมนูหลัก">
            <a class="active" href="{{ route('news') }}">ข่าวสาร</a>
            <a href="{{ route('teams.index') }}">สโมสร</a>
            <a href="{{ route('players.index') }}">นักเตะ</a>
            <a href="{{ route('standings.index') }}">ตารางคะแนน</a>
        </nav>
        @include('partials.header-actions')
    </header>

    <main>
        <section class="news-hero">
            <div class="news-hero-copy">
                <span class="news-kicker"><span class="live-dot"></span> PL HUB NEWSROOM <span class="kicker-divider">/</span> ข่าวสารพรีเมียร์ลีก</span>
                <h1>ทุกเรื่องราว<br>ของพรีเมียร์ลีก<span></span></h1>
                <p>ติดตามเรื่องราวของสโมสรและนักเตะ พร้อมสำรวจข้อมูลพรีเมียร์ลีกที่คุณสนใจได้ในที่เดียว</p>
                <div class="news-hero-actions">
                    <a class="button button-lime" href="#top-stories">อ่านเรื่องเด่น <span aria-hidden="true">↓</span></a>
                    <a class="news-secondary-link" href="{{ route('teams.index') }}">สำรวจสโมสร <span aria-hidden="true">↗</span></a>
                </div>
                <div class="news-hero-foot"><span>CLUBS</span><i></i><span>PLAYERS</span><i></i><span>THE PREMIER LEAGUE</span></div>
            </div>
            <div class="news-cover">
                <div class="cover-topline"><span>THE PL HUB EDITION</span><span>01 — NEWSROOM</span></div>
                <div class="cover-pitch" aria-hidden="true"><span class="cover-center-line"></span><span class="cover-center-circle"></span><span class="cover-box cover-box-left"></span><span class="cover-box cover-box-right"></span><span class="cover-dot cover-dot-one"></span><span class="cover-dot cover-dot-two"></span><span class="cover-dot cover-dot-three"></span></div>
                <div class="cover-story">
                    <span class="cover-category">FEATURED STORY <span>✳</span></span>
                    @if ($featuredPlayer)
                        <h2>{{ $featuredPlayer->name }}</h2>
                        <p>{{ $featuredPlayer->team->name }} <span>·</span> {{ $featuredPlayer->position }}</p>
                    @else
                        <h2>THE<br>PREMIER<br>LEAGUE</h2>
                        <p>สโมสร · นักเตะ · เรื่องราว</p>
                    @endif
                </div>
                <div class="cover-stamp">PL<br><small>HUB</small></div>
                <div class="cover-bottomline"><span>FOOTBALL, IN FOCUS.</span><span>EST. 1992</span></div>
            </div>
        </section>

        <section class="news-ticker" aria-label="หัวข้อข่าว">
            <span class="ticker-label"><span class="live-dot"></span> IN FOCUS</span>
            <span>สโมสรพรีเมียร์ลีก</span><i>✳</i><span>นักเตะที่น่าจับตา</span><i>✳</i><span>เรื่องราวจากสนาม</span><i>✳</i><span>ข้อมูลพรีเมียร์ลีก</span>
        </section>

        <section class="news-section" id="top-stories">
            <div class="news-section-heading">
                <div><span class="eyebrow section-eyebrow">CLUBS, PLAYERS & THE GAME</span><h2>เรื่องเด่น<span class="lime-dot">.</span></h2></div>
                <a class="news-all-link" href="{{ route('players.index') }}">สำรวจข้อมูลทั้งหมด <span aria-hidden="true">↗</span></a>
            </div>
            <div class="story-grid">
                @if ($featuredPlayer)
                    <article class="story-card story-card-player">
                        <a class="story-card-link" href="{{ route('players.index', ['team_id' => $featuredPlayer->team_id]) }}">
                            <div class="story-visual player-visual">
                                <img class="story-visual-image" src="https://images.unsplash.com/photo-1517466787929-bc90951d0974?auto=format&fit=crop&w=900&q=80" alt="นักเตะฟุตบอล{{ $featuredPlayer->name }}">
                                <span class="story-visual-label">PLAYER SPOTLIGHT <b>01</b></span>
                                <span class="story-player-number">{{ str_pad($featuredPlayer->shirt_number ?? 0, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="story-orbit"></span>
                                <span class="story-visual-bottom">{{ strtoupper($featuredPlayer->team->short_name) }} <i>✳</i> {{ strtoupper($featuredPlayer->position) }}</span>
                            </div>
                            <div class="story-content"><span class="story-category">PLAYER SPOTLIGHT <span>·</span> {{ $featuredPlayer->nationality }}</span><h3>{{ $featuredPlayer->name }}<br><span>ชื่อที่แฟนบอลควรรู้จัก</span></h3><p>ทำความรู้จักนักเตะ {{ $featuredPlayer->team->name }} พร้อมดูตำแหน่งและข้อมูลในฐานข้อมูล</p><span class="story-read">ดูข้อมูลนักเตะ <b>↗</b></span></div>
                        </a>
                    </article>
                @endif
                @if ($featuredTeam)
                    <article class="story-card story-card-club">
                        <a class="story-card-link" href="{{ route('players.index', ['team_id' => $featuredTeam->id]) }}">
                            <div class="story-visual club-visual">
                                <img class="story-visual-image" src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=900&q=80" alt="สนามฟุตบอล{{ $featuredTeam->name }}">
                                <span class="story-visual-label">CLUB NOTEBOOK <b>02</b></span>
                                <span class="story-club-mark">{{ strtoupper($featuredTeam->short_name) }}</span>
                                <span class="club-visual-caption">{{ $featuredTeam->city }} <i>·</i> {{ $featuredTeam->stadium }}</span>
                            </div>
                            <div class="story-content"><span class="story-category">CLUB NOTEBOOK <span>·</span> {{ $featuredTeam->city }}</span><h3>รู้จัก {{ $featuredTeam->name }}<br><span>จากสนามเหย้าสู่ทีม</span></h3><p>สำรวจข้อมูลสโมสร สนามเหย้า และรายชื่อนักเตะของทีม</p><span class="story-read">เปิดแฟ้มสโมสร <b>↗</b></span></div>
                        </a>
                    </article>
                @endif
                <article class="story-card story-card-league">
                    <a class="story-card-link" href="{{ route('standings.index') }}">
                        <div class="story-visual league-visual">
                            <img class="story-visual-image" src="https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=900&q=80" alt="สนามฟุตบอลพรีเมียร์ลีก">
                            <span class="story-visual-label">THE LEAGUE TABLE <b>03</b></span>
                            <div class="league-graphic"><span>20</span><i>CLUBS<br>ONE LEAGUE</i></div>
                            <span class="league-visual-caption">A CLOSER LOOK AT ENGLISH FOOTBALL</span>
                        </div>
                        <div class="story-content"><span class="story-category">THE LEAGUE GUIDE <span>·</span> STATS</span><h3>พรีเมียร์ลีก<br><span>มีเรื่องให้ติดตามเสมอ</span></h3><p>เช็กอันดับ ตารางคะแนน ดาวซัลโว และผู้นำแอสซิสต์</p><span class="story-read">ดูตารางคะแนน <b>↗</b></span></div>
                    </a>
                </article>
            </div>
        </section>

        <section class="news-digest">
            <div class="digest-mark">PL<span>.</span></div>
            <div class="digest-copy"><span class="eyebrow">YOUR PREMIER LEAGUE GUIDE</span><h2>ใกล้ชิดเกม<br>มากกว่าเดิม</h2><p>ข่าวสาร เรื่องราว และข้อมูลสโมสรกับนักเตะ รวมไว้ให้คุณติดตามได้ง่าย ๆ</p></div>
            <div class="digest-links"><a href="{{ route('standings.index') }}"><span>01</span> ดูตารางคะแนน <b>↗</b></a><a href="{{ route('teams.index') }}"><span>02</span> สำรวจสโมสร <b>↗</b></a><a href="{{ route('players.index') }}"><span>03</span> ค้นหานักเตะ <b>↗</b></a></div>
        </section>
    </main>

    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="lazy"><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE NEWS & STORIES</small></span></a><span>FOOTBALL, IN FOCUS.</span><span>© {{ date('Y') }} PL HUB</span></footer>

    @include('partials.admin-modal')
    <script src="{{ asset('js/premier-league.js') }}" defer></script>
</body>
</html>
