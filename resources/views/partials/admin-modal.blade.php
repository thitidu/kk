<div class="modal-backdrop" id="adminModal" hidden>
    <section class="modal-card admin-card" role="dialog" aria-modal="true" aria-labelledby="adminTitle">
        <button class="modal-close" type="button" data-close="adminModal" aria-label="ปิด">×</button>
        <span class="eyebrow section-eyebrow">PL HUB CONTROL ROOM</span>
        <h2 id="adminTitle">จัดการข้อมูล<span class="lime-dot">.</span></h2>
        <p class="modal-description">เพิ่ม แก้ไข หรือลบข้อมูลสโมสรและนักเตะ</p>
        <div class="admin-tabs"><button class="admin-tab active" type="button" data-admin-tab="players">นักเตะ</button><button class="admin-tab" type="button" data-admin-tab="teams">สโมสร</button></div>
        <div class="admin-toolbar"><span id="adminCount">ข้อมูล</span><button class="button button-lime button-small" type="button" id="addRecordButton">+ เพิ่มข้อมูล</button></div>
        <div class="admin-list" id="adminList" aria-live="polite"></div>
        <form class="record-form" id="recordForm" hidden>
            <div class="record-form-heading"><strong id="recordFormTitle">เพิ่มข้อมูล</strong><button type="button" id="cancelRecordButton" class="text-button">ยกเลิก</button></div>
            <input type="hidden" name="id">
            <div class="record-fields" id="recordFields"></div>
            <p class="form-error" id="recordError" role="alert" hidden></p>
            <button class="button button-dark submit-button" type="submit" id="recordSubmit">บันทึกข้อมูล <span aria-hidden="true">↗</span></button>
        </form>
        <p class="admin-message" id="adminMessage" role="status" hidden></p>
    </section>
</div>
<div class="toast" id="toast" role="status" aria-live="polite" @if (!session('status')) hidden @endif>{{ session('status') }}</div>
