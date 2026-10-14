<!doctype html>
<html lang="th">
@include('auth.head', ['pageTitle' => 'ตารางคะแนนและสถิติ — PL HUB'])
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('news') }}" aria-label="PL HUB หน้าแรก"><img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="eager"><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <nav class="main-nav" aria-label="เมนูหลัก"><a href="{{ route('news') }}">ข่าวสาร</a><a class="active" href="{{ route('teams.index') }}">สโมสร</a><a href="{{ route('players.index') }}">นักเตะ</a><a href="{{ route('standings.index') }}">ตารางคะแนน</a></nav>
        <div class="header-actions"><a class="button button-outline" href="{{ route('login') }}">เข้าสู่ระบบ</a><a class="button button-dark" href="{{ route('register') }}">สมัครสมาชิก</a></div>
    </header>

    <main class="standings-page">
        <section class="catalog-intro standings-intro">
            <div><span class="eyebrow section-eyebrow">PREMIER LEAGUE / 2026—27</span><h1>ตารางคะแนน<span class="lime-dot">.</span></h1><p>อันดับ คะแนน ผลการแข่งขัน และสถิตินักเตะประจำฤดูกาล</p></div>
            <span class="sample-label"><span class="live-dot"></span> ตารางคะแนนตัวอย่าง · สถิตินักเตะจริง</span>
        </section>

        <section class="standings-table-section">
            <div class="standings-heading"><div><span class="eyebrow section-eyebrow">THE LEAGUE TABLE</span><h2>อันดับสโมสร</h2></div><span>เล่น {{ $standings->first()->played ?? 0 }} นัด <i>·</i> 20 สโมสร</span></div>
            <div class="standings-table-wrap">
                <table class="standings-table">
                    <thead><tr><th class="rank-col">#</th><th class="standing-team-col">สโมสร</th><th>แข่ง</th><th>ชนะ</th><th>เสมอ</th><th>แพ้</th><th>ได้</th><th>เสีย</th><th>ผลต่าง</th><th class="points-col">คะแนน</th></tr></thead>
                    <tbody>
                        @forelse ($standings as $standing)
                            <tr>
                                <td class="rank-col"><span class="standing-rank @if ($loop->iteration <= 4) rank-europe @elseif ($loop->iteration >= 18) rank-relegation @endif">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></td>
                                <td class="standing-team-col"><a class="standing-team" href="{{ route('players.index', ['team_id' => $standing->team_id]) }}"><span class="standing-crest">{{ $standing->team->short_name }}</span><strong>{{ $standing->team->name }}</strong></a></td>
                                <td>{{ $standing->played }}</td><td>{{ $standing->won }}</td><td>{{ $standing->drawn }}</td><td>{{ $standing->lost }}</td>
                                <td>{{ $standing->goals_for }}</td><td>{{ $standing->goals_against }}</td>
                                <td class="@if ($standing->goal_difference > 0) positive-stat @elseif ($standing->goal_difference < 0) negative-stat @endif">{{ $standing->goal_difference > 0 ? '+' : '' }}{{ $standing->goal_difference }}</td>
                                <td class="points-col"><strong>{{ $standing->points }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="empty-row">ยังไม่มีข้อมูลตารางคะแนน</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="table-legend"><span><i class="legend-europe"></i> โควตาฟุตบอลยุโรป</span><span><i class="legend-relegation"></i> โซนตกชั้น</span><span>แต้มคำนวณจาก ชนะ 3 คะแนน / เสมอ 1 คะแนน</span></div>
        </section>

        <section class="leaderboards">
            <p class="stats-as-of">สถิติประตูและแอสซิสต์สะสมถึงวันที่ 13 ตุลาคม 2026 · <a href="https://fantasy.premierleague.com/api/bootstrap-static/" target="_blank" rel="noopener noreferrer">แหล่งข้อมูล FPL</a></p>
            <div class="leaderboard-card">
                <div class="leaderboard-heading"><span class="eyebrow section-eyebrow">GOLDEN BOOT RACE</span><h2>ดาวซัลโว<span class="lime-dot">.</span></h2><span class="leaderboard-unit">GOALS</span></div>
                <div class="leaderboard-list">
                    @foreach ($topScorers as $player)
                        <a class="leader-row" href="{{ route('players.index', ['team_id' => $player->team_id]) }}"><span class="leader-rank">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="leader-player"><strong>{{ $player->name }}</strong><small>{{ $player->team->name }}</small></span><span class="leader-support">{{ $player->assists }} <small>AST</small></span><strong class="leader-total">{{ $player->goals }}</strong></a>
                    @endforeach
                </div>
            </div>
            <div class="leaderboard-card assists-card">
                <div class="leaderboard-heading"><span class="eyebrow section-eyebrow">PLAYMAKER CHART</span><h2>แอสซิสต์<span class="lime-dot">.</span></h2><span class="leaderboard-unit">ASSISTS</span></div>
                <div class="leaderboard-list">
                    @foreach ($topAssists as $player)
                        <a class="leader-row" href="{{ route('players.index', ['team_id' => $player->team_id]) }}"><span class="leader-rank">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="leader-player"><strong>{{ $player->name }}</strong><small>{{ $player->team->name }}</small></span><span class="leader-support">{{ $player->goals }} <small>GOL</small></span><strong class="leader-total">{{ $player->assists }}</strong></a>
                    @endforeach
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><img class="brand-mark brand-logo" src="https://images.unsplash.com/photo-1543351611-58f69d7c1781?auto=format&fit=crop&w=256&q=80" alt="PL HUB logo" loading="lazy"><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
</body>
</html>
