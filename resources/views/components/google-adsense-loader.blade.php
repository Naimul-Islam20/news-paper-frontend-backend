@if(google_adsense_frontend_enabled())
<script>
(function () {
    function fillAdSlots() {
        document.querySelectorAll('ins.adsbygoogle[data-ad-slot]:not([data-ad-init])').forEach(function (el) {
            el.setAttribute('data-ad-init', '1');
            try {
                (window.adsbygoogle = window.adsbygoogle || []).push({});
            } catch (e) {}
        });
    }

    function loadAdScript() {
        var existing = document.querySelector('script[data-adsense-loader]');
        if (existing) {
            if (window.adsbygoogle && window.adsbygoogle.loaded) {
                fillAdSlots();
            } else {
                existing.addEventListener('load', fillAdSlots, { once: true });
            }
            return;
        }

        var script = document.createElement('script');
        script.async = true;
        script.crossOrigin = 'anonymous';
        script.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
        script.setAttribute('data-adsense-loader', '1');
        script.addEventListener('load', fillAdSlots, { once: true });
        document.head.appendChild(script);
    }

    function scheduleAds() {
        window.setTimeout(loadAdScript, 400);
    }

    if (document.readyState === 'complete') {
        scheduleAds();
    } else {
        window.addEventListener('load', scheduleAds, { once: true });
    }
})();
</script>
@endif
