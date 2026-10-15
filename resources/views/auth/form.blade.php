<!doctype html>
<html lang="th">
@include('auth.head', ['pageTitle' => ($mode === 'register' ? 'สมัครสมาชิก' : 'เข้าสู่ระบบ').' — PL HUB'])
<body>
    <header class="site-header">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <nav class="main-nav" aria-label="เมนูหลัก"><a href="{{ route('teams.index') }}">สโมสร</a><a href="{{ route('players.index') }}">นักเตะ</a></nav>
        <a class="button button-outline" href="{{ url('/') }}">กลับหน้าแรก</a>
    </header>
    <main class="recovery-page">
        <section class="modal-card auth-card recovery-card">
            <span class="eyebrow section-eyebrow">{{ $mode === 'register' ? 'JOIN PL HUB' : 'WELCOME BACK' }}</span>
            <h1>{{ $mode === 'register' ? 'สมัครสมาชิก' : 'เข้าสู่ระบบ' }}<span class="lime-dot">.</span></h1>
            <p class="modal-description">{{ $mode === 'register' ? 'สร้างบัญชีเพื่อเริ่มจัดการข้อมูลพรีเมียร์ลีก' : 'เข้าสู่ระบบเพื่อจัดการข้อมูลสโมสรและนักเตะ' }}</p>
            @if (request()->boolean('registered'))
                <p class="recovery-status" role="status">สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบด้วยบัญชีที่สร้างไว้</p>
            @endif
            @if ($mode === 'login' && session('status'))
                <p class="recovery-status" role="status">{{ session('status') }}</p>
            @endif
            <form id="authPageForm" data-mode="{{ $mode }}">
                @csrf
                @if ($mode === 'register')
                    <label class="form-field"><span>ชื่อที่แสดง</span><input name="name" autocomplete="name" required maxlength="255" placeholder="ชื่อของคุณ"></label>
                @endif
                <label class="form-field"><span>อีเมล</span><input name="email" type="email" autocomplete="email" required placeholder="you@example.com"></label>
                <label class="form-field"><span>รหัสผ่าน</span><input name="password" type="password" autocomplete="{{ $mode === 'register' ? 'new-password' : 'current-password' }}" required minlength="8" placeholder="อย่างน้อย 8 ตัวอักษร"></label>
                <p class="form-error" id="authPageError" role="alert" hidden></p>
                <button class="button button-dark submit-button" id="authPageSubmit" type="submit">{{ $mode === 'register' ? 'สร้างบัญชี' : 'เข้าสู่ระบบ' }} <span aria-hidden="true">↗</span></button>
            </form>
            @if ($mode === 'login')
                <a class="forgot-link" href="{{ route('password.request') }}">ลืมรหัสผ่าน?</a>
                <p class="auth-switch">ยังไม่มีบัญชี? <a href="{{ route('register') }}">สมัครสมาชิก</a></p>
            @else
                <p class="auth-switch">มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบ</a></p>
            @endif
        </section>
    </main>
    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
    <script src="{{ asset('js/auth-page.js') }}" defer></script>
</body>
</html>
