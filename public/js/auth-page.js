(() => {
    const form = document.getElementById('authPageForm');
    const errorMessage = document.getElementById('authPageError');
    const submitButton = document.getElementById('authPageSubmit');

    function getErrorMessage(result) {
        if (result.errors) return Object.values(result.errors).flat().join(' ');
        return result.message || 'ทำรายการไม่สำเร็จ กรุณาลองอีกครั้ง';
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;
        errorMessage.hidden = true;

        const values = Object.fromEntries(new FormData(form));
        const mode = form.dataset.mode;
        const headers = {
            Accept: 'application/json',
            email: values.email,
            password: values.password,
        };
        if (mode === 'register') headers.name = values.name;

        try {
            const response = await fetch(`/api/${mode}`, { method: 'POST', headers });
            const result = await response.json();
            if (!response.ok) throw new Error(getErrorMessage(result));

            if (mode === 'register') {
                window.location.assign('/login?registered=1');
                return;
            }

            const user = result.user || result.data?.user;
            const token = result.token || result.data?.token;
            if (!user || !token) throw new Error('เข้าสู่ระบบไม่สำเร็จ กรุณาลองอีกครั้ง');

            localStorage.setItem('plhub_user', JSON.stringify(user));
            localStorage.setItem('plhub_token', token);
            window.location.assign('/');
        } catch (error) {
            errorMessage.textContent = error.message || 'ไม่สามารถเชื่อมต่อระบบได้ กรุณาลองอีกครั้ง';
            errorMessage.hidden = false;
        } finally {
            submitButton.disabled = false;
        }
    });
})();
