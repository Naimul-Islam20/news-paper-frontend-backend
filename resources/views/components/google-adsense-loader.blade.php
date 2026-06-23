@if(google_adsense_frontend_enabled())
@php $adsenseClient = google_adsense_client(); @endphp
@if($adsenseClient)
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ urlencode($adsenseClient) }}" crossorigin="anonymous"></script>
<script>
    (function () {
        function blockAutoAds() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;max-height:0!important;overflow:hidden!important;';
            });
        }

        function initManualUnits() {
            blockAutoAds();
            document.querySelectorAll('ins.adsbygoogle[data-ad-slot]').forEach(function () {
                try {
                    (window.adsbygoogle = window.adsbygoogle || []).push({});
                } catch (e) {}
            });
        }

        initManualUnits();
        window.addEventListener('load', initManualUnits, { once: true });
    })();
</script>
@endif
@endif
