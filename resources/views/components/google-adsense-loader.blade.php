@if(google_adsense_frontend_enabled())
@php $adsenseClient = google_adsense_client(); @endphp
@if($adsenseClient)
<script>
    (function () {
        var client = @json($adsenseClient);

        function pendingUnits() {
            return document.querySelectorAll('ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])');
        }

        function blockAutoAds() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;max-height:0!important;overflow:hidden!important;';
            });
        }

        function initUnits() {
            if (typeof window.adsbygoogle === 'undefined') {
                return;
            }

            blockAutoAds();
            pendingUnits().forEach(function (ins) {
                try {
                    (window.adsbygoogle = window.adsbygoogle || []).push({});
                } catch (e) {}
            });
        }

        function loadScript(done) {
            if (typeof window.adsbygoogle !== 'undefined') {
                done();
                return;
            }

            if (document.querySelector('script[data-adsense-loader="1"]')) {
                var attempts = 0;
                var wait = setInterval(function () {
                    attempts++;
                    if (typeof window.adsbygoogle !== 'undefined' || attempts > 60) {
                        clearInterval(wait);
                        done();
                    }
                }, 100);
                return;
            }

            var tag = document.createElement('script');
            tag.async = true;
            tag.setAttribute('data-adsense-loader', '1');
            tag.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' + encodeURIComponent(client);
            tag.crossOrigin = 'anonymous';
            tag.onload = done;
            tag.onerror = done;
            document.head.appendChild(tag);
        }

        function start() {
            if (!document.querySelector('ins.adsbygoogle[data-ad-slot]')) {
                return;
            }

            loadScript(function () {
                initUnits();
                [400, 1200, 3000, 6000].forEach(function (ms) {
                    setTimeout(initUnits, ms);
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', start, { once: true });
        } else {
            start();
        }

        window.addEventListener('load', start, { once: true });
    })();
</script>
@endif
@endif
