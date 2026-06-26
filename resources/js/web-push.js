const STORAGE_SUBSCRIBED = 'webpush_subscribed';
const STORAGE_DISMISSED = 'webpush_prompt_dismissed';
const STORAGE_VISITS = 'webpush_visit_count';
const STORAGE_PENDING = 'webpush_subscribe_pending';
const PROMPT_DELAY_MS = 4000;

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
            sessionStorage.removeItem(STORAGE_PENDING);
        } catch {
            /* ignore */
        }
    }
}

function markSubscribed() {
    try {
        localStorage.setItem(STORAGE_SUBSCRIBED, '1');
        localStorage.removeItem(STORAGE_DISMISSED);
        sessionStorage.removeItem(STORAGE_PENDING);
    } catch {
        /* ignore */
    }
}

function setYesLoading(yesBtn, loading) {
    if (!yesBtn) {
        return;
    }

    if (loading) {
        yesBtn.disabled = true;
        yesBtn.dataset.pushLoading = '1';
        yesBtn.textContent = 'অপেক্ষা...';
    } else {
        yesBtn.disabled = false;
        yesBtn.dataset.pushLoading = '0';
        yesBtn.textContent = 'হ্যাঁ';
    }
}

async function registerAndSubscribe(publicKey, subscribeUrl, swUrl) {
    const registration = await navigator.serviceWorker.register(swUrl, {
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

    markSubscribed();
}

async function syncExistingSubscription(publicKey, subscribeUrl, swUrl) {
    if (!supportsPush() || Notification.permission !== 'granted') {
        return false;
    }

    try {
        const registration = await navigator.serviceWorker.getRegistration('/');
        const subscription = registration
            ? await registration.pushManager.getSubscription()
            : null;

        if (!subscription) {
            return false;
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

        markSubscribed();

        return true;
    } catch {
        return false;
    }
}

async function completePendingSubscribe(config, subscribeUrl, swUrl, root) {
    if (sessionStorage.getItem(STORAGE_PENDING) !== '1') {
        return false;
    }

    if (Notification.permission !== 'granted') {
        return false;
    }

    try {
        await registerAndSubscribe(config.publicKey, subscribeUrl, swUrl);
        hidePrompt(root, false);

        return true;
    } catch {
        return false;
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
    if (!root) {
        return;
    }

    const configUrl = root.dataset.pushConfigUrl;
    const subscribeUrl = root.dataset.pushSubscribeUrl;
    const swUrl = root.dataset.swUrl || '/sw.js';
    const yesBtn = root.querySelector('[data-push-yes]');
    const noBtn = root.querySelector('[data-push-no]');

    if (!configUrl || !subscribeUrl || !yesBtn || !noBtn) {
        return;
    }

    let config = null;
    let subscribeInFlight = false;

    const runSubscribe = async () => {
        if (subscribeInFlight || !config?.publicKey) {
            return;
        }

        subscribeInFlight = true;
        setYesLoading(yesBtn, true);
        noBtn.disabled = true;

        try {
            sessionStorage.setItem(STORAGE_PENDING, '1');
        } catch {
            /* ignore */
        }

        try {
            await registerAndSubscribe(config.publicKey, subscribeUrl, swUrl);
            hidePrompt(root, false);
        } catch (error) {
            console.error('Push subscribe failed:', error);

            if (Notification.permission === 'denied') {
                hidePrompt(root, true);
            } else if (Notification.permission === 'granted') {
                try {
                    await registerAndSubscribe(config.publicKey, subscribeUrl, swUrl);
                    hidePrompt(root, false);
                } catch (retryError) {
                    console.error('Push subscribe retry failed:', retryError);
                    setYesLoading(yesBtn, false);
                    noBtn.disabled = false;
                }
            } else {
                setYesLoading(yesBtn, false);
                noBtn.disabled = false;
            }
        } finally {
            subscribeInFlight = false;
        }
    };

    const bootstrap = async () => {
        try {
            config = await fetch(configUrl, {
                credentials: 'same-origin',
                headers: { Accept: 'application/json' },
            }).then((r) => r.json());

            if (!config.enabled || !config.publicKey) {
                return;
            }

            const alreadyDone = await syncExistingSubscription(
                config.publicKey,
                subscribeUrl,
                swUrl,
            );
            if (alreadyDone) {
                hidePrompt(root, false);

                return;
            }

            if (await completePendingSubscribe(config, subscribeUrl, swUrl, root)) {
                return;
            }

            if (!shouldOfferPrompt()) {
                return;
            }

            showPrompt(root);

            yesBtn.addEventListener(
                'click',
                () => {
                    void runSubscribe();
                },
                { passive: true },
            );

            noBtn.addEventListener('click', () => {
                hidePrompt(root, true);
            });

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState !== 'visible' || !config) {
                    return;
                }

                void completePendingSubscribe(config, subscribeUrl, swUrl, root);
            });
        } catch (error) {
            console.error('Push config failed:', error);
        }
    };

    window.setTimeout(bootstrap, PROMPT_DELAY_MS);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initWebPushPrompt);
} else {
    initWebPushPrompt();
}
