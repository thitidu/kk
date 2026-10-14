<!doctype html>
<html lang="th">
@include('auth.head', ['pageTitle' => 'ตั้งรหัสผ่านใหม่ — PL HUB'])
<body>
    <header class="site-header">
        <a class="brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a>
        <a class="button button-outline" href="{{ url('/') }}">กลับหน้าแรก</a>
    </header>
    <main class="recovery-page">
        <section class="modal-card auth-card recovery-card">
            <span class="eyebrow section-eyebrow">SECURE YOUR ACCOUNT</span>
            <h1>ตั้งรหัสผ่านใหม่<span class="lime-dot">.</span></h1>
            <p class="modal-description">ตั้งรหัสผ่านใหม่อย่างน้อย 8 ตัวอักษรเพื่อกลับเข้าใช้งาน PL HUB</p>
            @if ($errors->any())
                <p class="form-error" role="alert">{{ $errors->first() }}</p>
            @endif
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <label class="form-field"><span>อีเมล</span><input name="email" type="email" value="{{ old('email', $email) }}" autocomplete="email" required autofocus></label>
                <label class="form-field"><span>รหัสผ่านใหม่</span><input name="password" type="password" autocomplete="new-password" required minlength="8" placeholder="อย่างน้อย 8 ตัวอักษร"></label>
                <label class="form-field"><span>ยืนยันรหัสผ่านใหม่</span><input name="password_confirmation" type="password" autocomplete="new-password" required minlength="8"></label>
                <button class="button button-dark submit-button" type="submit">บันทึกรหัสผ่านใหม่ <span aria-hidden="true">↗</span></button>
            </form>
        </section>
    </main>
    <footer class="site-footer"><a class="brand footer-brand" href="{{ url('/') }}"><span class="brand-mark">PL</span><span class="brand-name">PL <b>HUB</b><small>PREMIER LEAGUE DATABASE</small></span></a><span>FOOTBALL IS MORE THAN A GAME.</span><span>© {{ date('Y') }} PL HUB</span></footer>
</body>
</html>
