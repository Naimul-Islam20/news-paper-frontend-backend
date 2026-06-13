@if(google_adsense_client())
{{-- শুধু Auto/Anchor ad (data-ad-slot ছাড়া) — slot ad touch করবে না --}}
<style id="adsense-overlay-block">
    ins.adsbygoogle:not([data-ad-slot]) {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        max-height: 0 !important;
        overflow: hidden !important;
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

        function initSlotAds() {
            document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])').forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
        }

        function boot() {
            blockOverlaysOnly();
            initSlotAds();
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', boot);
        } else {
            boot();
        }
        window.addEventListener('load', boot);
        setTimeout(boot, 1000);

        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(blockOverlaysOnly).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
