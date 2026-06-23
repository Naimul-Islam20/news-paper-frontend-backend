@if(google_adsense_frontend_enabled())
@php $adsenseClient = google_adsense_client(); @endphp
@if($adsenseClient)
<script>
    (function () {
        var started = false;

        function pendingUnits() {
            return document.querySelectorAll('ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])');
        }

        function blockAutoAds() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;max-height:0!important;overflow:hidden!important;';
            });
        }

        function initNext() {
            if (typeof window.adsbygoogle === 'undefined') {
                return;
            }

            blockAutoAds();

            var units = pendingUnits();
            if (!units.length) {
                return;
            }

            try {
                (window.adsbygoogle = window.adsbygoogle || []).push({});
            } catch (e) {}

            if (pendingUnits().length) {
                setTimeout(initNext, 600);
            }
        }

        function loadAdsense() {
            if (typeof window.adsbygoogle !== 'undefined') {
                initNext();
                return;
            }

            if (document.querySelector('script[data-adsense-loader="1"]')) {
                var attempts = 0;
                var wait = setInterval(function () {
                    attempts++;
                    if (typeof window.adsbygoogle !== 'undefined' || attempts > 50) {
                        clearInterval(wait);
                        initNext();
                    }
                }, 120);
                return;
            }

            var tag = document.createElement('script');
            tag.async = true;
            tag.setAttribute('data-adsense-loader', '1');
            tag.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
            tag.crossOrigin = 'anonymous';
            tag.onload = initNext;
            tag.onerror = function () {};
            document.head.appendChild(tag);
        }

        function start() {
            if (started) {
                return;
            }

            if (!document.querySelector('ins.adsbygoogle[data-ad-slot]')) {
                return;
            }

            started = true;
            loadAdsense();
        }

        function schedule() {
            var run = function () {
                if ('requestIdleCallback' in window) {
                    requestIdleCallback(start, { timeout: 3000 });
                } else {
                    start();
                }
            };

            setTimeout(run, 2500);
        }

        if (document.readyState === 'complete') {
            schedule();
        } else {
            window.addEventListener('load', schedule, { once: true });
        }
    })();
</script>
@endif
@endif
