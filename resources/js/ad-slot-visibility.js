/**
 * অ্যাড স্লট — লোড ব্যর্থ হলে শুধু সেই স্লট লুকায়; লোড হওয়ার আগে লুকানো হয় না।
 */
(function () {
    function root(el) {
        return el && el.closest ? el.closest('[data-ad-slot-root]') : null;
    }

    function notifyHeaderAd(r) {
        if (r && r.id === 'header-ad-slot') {
            window.dispatchEvent(new CustomEvent('header-ad-changed'));
        }
    }

    function showSlot(el) {
        const r = root(el);
        if (!r) {
            return;
        }
        r.classList.remove('ad-slot-failed');
        notifyHeaderAd(r);
    }

    function hideSlot(el) {
        const r = root(el);
        if (!r) {
            return;
        }
        r.classList.add('ad-slot-failed');
        notifyHeaderAd(r);
    }

    window.adSlotShow = showSlot;
    window.adSlotHide = hideSlot;

    function run() {
        if (document.getElementById('header-ad-slot')) {
            window.dispatchEvent(new CustomEvent('header-ad-changed'));
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }

    window.addEventListener('load', run);
})();
