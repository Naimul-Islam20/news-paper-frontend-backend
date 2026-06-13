@if(google_adsense_client())
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ google_adsense_client() }}" crossorigin="anonymous"></script>
<style>
    ins.adsbygoogle:not([data-ad-slot]) { display:none!important;height:0!important;overflow:hidden!important; }
</style>
<script>
    (function () {
        function initAds() {
            document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])').forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
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
        setTimeout(run, 2000);
        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(blockAuto).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
