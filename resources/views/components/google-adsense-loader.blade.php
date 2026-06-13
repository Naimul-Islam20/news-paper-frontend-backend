@if(google_adsense_client())
<script>
    (function () {
        function initAds() {
            document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])').forEach(function () {
                try { (adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
        }
        function blockAuto() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;';
            });
        }
        function run() { initAds(); blockAuto(); }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', run);
        } else {
            run();
        }
        window.addEventListener('load', run);
        setTimeout(run, 1500);
        setTimeout(run, 4000);
        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(blockAuto).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
