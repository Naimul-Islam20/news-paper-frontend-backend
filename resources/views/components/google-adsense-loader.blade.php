@if(google_adsense_frontend_enabled())
<script>
    (function () {
        var scriptRequested = false;
        var scriptLoaded = false;
        var pendingInits = [];

        function manualUnits() {
            return document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]');
        }

        function blockAuto() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;max-height:0!important;overflow:hidden!important;';
            });
        }

        function initUnit(ins) {
            if (!ins || ins.getAttribute('data-adsbygoogle-status')) {
                return;
            }

            if (typeof window.adsbygoogle === 'undefined') {
                pendingInits.push(ins);
                return;
            }

            try {
                (window.adsbygoogle = window.adsbygoogle || []).push({});
            } catch (e) {}
        }

        function flushPending() {
            pendingInits.splice(0).forEach(initUnit);
            blockAuto();
        }

        function loadAdsScript(done) {
            if (typeof window.adsbygoogle !== 'undefined') {
                scriptLoaded = true;
                done();
                return;
            }

            if (scriptRequested) {
                var attempts = 0;
                var wait = setInterval(function () {
                    attempts++;
                    if (typeof window.adsbygoogle !== 'undefined' || attempts > 40) {
                        clearInterval(wait);
                        scriptLoaded = typeof window.adsbygoogle !== 'undefined';
                        done();
                    }
                }, 100);
                return;
            }

            scriptRequested = true;
            var tag = document.createElement('script');
            tag.async = true;
            tag.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';
            tag.crossOrigin = 'anonymous';
            tag.onload = function () {
                scriptLoaded = true;
                done();
            };
            tag.onerror = done;
            document.head.appendChild(tag);
        }

        function start() {
            var units = manualUnits();
            if (!units.length) {
                return;
            }

            blockAuto();

            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        observer.unobserve(entry.target);
                        loadAdsScript(function () {
                            initUnit(entry.target);
                            flushPending();
                        });
                    });
                }, { rootMargin: '240px 0px' });

                units.forEach(function (ins) {
                    observer.observe(ins);
                });

                setTimeout(function () {
                    loadAdsScript(function () {
                        units.forEach(initUnit);
                        flushPending();
                    });
                }, 2500);
            } else {
                loadAdsScript(function () {
                    units.forEach(initUnit);
                    flushPending();
                });
            }

            [800, 2000, 5000].forEach(function (ms) {
                setTimeout(blockAuto, ms);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', start, { once: true });
        } else {
            start();
        }
    })();
</script>
@endif
