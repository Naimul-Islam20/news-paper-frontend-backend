@if(google_adsense_frontend_enabled())
@php $adsenseClient = google_adsense_client(); @endphp
<script>
    (function () {
        var client = @json($adsenseClient);
        var scriptRequested = false;

        function initAds() {
            if (typeof window.adsbygoogle === 'undefined') {
                return;
            }
            document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])').forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
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

        function loadAdsScript(done) {
            if (typeof window.adsbygoogle !== 'undefined') {
                done();
                return;
            }

            if (scriptRequested) {
                var attempts = 0;
                var wait = setInterval(function () {
                    attempts++;
                    if (typeof window.adsbygoogle !== 'undefined' || attempts > 50) {
                        clearInterval(wait);
                        done();
                    }
                }, 100);
                return;
            }

            scriptRequested = true;
            var tag = document.createElement('script');
            tag.async = true;
            tag.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' + encodeURIComponent(client);
            tag.crossOrigin = 'anonymous';
            tag.onload = done;
            tag.onerror = done;
            document.head.appendChild(tag);
        }

        function startAds() {
            loadAdsScript(function () {
                run();
                [500, 1500, 4000, 8000].forEach(function (ms) {
                    setTimeout(run, ms);
                });
            });
        }

        if (document.readyState === 'complete') {
            setTimeout(startAds, 200);
        } else {
            window.addEventListener('load', function () {
                setTimeout(startAds, 200);
            }, { once: true });
        }
    })();
</script>
@endif
