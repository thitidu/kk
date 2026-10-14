<!doctype html>
<html lang="th">
@include('auth.head', ['pageTitle' => 'ลืมรหัสผ่าน — PL HUB'])
<body>
    <header class="site-header">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <a class="button button-outline" href="{{ url('/') }}">กลับหน้าแรก</a>
    </header>
    <main class="recovery-page">
        <section class="modal-card auth-card recovery-card">
            <span class="eyebrow section-eyebrow">ACCOUNT RECOVERY</span>
            <h1>ลืมรหัสผ่าน<span class="lime-dot">.</span></h1>
            <p class="modal-description">กรอกอีเมลที่ใช้สมัครสมาชิก เราจะส่งลิงก์สำหรับตั้งรหัสผ่านใหม่ให้คุณ</p>
            @if (session('status'))
                <p class="recovery-status" role="status">{{ session('status') }}</p>
            @endif
            @if ($errors->any())
                <p class="form-error" role="alert">{{ $errors->first() }}</p>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label class="form-field"><span>อีเมล</span><input name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="you@example.com"></label>
                <button class="button button-dark submit-button" type="submit">ส่งลิงก์ตั้งรหัสผ่าน <span aria-hidden="true">↗</span></button>
            </form>
            <a class="forgot-link" href="{{ url('/') }}">กลับไปหน้าเข้าสู่ระบบ</a>
        </section>
    </main>
    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
</body>
</html>
