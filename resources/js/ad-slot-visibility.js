/**
 * হেডার অ্যাড স্টিকি সিঙ্ক — স্লট লোড হওয়ার আগে লুকানো হয় না।
 */
(function () {
    function notifyHeaderAd() {
        if (document.getElementById('header-ad-slot')) {
            window.dispatchEvent(new CustomEvent('header-ad-changed'));
        }
    }

    window.adSlotShow = notifyHeaderAd;
    window.adSlotHide = function () {};

    function run() {
        notifyHeaderAd();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', run);
    } else {
        run();
    }

    window.addEventListener('load', run);
})();
