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

function isAdminMobileEditor() {
    const ua = navigator.userAgent || '';

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(ua)) {
        return true;
    }

    return window.matchMedia('(max-width: 768px)').matches && 'ontouchstart' in window;
}

function pasteFromClipboard(editor) {
    if (!editor) {
        return;
    }

    markEditorForPaste(editor);
    editor.focus();

    const insertText = (text) => {
        if (!text) {
            showPasteBox(editor);
            return;
        }

        editor.insertHtml(CKEDITOR.tools.htmlEncode(text).replace(/\r?\n/g, '<br>'));
        editor.focus();
    };

    const insertHtml = (html) => {
        if (!html || !html.trim()) {
            showPasteBox(editor);
            return;
        }

        editor.insertHtml(html);
        editor.focus();
    };

    if (navigator.clipboard && navigator.clipboard.read) {
        navigator.clipboard.read().then((items) => {
            const tasks = [];

            items.forEach((item) => {
                if (item.types.includes('text/html')) {
                    tasks.push(item.getType('text/html').then((blob) => blob.text()).then(insertHtml));
                } else if (item.types.includes('text/plain')) {
                    tasks.push(item.getType('text/plain').then((blob) => blob.text()).then(insertText));
                }
            });

            if (!tasks.length) {
                showPasteBox(editor);
                return;
            }

            Promise.all(tasks).catch(() => showPasteBox(editor));
        }).catch(() => {
            if (navigator.clipboard && navigator.clipboard.readText) {
                navigator.clipboard.readText().then(insertText).catch(() => showPasteBox(editor));
                return;
            }

            showPasteBox(editor);
        });
        return;
    }

    if (navigator.clipboard && navigator.clipboard.readText) {
        navigator.clipboard.readText().then(insertText).catch(() => showPasteBox(editor));
        return;
    }

    showPasteBox(editor);
}

function showPasteBox(editor) {
    const existing = document.getElementById('admin-paste-box');
    if (existing) {
        existing.remove();
    }

    const overlay = document.createElement('div');
    overlay.id = 'admin-paste-box';
    overlay.className = 'fixed inset-0 z-[99999] flex items-center justify-center bg-black/40 p-4';
    overlay.innerHTML = ''
        + '<div class="bg-white dark:bg-slate-900 rounded-lg shadow-xl w-full max-w-lg p-4 space-y-3">'
        + '<p class="text-sm text-slate-800 dark:text-slate-100">এখানে <strong>Ctrl+V</strong> বা <strong>⌘+V</strong> চেপে paste করুন, তারপর Insert চাপুন।</p>'
        + '<textarea class="admin-paste-box-input w-full h-40 px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100"></textarea>'
        + '<div class="flex justify-end gap-2">'
        + '<button type="button" class="admin-paste-box-cancel px-4 py-2 text-sm border border-slate-200 dark:border-slate-700 rounded-lg">Cancel</button>'
        + '<button type="button" class="admin-paste-box-insert px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg">Insert</button>'
        + '</div>'
        + '</div>';

    document.body.appendChild(overlay);

    const textarea = overlay.querySelector('.admin-paste-box-input');
    const close = () => overlay.remove();

    overlay.querySelector('.admin-paste-box-cancel').addEventListener('click', close);
    overlay.querySelector('.admin-paste-box-insert').addEventListener('click', () => {
        const text = textarea.value;
        if (text) {
            editor.insertHtml(CKEDITOR.tools.htmlEncode(text).replace(/\r?\n/g, '<br>'));
            editor.focus();
        }
        close();
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            close();
        }
    });

    setTimeout(() => textarea.focus(), 50);
}

function registerAdminPastePlugin() {
    if (typeof CKEDITOR === 'undefined' || CKEDITOR.plugins.registered.adminpaste) {
        return;
    }

    CKEDITOR.plugins.add('adminpaste', {
        init(editor) {
            editor.addCommand('adminPaste', {
                exec(ed) {
                    pasteFromClipboard(ed);
                },
            });

            editor.ui.addButton('AdminPaste', {
                label: 'Paste',
                command: 'adminPaste',
                toolbar: 'clipboard,0',
            });
        },
    });
}

