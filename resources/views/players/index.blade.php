<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="รายชื่อนักเตะพรีเมียร์ลีก ค้นหาตามชื่อ สโมสร และตำแหน่ง">
    <title>นักเตะพรีเมียร์ลีก — PL HUB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/premier-league.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('news') }}" aria-label="PL HUB หน้าแรก"><img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="eager"><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <nav class="main-nav" aria-label="เมนูหลัก"><a href="{{ route('news') }}">ข่าวสาร</a><a href="{{ route('teams.index') }}">สโมสร</a><a class="active" href="{{ route('players.index') }}">นักเตะ</a><a href="{{ route('standings.index') }}">ตารางคะแนน</a></nav>
        <div class="header-actions"><a class="button button-outline" href="{{ route('login') }}">เข้าสู่ระบบ</a><a class="button button-dark" href="{{ route('register') }}">สมัครสมาชิก</a></div>
    </header>
    <main class="player-catalog-page">
        <section class="catalog-intro player-catalog-intro">
            <div><span class="eyebrow section-eyebrow">PREMIER LEAGUE DIRECTORY / 02</span><h1>นักเตะ<span class="lime-dot">.</span></h1><p>ค้นหารายชื่อนักเตะตามชื่อ สโมสร ตำแหน่ง หรือสัญชาติ</p><span class="player-data-note">คัด 11 ผู้เล่นที่ลงสนามมากสุดต่อทีม · สถิติสะสมถึง 13 ต.ค. 2026 · <a href="https://fantasy.premierleague.com/api/bootstrap-static/" target="_blank" rel="noopener noreferrer">แหล่งข้อมูล FPL</a></span></div>
            <div class="catalog-count"><strong>{{ str_pad($players->count(), 2, '0', STR_PAD_LEFT) }}</strong><span>นักเตะ<br>ในรายการ</span></div>
        </section>
        <section class="player-directory">
            <div class="catalog-toolbar player-toolbar">
                <span>PLAYER DATABASE <b>·</b> {{ $players->count() }} PLAYERS</span>
                <div class="player-filters">
                    <label class="catalog-search"><span aria-hidden="true">⌕</span><input type="search" id="catalogSearch" placeholder="ค้นหานักเตะ..." aria-label="ค้นหานักเตะ"></label>
                    <select id="teamFilter" aria-label="กรองตามสโมสร">
                        <option value="">ทุกสโมสร</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" @selected((string) $selectedTeamId === (string) $team->id)>{{ $team->name }}</option>
                        @endforeach
                    </select>
                    <select id="positionFilter" aria-label="กรองตามตำแหน่ง">
                        <option value="">ทุกตำแหน่ง</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position }}">{{ $position }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="roster-wrap catalog-roster-wrap">
                <table class="roster-table catalog-roster">
                    <thead><tr><th>นักเตะ</th><th>สโมสร</th><th>ตำแหน่ง</th><th>สัญชาติ</th><th>เสื้อ</th><th>อายุ</th><th>ประตู</th><th>แอสซิสต์</th></tr></thead>
                    <tbody id="catalogItems">
                        @forelse ($players as $player)
                            <tr class="catalog-player-row" data-search="{{ strtolower($player->name.' '.$player->team->name.' '.$player->position.' '.$player->nationality) }}" data-team="{{ $player->team_id }}" data-position="{{ $player->position }}">
                                <td><span class="player-number">{{ str_pad($player->shirt_number ?? 0, 2, '0', STR_PAD_LEFT) }}</span><strong>{{ $player->name }}</strong></td>
                                <td><a class="team-name-link" href="{{ route('players.index', ['team_id' => $player->team_id]) }}">{{ $player->team->name }}</a></td>
                                <td><span class="position-tag">{{ $player->position }}</span></td>
                                <td>{{ $player->nationality }}</td>
                                <td>{{ $player->shirt_number ?? '—' }}</td>
                                <td>{{ $player->age ?? '—' }}</td>
                                <td class="player-stat-cell">{{ $player->goals }}</td>
                                <td class="player-stat-cell">{{ $player->assists }}</td>
                            </tr>
                        @empty
                            <tr><td class="empty-row" colspan="8">ยังไม่มีข้อมูลนักเตะในระบบ</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <p class="catalog-empty player-catalog-empty" id="catalogEmpty" hidden>ไม่พบรายชื่อนักเตะที่ตรงกับตัวกรอง</p>
            </div>
        </section>
    </main>
    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="lazy"><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
    <script src="{{ asset('js/catalog.js') }}" defer></script>
</body>
</html>
