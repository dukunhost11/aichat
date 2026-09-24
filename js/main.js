document.addEventListener('DOMContentLoaded', () => {
    const toggleDark = document.querySelector('[data-dark-toggle]');
    if (!toggleDark) return;

    const current = localStorage.getItem('theme') || 'light';
    document.documentElement.dataset.theme = current;

    toggleDark.addEventListener('click', () => {
        const next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.dataset.theme = next;
        localStorage.setItem('theme', next);
    });
});
