const STORAGE_KEY = 'admin-color-mode';

function getStoredTheme() {
    return localStorage.getItem(STORAGE_KEY) || 'system';
}

function resolveIsDark(mode) {
    if (mode === 'dark') {
        return true;
    }
    if (mode === 'light') {
        return false;
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches;
}

function applyTheme(mode) {
    const isDark = resolveIsDark(mode);
    document.documentElement.classList.toggle('dark', isDark);
    localStorage.setItem(STORAGE_KEY, mode);
    updateThemeUI(mode);
}

function updateThemeUI(mode) {
    const toggle = document.getElementById('admin-theme-toggle');
    const menu = document.getElementById('admin-theme-menu');
    if (!toggle) {
        return;
    }

    const icons = {
        light: document.getElementById('admin-theme-icon-light'),
        dark: document.getElementById('admin-theme-icon-dark'),
        system: document.getElementById('admin-theme-icon-system'),
    };

    Object.entries(icons).forEach(([name, el]) => {
        if (el) {
            el.classList.toggle('hidden', name !== mode);
        }
    });

    if (menu) {
        menu.querySelectorAll('[data-theme]').forEach((btn) => {
            const active = btn.getAttribute('data-theme') === mode;
            btn.classList.toggle('bg-indigo-50', active);
            btn.classList.toggle('text-indigo-700', active);
            btn.classList.toggle('dark:bg-indigo-500/15', active);
            btn.classList.toggle('dark:text-indigo-300', active);
        });
    }

    const labels = { light: 'Light mode', dark: 'Dark mode', system: 'System theme' };
    toggle.setAttribute('title', labels[mode] || 'Theme');
    toggle.setAttribute('aria-label', labels[mode] || 'Theme');
}

function bindThemeControls() {
    const toggle = document.getElementById('admin-theme-toggle');
    const menu = document.getElementById('admin-theme-menu');
    if (!toggle || !menu) {
        return;
    }

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.toggle('hidden');
    });

    menu.addEventListener('click', (e) => {
        e.stopPropagation();
    });

    menu.querySelectorAll('[data-theme]').forEach((btn) => {
        btn.addEventListener('click', () => {
            applyTheme(btn.getAttribute('data-theme'));
            menu.classList.add('hidden');
        });
    });

    document.addEventListener('click', () => {
        menu.classList.add('hidden');
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (getStoredTheme() === 'system') {
            applyTheme('system');
        }
    });
}

function adminCkeditorConfig(extra = {}) {
    const config = {
        width: '100%',
        removeButtons: 'PasteFromWord',
        versionCheck: false,
        ...extra,
    };

    if (document.documentElement.classList.contains('dark')) {
        config.uiColor = '#0f172a';
        config.contentsCss = 'body.cke_editable { background-color: #020617 !important; color: #f1f5f9 !important; }';
    }

    return config;
}

window.adminCkeditorConfig = adminCkeditorConfig;

document.addEventListener('DOMContentLoaded', () => {
    const mode = getStoredTheme();
    applyTheme(mode);
    bindThemeControls();
});