function loadCkeditorDivareaPlugin() {
    if (typeof CKEDITOR === 'undefined') {
        return Promise.resolve(false);
    }

    if (CKEDITOR.plugins.registered.divarea) {
        return Promise.resolve(true);
    }

    CKEDITOR.plugins.addExternal(
        'divarea',
        'https://cdn.ckeditor.com/4.22.1/standard-all/plugins/divarea/',
        'plugin.js'
    );

    return new Promise((resolve) => {
        CKEDITOR.plugins.load('divarea', () => resolve(true), () => resolve(false));
    });
}

const ckeditorPasteState = {
    editor: null,
    until: 0,
    bound: false,
};

function insertClipboardIntoEditor(editor, clipboardData) {
    if (!editor || !clipboardData) {
        return false;
    }

    const html = clipboardData.getData('text/html');
    const text = clipboardData.getData('text/plain');

    if (html && html.trim()) {
        editor.insertHtml(html);
        return true;
    }

    if (text) {
        editor.insertHtml(CKEDITOR.tools.htmlEncode(text).replace(/\r?\n/g, '<br>'));
        return true;
    }

    return false;
}

function markEditorForPaste(editor, extraMs = 60000) {
    ckeditorPasteState.editor = editor;
    ckeditorPasteState.until = Date.now() + extraMs;
}

function registerGlobalPasteHandler() {
    if (ckeditorPasteState.bound) {
        return;
    }

    ckeditorPasteState.bound = true;

    document.addEventListener('paste', (e) => {
        const editor = ckeditorPasteState.editor;
        if (!editor || editor.status !== 'ready' || Date.now() > ckeditorPasteState.until) {
            return;
        }

        if (!e.clipboardData) {
            return;
        }

        e.preventDefault();
        e.stopImmediatePropagation();
        insertClipboardIntoEditor(editor, e.clipboardData);
        editor.focus();
    }, true);
}

function bindCkeditorDesktopPaste(editor) {
    if (editor._adminPasteBound) {
        return;
    }

    editor._adminPasteBound = true;
    registerGlobalPasteHandler();

    editor.on('focus', () => {
        markEditorForPaste(editor);
    });

    editor.on('blur', () => {
        ckeditorPasteState.until = Date.now() + 10000;
    });

    editor.on('contentDom', () => {
        const editable = editor.editable();
        if (!editable) {
            return;
        }

        const keepEditorReadyForPaste = () => {
            markEditorForPaste(editor, 15000);
            setTimeout(() => editor.focus(), 0);
        };

        editable.attachListener(editable, 'contextmenu', keepEditorReadyForPaste);
        editable.attachListener(editable, 'mousedown', (evt) => {
            if (evt.data.$.button === 2) {
                keepEditorReadyForPaste();
            }
        });
    });

    if (editor.container) {
        editor.container.on('contextmenu', () => {
            markEditorForPaste(editor, 15000);
        });
    }

    editor.on('notificationShow', (evt) => {
        const raw = evt.data.message;
        const message = String(raw && raw.value !== undefined ? raw.value : raw || '');
        if (/paste/i.test(message)) {
            evt.cancel();
        }
    });

    editor.on('beforeCommandExec', (evt) => {
        if (evt.data.name === 'paste') {
            evt.cancel();
            pasteFromClipboard(editor);
        }
    });
}

function adminCkeditorConfig(extra = {}) {
    const config = {
        width: '100%',
        removeButtons: 'Paste,PasteFromWord',
        removePlugins: 'contextmenu',
        extraPlugins: 'divarea,adminpaste',
        versionCheck: false,
        ...extra,
    };

    if (extra.extraPlugins) {
        config.extraPlugins = ['divarea', 'adminpaste', extra.extraPlugins].filter(Boolean).join(',');
    }

    if (extra.removePlugins) {
        config.removePlugins = ['contextmenu', extra.removePlugins].filter(Boolean).join(',');
    }

    if (document.documentElement.classList.contains('dark')) {
        config.uiColor = '#0f172a';
        config.contentsCss = 'body.cke_editable { background-color: #020617 !important; color: #f1f5f9 !important; }';
    }

    return config;
}

