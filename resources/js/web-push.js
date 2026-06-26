const STORAGE_SUBSCRIBED = 'webpush_subscribed';
const STORAGE_DISMISSED = 'webpush_prompt_dismissed';
const STORAGE_VISITS = 'webpush_visit_count';
const PROMPT_DELAY_MS = 6000;

function csrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    if (meta?.content) {
        return meta.content;
    }

    const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);

    return match ? decodeURIComponent(match[1]) : '';
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const raw = window.atob(base64);

    return Uint8Array.from([...raw].map((char) => char.charCodeAt(0)));
}

async function fetchJson(url, options = {}) {
    const response = await fetch(url, {
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            'X-Requested-With': 'XMLHttpRequest',
            ...(options.headers || {}),
        },
        ...options,
    });

    if (!response.ok) {
        throw new Error(`Request failed: ${response.status}`);
    }

    return response.json();
}

function supportsPush() {
    return (
        'serviceWorker' in navigator &&
        'PushManager' in window &&
        'Notification' in window
    );
}

function showPrompt(root) {
    root.classList.remove('hidden');
    root.setAttribute('aria-hidden', 'false');
}

function hidePrompt(root, rememberDismiss = false) {
    root.classList.add('hidden');
    root.setAttribute('aria-hidden', 'true');

    if (rememberDismiss) {
        try {
            localStorage.setItem(STORAGE_DISMISSED, '1');
        } catch {
            /* ignore */
        }
    }
}

async function registerAndSubscribe(publicKey, subscribeUrl) {
    const registration = await navigator.serviceWorker.register('/sw.js', {
        scope: '/',
    });

    await navigator.serviceWorker.ready;

    let subscription = await registration.pushManager.getSubscription();

    if (!subscription) {
        subscription = await registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(publicKey),
        });
    }

    const json = subscription.toJSON();

    await fetchJson(subscribeUrl, {
        method: 'POST',
        body: JSON.stringify({
            endpoint: json.endpoint,
            keys: json.keys,
            contentEncoding: 'aesgcm',
        }),
    });

    try {
        localStorage.setItem(STORAGE_SUBSCRIBED, '1');
        localStorage.removeItem(STORAGE_DISMISSED);
    } catch {
        /* ignore */
    }
}

function shouldOfferPrompt() {
    if (!supportsPush()) {
        return false;
    }

    if (Notification.permission === 'denied') {
        return false;
    }

    try {
        if (localStorage.getItem(STORAGE_SUBSCRIBED) === '1') {
            return false;
        }

        if (localStorage.getItem(STORAGE_DISMISSED) === '1') {
            return false;
        }
    } catch {
        return false;
    }

    let visits = 0;

    try {
        visits = parseInt(sessionStorage.getItem(STORAGE_VISITS) || '0', 10) + 1;
        sessionStorage.setItem(STORAGE_VISITS, String(visits));
    } catch {
        visits = 1;
    }

    return visits >= 1;
}

function initWebPushPrompt() {
    const root = document.getElementById('push-prompt-root');
    if (!root || !shouldOfferPrompt()) {
        return;
    }

    const configUrl = root.dataset.pushConfigUrl;
    const subscribeUrl = root.dataset.pushSubscribeUrl;
    const yesBtn = root.querySelector('[data-push-yes]');
    const noBtn = root.querySelector('[data-push-no]');

    if (!configUrl || !subscribeUrl || !yesBtn || !noBtn) {
        return;
    }

    window.setTimeout(async () => {
        try {
            const config = await fetch(configUrl, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json' },
            }).then((r) => r.json());

            if (!config.enabled || !config.publicKey) {
                return;
            }

            showPrompt(root);

            yesBtn.addEventListener('click', async () => {
                yesBtn.disabled = true;
                noBtn.disabled = true;

                try {
                    const permission = await Notification.requestPermission();
                    if (permission !== 'granted') {
                        hidePrompt(root, true);
                        return;
                    }

                    await registerAndSubscribe(config.publicKey, subscribeUrl);
                    hidePrompt(root, false);
                } catch (error) {
                    console.error('Push subscribe failed:', error);
                    hidePrompt(root, true);
                } finally {
                    yesBtn.disabled = false;
                    noBtn.disabled = false;
                }
            });

            noBtn.addEventListener('click', () => {
                hidePrompt(root, true);
            });
        } catch (error) {
            console.error('Push config failed:', error);
        }
    }, PROMPT_DELAY_MS);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWebPushPrompt);
} else {
    initWebPushPrompt();
}
