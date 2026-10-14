(() => {
    const state = {
        token: localStorage.getItem('plhub_token'),
        user: JSON.parse(localStorage.getItem('plhub_user') || 'null'),
        adminTab: 'players',
        teams: [],
        players: [],
        toastTimer: null,
    };

    const byId = (id) => document.getElementById(id);
    const adminModal = byId('adminModal');

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[character]));
    }

    function showToast(message, isError = false) {
        const toast = byId('toast');
        toast.textContent = message;
        toast.classList.toggle('error', isError);
        toast.hidden = false;
        window.clearTimeout(state.toastTimer);
        state.toastTimer = window.setTimeout(() => { toast.hidden = true; }, 3600);
    }

    function showModal(modal) {
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        const focusable = modal.querySelector('input:not([type="hidden"]), button');
        if (focusable) focusable.focus();
    }

    function closeModal(modal) {
        modal.hidden = true;
        if (adminModal.hidden) document.body.style.overflow = '';
    }

    function updateSessionUi() {
        const loggedIn = Boolean(state.token && state.user);
        byId('loginButton').hidden = loggedIn;
        byId('registerButton').hidden = loggedIn;
        byId('manageButton').hidden = !loggedIn;
        byId('logoutButton').hidden = !loggedIn;
        byId('userName').hidden = !loggedIn;
        byId('userName').textContent = loggedIn ? `สวัสดี, ${state.user.name}` : '';
    }

    function clearSession() {
        state.user = null;
        state.token = null;
        localStorage.removeItem('plhub_user');
        localStorage.removeItem('plhub_token');
        updateSessionUi();
    }

    async function api(path, method = 'GET', values = {}) {
        const headers = { Accept: 'application/json' };
        if (state.token) headers.Authorization = `Bearer ${state.token}`;
        Object.entries(values).forEach(([key, value]) => {
            if (value !== null && value !== undefined) headers[key] = String(value);
        });

        const response = await fetch(`/api/${path}`, { method, headers });
        let result;
        try {
            result = await response.json();
        } catch (error) {
            throw new Error('ระบบตอบกลับไม่ถูกต้อง กรุณาลองอีกครั้ง');
        }
        if (!response.ok) {
            const validation = result.errors
                ? Object.values(result.errors).flat().join(' ')
                : '';
            if (response.status === 401) clearSession();
            throw new Error(validation || result.message || 'ทำรายการไม่สำเร็จ');
        }
        return result;
    }

    async function logout() {
        try {
            await api('logout', 'POST');
            clearSession();
            closeModal(adminModal);
            showToast('ออกจากระบบเรียบร้อย');
        } catch (error) {
            showToast(error.message, true);
        }
    }

    async function openAdmin(tab = 'players') {
        if (!state.token) {
            window.location.assign('/login');
            return;
        }
        state.adminTab = tab;
        document.querySelectorAll('[data-admin-tab]').forEach((button) => {
            button.classList.toggle('active', button.dataset.adminTab === tab);
        });
        byId('recordForm').hidden = true;
        byId('adminMessage').hidden = true;
        byId('addRecordButton').textContent = `+ เพิ่ม${tab === 'teams' ? 'สโมสร' : 'นักเตะ'}`;
        showModal(adminModal);
        byId('adminList').innerHTML = '<div class="admin-empty">กำลังโหลดข้อมูล...</div>';
        try {
            const [teamsResult, playersResult] = await Promise.all([api('teams'), api('players')]);
            state.teams = teamsResult.data || [];
            state.players = playersResult.data || [];
            renderAdminList();
        } catch (error) {
            byId('adminList').innerHTML = `<div class="admin-empty">${escapeHtml(error.message)}</div>`;
            if (!state.token) closeModal(adminModal);
            showToast(error.message, true);
        }
    }

    function renderAdminList() {
        const records = state.adminTab === 'teams' ? state.teams : state.players;
        byId('adminCount').textContent = `${records.length} ${state.adminTab === 'teams' ? 'สโมสร' : 'นักเตะ'}`;
        byId('adminList').innerHTML = records.length ? records.map((record) => {
            const title = state.adminTab === 'teams' ? record.name : record.name;
            const detail = state.adminTab === 'teams'
                ? `${record.short_name} · ${record.stadium} · ${record.city}`
                : `${record.team?.name || 'ไม่ระบุสโมสร'} · ${record.position} · #${record.shirt_number ?? '—'} · ${record.goals ?? 0}G ${record.assists ?? 0}A`;
            return `<div class="admin-row">
                <div class="admin-row-info"><strong>${escapeHtml(title)}</strong><small>${escapeHtml(detail)}</small></div>
                <div class="admin-row-actions">
                    <button class="row-action" type="button" data-edit-id="${record.id}">แก้ไข</button>
                    <button class="row-action delete" type="button" data-delete-id="${record.id}">ลบ</button>
                </div>
            </div>`;
        }).join('') : '<div class="admin-empty">ยังไม่มีข้อมูล กด “เพิ่มข้อมูล” เพื่อเริ่มต้น</div>';
    }

    function formField(name, label, value = '', options = {}) {
        const required = options.required ? 'required' : '';
        const inputType = options.type || 'text';
        if (options.options) {
            const optionMarkup = options.options.map((option) => {
                const selected = String(option.value) === String(value) ? ' selected' : '';
                return `<option value="${escapeHtml(option.value)}"${selected}>${escapeHtml(option.label)}</option>`;
            }).join('');
            return `<label class="form-field"><span>${escapeHtml(label)}</span><select name="${escapeHtml(name)}" ${required}>${optionMarkup}</select></label>`;
        }
        return `<label class="form-field"><span>${escapeHtml(label)}</span><input name="${escapeHtml(name)}" type="${inputType}" value="${escapeHtml(value)}" ${required} ${options.min !== undefined ? `min="${options.min}"` : ''} ${options.max !== undefined ? `max="${options.max}"` : ''} ${options.placeholder ? `placeholder="${escapeHtml(options.placeholder)}"` : ''}></label>`;
    }

    function showRecordForm(record = null) {
        const isTeam = state.adminTab === 'teams';
        const form = byId('recordForm');
        form.reset();
        form.elements.id.value = record?.id || '';
        byId('recordFormTitle').textContent = `${record ? 'แก้ไข' : 'เพิ่ม'}${isTeam ? 'สโมสร' : 'นักเตะ'}`;
        byId('recordError').hidden = true;

        if (isTeam) {
            byId('recordFields').innerHTML = [
                formField('name', 'ชื่อสโมสร', record?.name || '', { required: true }),
                formField('short_name', 'ชื่อย่อ', record?.short_name || '', { required: true }),
                formField('stadium', 'สนามเหย้า', record?.stadium || '', { required: true }),
                formField('city', 'เมือง', record?.city || '', { required: true }),
            ].join('');
        } else {
            const teamOptions = [{ value: '', label: 'เลือกสโมสร' }, ...state.teams.map((team) => ({ value: team.id, label: team.name }))];
            byId('recordFields').innerHTML = [
                formField('name', 'ชื่อนักเตะ', record?.name || '', { required: true }),
                formField('team_id', 'สโมสร', record?.team_id || '', { required: true, options: teamOptions }),
                formField('position', 'ตำแหน่ง', record?.position || '', { required: true, options: [
                    { value: '', label: 'เลือกตำแหน่ง' },
                    { value: 'Goalkeeper', label: 'Goalkeeper' },
                    { value: 'Defender', label: 'Defender' },
                    { value: 'Midfielder', label: 'Midfielder' },
                    { value: 'Forward', label: 'Forward' },
                ] }),
                formField('nationality', 'สัญชาติ', record?.nationality || '', { required: true }),
                formField('shirt_number', 'หมายเลขเสื้อ', record?.shirt_number || '', { type: 'number', min: 1, max: 99 }),
                formField('age', 'อายุ', record?.age || '', { type: 'number', min: 1, max: 100 }),
                formField('goals', 'ประตู', record?.goals || 0, { type: 'number', min: 0 }),
                formField('assists', 'แอสซิสต์', record?.assists || 0, { type: 'number', min: 0 }),
            ].join('');
        }
        form.hidden = false;
        form.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        const firstInput = form.querySelector('input:not([type="hidden"])');
        if (firstInput) firstInput.focus();
    }

    async function saveRecord(event) {
        event.preventDefault();
        const form = event.currentTarget;
        const values = Object.fromEntries(new FormData(form));
        const id = values.id;
        delete values.id;
        Object.keys(values).forEach((key) => {
            if (values[key] === '') delete values[key];
        });

        const isTeam = state.adminTab === 'teams';
        const resource = isTeam ? 'teams' : 'players';
        const error = byId('recordError');
        const button = byId('recordSubmit');
        error.hidden = true;
        button.disabled = true;
        try {
            await api(`${resource}${id ? `/${id}` : ''}`, id ? 'PUT' : 'POST', values);
            form.hidden = true;
            byId('adminMessage').textContent = `${id ? 'แก้ไข' : 'เพิ่ม'}${isTeam ? 'สโมสร' : 'นักเตะ'}เรียบร้อย`;
            byId('adminMessage').hidden = false;
            const [teamsResult, playersResult] = await Promise.all([api('teams'), api('players')]);
            state.teams = teamsResult.data || [];
            state.players = playersResult.data || [];
            renderAdminList();
            showToast('บันทึกข้อมูลเรียบร้อย');
        } catch (requestError) {
            error.textContent = requestError.message;
            error.hidden = false;
        } finally {
            button.disabled = false;
        }
    }

    async function deleteRecord(id) {
        const isTeam = state.adminTab === 'teams';
        const record = (isTeam ? state.teams : state.players).find((item) => String(item.id) === String(id));
        const attachedPlayers = isTeam ? (record?.players?.length || 0) : 0;
        const warning = attachedPlayers
            ? `\n\nการลบสโมสรนี้จะลบนักเตะในทีม ${attachedPlayers} คนด้วย`
            : '';
        if (!record || !window.confirm(`ยืนยันการลบ${isTeam ? 'สโมสร' : 'นักเตะ'} ${record.name}?${warning}`)) return;
        try {
            await api(`${isTeam ? 'teams' : 'players'}/${id}`, 'DELETE');
            showToast('ลบข้อมูลเรียบร้อย');
            await openAdmin(state.adminTab);
        } catch (error) {
            showToast(error.message, true);
        }
    }

    byId('manageButton').addEventListener('click', () => openAdmin());
    [byId('heroManageButton'), byId('featureManageButton')].filter(Boolean).forEach((button) => {
        button.addEventListener('click', () => openAdmin());
    });
    byId('logoutButton').addEventListener('click', logout);
    byId('recordForm').addEventListener('submit', saveRecord);
    byId('addRecordButton').addEventListener('click', () => showRecordForm());
    byId('cancelRecordButton').addEventListener('click', () => { byId('recordForm').hidden = true; });

    document.querySelectorAll('[data-admin-tab]').forEach((button) => {
        button.addEventListener('click', () => openAdmin(button.dataset.adminTab));
    });
    document.querySelectorAll('[data-close]').forEach((button) => {
        button.addEventListener('click', () => closeModal(byId(button.dataset.close)));
    });
    adminModal.addEventListener('click', (event) => {
        if (event.target === adminModal) closeModal(adminModal);
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal(adminModal);
        }
    });
    byId('adminList').addEventListener('click', (event) => {
        const editButton = event.target.closest('[data-edit-id]');
        const deleteButton = event.target.closest('[data-delete-id]');
        if (editButton) {
            const records = state.adminTab === 'teams' ? state.teams : state.players;
            showRecordForm(records.find((record) => String(record.id) === editButton.dataset.editId));
        }
        if (deleteButton) deleteRecord(deleteButton.dataset.deleteId);
    });
    const playerSearch = byId('playerSearch');
    if (playerSearch) {
        playerSearch.addEventListener('input', (event) => {
            const query = event.target.value.trim().toLocaleLowerCase();
            let visibleCount = 0;
            document.querySelectorAll('.player-row').forEach((row) => {
                const visible = row.dataset.search.includes(query);
                row.hidden = !visible;
                if (visible) visibleCount += 1;
            });
            byId('noResults').hidden = !query || visibleCount > 0;
        });
    }

    updateSessionUi();
})();
