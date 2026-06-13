@if(google_adsense_client())
<style id="adsense-overlay-block">
    ins.adsbygoogle:not([data-ad-slot]) {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        pointer-events: none !important;
    }
</style>
<script>
    (function () {
        function blockOverlaysOnly() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.setProperty('display', 'none', 'important');
                el.style.setProperty('visibility', 'hidden', 'important');
                el.style.setProperty('height', '0', 'important');
                el.style.setProperty('pointer-events', 'none', 'important');
            });
        }

        function initRemainingSlots() {
            document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])').forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
        }

        function boot() {
            blockOverlaysOnly();
            initRemainingSlots();
        }

        var adsScript = document.getElementById('adsense-js');
        if (adsScript) {
            adsScript.addEventListener('load', boot);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot);
        } else {
            boot();
        }
        window.addEventListener('load', boot);

        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(blockOverlaysOnly).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
