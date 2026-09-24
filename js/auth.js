document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    async function handleSubmit(form, action, errorElementId) {
        const errorElement = document.getElementById(errorElementId);
        errorElement.textContent = '';
        const formData = new FormData(form);
        const payload = {};

        for (const [key, value] of formData.entries()) {
            payload[key] = value;
        }

        const response = await fetch('/api/auth.php?action=' + action, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });

        const data = await response.json();
        if (!response.ok) {
            errorElement.textContent = data.error || 'Unable to process request.';
            return;
        }

        if (action === 'login') {
            window.location.href = '/dashboard.php';
        } else {
            window.location.href = '/login.php';
        }
    }

    if (loginForm) {
        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();
            handleSubmit(loginForm, 'login', 'login-error');
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', (event) => {
            event.preventDefault();
            handleSubmit(registerForm, 'register', 'register-error');
        });
    }
});
