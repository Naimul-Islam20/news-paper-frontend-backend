/**
 * অ্যাড স্লট — লোড না হলে জায়গা ফাঁকা দেখাবে না; শুধু সফল অ্যাড দেখাবে।
 */
(function () {
    function root(el) {
        return el && el.closest ? el.closest('[data-ad-slot-root]') : null;
    }

    function isRenderableMedia(el) {
        if (!el || !(el instanceof Element)) {
            return false;
        }

        return window.getComputedStyle(el).display !== 'none';
    }

    function showSlot(el) {
        const r = root(el);
        if (r) {
            r.classList.remove('ad-slot-pending');
            r.style.visibility = '';
            r.style.opacity = '';
            if (r.id === 'header-ad-slot') {
                window.dispatchEvent(new CustomEvent('header-ad-changed'));
            }
        }
    }

    function hideSlot(el) {
        const r = root(el);
        if (r) {
            r.classList.add('ad-slot-pending');
            if (r.id === 'header-ad-slot') {
                window.dispatchEvent(new CustomEvent('header-ad-changed'));
            }
        }
    }

    window.adSlotShow = showSlot;
    window.adSlotHide = hideSlot;

    function googleAdFilled(ins) {
        if (!ins) {
            return false;
        }

        const status = ins.getAttribute('data-ad-status');
        if (status === 'filled') {
            return true;
        }
        if (status === 'unfilled') {
            return false;
        }

        const adsStatus = ins.getAttribute('data-adsbygoogle-status');
        if (adsStatus === 'done' && status === 'unfilled') {
            return false;
        }

        const iframe = ins.querySelector('iframe');
        if (iframe && iframe.offsetWidth > 0 && iframe.offsetHeight > 20) {
            return status !== 'unfilled';
        }

        return false;
    }

    function checkGoogleSlots() {
        document.querySelectorAll('[data-ad-slot-root] .google-ad-unit ins.adsbygoogle[data-ad-slot]').forEach(function (ins) {
            const r = root(ins);
            if (!r) {
                return;
            }

            if (googleAdFilled(ins)) {
                r.classList.remove('ad-slot-pending');
            } else if (ins.getAttribute('data-ad-status') === 'unfilled') {
                r.classList.add('ad-slot-pending');
            }
        });

        document.querySelectorAll('[data-ad-slot-root]').forEach(function (r) {
            if (r.querySelector('.google-ad-unit') && !r.querySelector('ins.adsbygoogle[data-ad-slot]')) {
                r.classList.add('ad-slot-pending');
            }
        });
    }

    function initLocalSlot(r) {
        if (r.querySelector('.google-ad-unit')) {
            return;
        }

        const mediaEls = Array.from(r.querySelectorAll('img, video, iframe')).filter(isRenderableMedia);
        if (!mediaEls.length) {
            r.classList.add('ad-slot-pending');
            return;
        }

        let shown = false;

        function tryShow(el) {
            if (shown) {
                return;
            }
            shown = true;
            r.classList.remove('ad-slot-pending');
        }

        let pendingCount = 0;

        mediaEls.forEach(function (media) {
            if (media.tagName === 'IMG') {
                if (media.complete && media.naturalHeight > 0) {
                    tryShow(media);
                } else {
                    pendingCount++;
                    media.addEventListener('load', function () {
                        tryShow(media);
                    });
                    media.addEventListener('error', function () {
                        pendingCount--;
                    });
                }
            } else if (media.tagName === 'VIDEO') {
                if (media.readyState >= 2) {
                    tryShow(media);
                } else {
                    pendingCount++;
                    media.addEventListener('loadeddata', function () {
                        tryShow(media);
                    });
                    media.addEventListener('error', function () {
                        pendingCount--;
                    });
                }
            } else if (media.tagName === 'IFRAME') {
                media.addEventListener('load', function () {
                    tryShow(media);
                });
                setTimeout(function () {
                    tryShow(media);
                }, 600);
            }
        });

        setTimeout(function () {
            if (!shown) {
                r.classList.add('ad-slot-pending');
            }
        }, 8000);
    }

    function initLocalSlots() {
        document.querySelectorAll('[data-ad-slot-root]').forEach(initLocalSlot);
    }

    function scheduleGoogleChecks() {
        [0, 400, 1000, 2500, 5000, 8000, 12000].forEach(function (ms) {
            setTimeout(checkGoogleSlots, ms);
        });
    }

    function run() {
        initLocalSlots();
        checkGoogleSlots();
        scheduleGoogleChecks();
        if (document.getElementById('header-ad-slot')) {
            window.dispatchEvent(new CustomEvent('header-ad-changed'));
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }

    window.addEventListener('load', function () {
        initLocalSlots();
        checkGoogleSlots();
        scheduleGoogleChecks();
    });

    if (typeof MutationObserver !== 'undefined') {
        new MutationObserver(function () {
            checkGoogleSlots();
        }).observe(document.documentElement, {
            attributes: true,
            subtree: true,
            attributeFilter: ['data-ad-status', 'data-adsbygoogle-status'],
        });
    }
})();
