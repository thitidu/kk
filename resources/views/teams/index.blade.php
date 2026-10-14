<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="รายชื่อสโมสรพรีเมียร์ลีก สนามเหย้า และนักเตะ">
    <title>สโมสรพรีเมียร์ลีก — PL HUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premier-league.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ url('/') }}" aria-label="PL HUB หน้าแรก"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <nav class="main-nav" aria-label="เมนูหลัก"><a class="active" href="{{ route('teams.index') }}">สโมสร</a><a href="{{ route('players.index') }}">นักเตะ</a><a href="{{ route('standings.index') }}">ตารางคะแนน</a></nav>
        <div class="header-actions"><a class="button button-outline" href="{{ route('login') }}">เข้าสู่ระบบ</a><a class="button button-dark" href="{{ route('register') }}">สมัครสมาชิก</a></div>
    </header>
    <main class="catalog-page">
        <section class="catalog-intro">
            <div><span class="eyebrow section-eyebrow">PREMIER LEAGUE DIRECTORY / 01</span><h1>สโมสร<span class="lime-dot">.</span></h1><p>ข้อมูลสโมสร สนามเหย้า และนักเตะในแต่ละทีม</p><a class="button button-dark team-standings-cta" href="{{ route('standings.index') }}">ดูตารางคะแนน <span aria-hidden="true">↗</span></a></div>
            <div class="catalog-count"><strong>{{ str_pad($teams->count(), 2, '0', STR_PAD_LEFT) }}</strong><span>สโมสร<br>ในระบบ</span></div>
        </section>
        <section class="catalog-toolbar" aria-label="ตัวกรองสโมสร">
            <span>ALL CLUBS <b>·</b> {{ $teams->count() }} CLUBS</span>
            <label class="catalog-search"><span aria-hidden="true">⌕</span><input type="search" id="catalogSearch" placeholder="ค้นหาสโมสรหรือเมือง..." aria-label="ค้นหาสโมสร"></label>
        </section>
        <section class="club-grid catalog-club-grid" id="catalogItems">
            @forelse ($teams as $team)
                <article class="club-card catalog-club-card" data-search="{{ strtolower($team->name.' '.$team->short_name.' '.$team->city.' '.$team->stadium) }}">
                    <div class="club-card-top"><span class="club-label">CLUB / {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="club-arrow" aria-hidden="true">↗</span></div>
                    <div class="club-crest">{{ strtoupper(substr($team->short_name, 0, 3)) }}</div>
                    <h2>{{ $team->name }}</h2>
                    <p class="club-city">{{ $team->city }}</p>
                    <div class="club-divider"></div>
                    <div class="club-meta"><span>สนามเหย้า</span><strong>{{ $team->stadium }}</strong></div>
                    <div class="club-meta"><span>นักเตะ</span><strong>{{ $team->players_count }} คน</strong></div>
                    @if ($standings->has($team->id))
                        <div class="club-meta"><span>คะแนน / อันดับ</span><strong>{{ $standings[$team->id]->points }} แต้ม · #{{ $standings->search($standings[$team->id]) + 1 }}</strong></div>
                    @endif
                    <a class="club-card-link" href="{{ route('players.index', ['team_id' => $team->id]) }}" aria-label="ดูรายชื่อนักเตะ {{ $team->name }}">ดูนักเตะในทีม <span aria-hidden="true">↗</span></a>
                </article>
            @empty
                <div class="empty-state">ยังไม่มีข้อมูลสโมสรในระบบ</div>
            @endforelse
        </section>
        <p class="catalog-empty" id="catalogEmpty" hidden>ไม่พบสโมสรที่ตรงกับคำค้นหา</p>
    </main>
    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
    <script src="{{ asset('js/catalog.js') }}" defer></script>
</body>
</html>