function patchCkeditorReplace() {
    if (typeof CKEDITOR === 'undefined' || CKEDITOR._adminReplacePatched) {
        return;
    }

    CKEDITOR._adminReplacePatched = true;

    const originalReplace = CKEDITOR.replace;
    CKEDITOR.replace = function (element, config) {
        const instance = originalReplace.call(this, element, adminCkeditorConfig(config || {}));
        if (instance && !isAdminMobileEditor()) {
            instance.on('instanceReady', () => {
                bindCkeditorDesktopPaste(instance);
            });
        }
        return instance;
    };
}

function adminEditorGetData(elementId = 'editor') {
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[elementId]) {
        return CKEDITOR.instances[elementId].getData();
    }

    const el = document.getElementById(elementId);
    return el ? el.value : '';
}

function adminEditorSetData(elementId, data) {
    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[elementId]) {
        CKEDITOR.instances[elementId].setData(data || '');
        return;
    }

    const el = document.getElementById(elementId);
    if (el) {
        el.value = data || '';
    }
}

function adminCkeditorReplace(elementId, extra = {}, onReady = null) {
    const el = document.getElementById(elementId);
    if (!el) {
        return Promise.resolve(null);
    }

    if (isAdminMobileEditor()) {
        el.classList.add(
            'w-full',
            'px-4',
            'py-3',
            'outline-none',
            'font-normal',
            'text-slate-900',
            'text-sm',
            'resize-y',
            'bg-white',
            'dark:bg-slate-900',
            'dark:text-slate-100'
        );
        el.style.minHeight = `${extra.height || 300}px`;

        const shim = {
            getData() {
                return el.value;
            },
            setData(value) {
                el.value = value || '';
            },
            on(event, callback) {
                if (event === 'change') {
                    el.addEventListener('input', callback);
                }
            },
            focus() {
                el.focus();
            },
        };

        if (typeof onReady === 'function') {
            onReady(shim);
        }

        return Promise.resolve(shim);
    }

    if (typeof CKEDITOR === 'undefined') {
        return Promise.resolve(null);
    }

    return loadCkeditorDivareaPlugin().then(() => {
        registerAdminPastePlugin();
        patchCkeditorReplace();
        const editor = CKEDITOR.replace(elementId, adminCkeditorConfig(extra));

        return new Promise((resolve) => {
            editor.on('instanceReady', () => {
                if (typeof onReady === 'function') {
                    onReady(editor);
                }
                resolve(editor);
            });
        });
    });
}

function adminLoadCkeditor(callback) {
    if (isAdminMobileEditor()) {
        callback();
        return;
    }

    const start = () => {
        registerAdminPastePlugin();
        loadCkeditorDivareaPlugin().then(() => {
            patchCkeditorReplace();
            callback();
        });
    };

    if (typeof CKEDITOR !== 'undefined') {
        start();
        return;
    }

    const script = document.createElement('script');
    script.src = 'https://cdn.ckeditor.com/4.22.1/full/ckeditor.js';
    script.onload = start;
    document.head.appendChild(script);
}

window.adminCkeditorConfig = adminCkeditorConfig;
window.adminCkeditorReplace = adminCkeditorReplace;
window.adminEditorGetData = adminEditorGetData;
window.adminEditorSetData = adminEditorSetData;
window.adminLoadCkeditor = adminLoadCkeditor;
window.isAdminMobileEditor = isAdminMobileEditor;

document.addEventListener('DOMContentLoaded', () => {
    const mode = getStoredTheme();
    applyTheme(mode);
    bindThemeControls();
});
