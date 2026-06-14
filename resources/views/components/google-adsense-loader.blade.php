@if(google_adsense_client())
<script>
    (function () {
        function initAds() {
            if (typeof window.adsbygoogle === 'undefined') {
                return false;
            }
            var pending = document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])');
            pending.forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
            return pending.length > 0;
        }
        function blockAuto() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;';
            });
        }
        function run() {
            blockAuto();
            initAds();
        }
        function scheduleRetries() {
            var delays = [0, 500, 1500, 4000, 8000];
            delays.forEach(function (ms) {
                setTimeout(function () {
                    if (initAds()) {
                        blockAuto();
                    }
                }, ms);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', scheduleRetries);
        } else {
            scheduleRetries();
        }
        window.addEventListener('load', scheduleRetries);
        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(function () {
                blockAuto();
                initAds();
            }).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
