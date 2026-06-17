@if(google_adsense_client())
<script>
    (function () {
        var running = false;
        var debounceTimer = null;

        function initAds() {
            if (typeof window.adsbygoogle === 'undefined') {
                return false;
            }
            var pending = document.querySelectorAll('.google-ad-unit ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])');
            if (!pending.length) {
                return false;
            }
            pending.forEach(function () {
                try { (window.adsbygoogle = window.adsbygoogle || []).push({}); } catch (e) {}
            });
            return true;
        }
        function blockAuto() {
            document.querySelectorAll('ins.adsbygoogle:not([data-ad-slot])').forEach(function (el) {
                el.style.cssText = 'display:none!important;height:0!important;';
            });
        }
        function run() {
            if (running) {
                return;
            }
            running = true;
            try {
                blockAuto();
                initAds();
            } finally {
                running = false;
            }
        }
        function scheduleRun() {
            if (debounceTimer !== null) {
                clearTimeout(debounceTimer);
            }
            debounceTimer = setTimeout(function () {
                debounceTimer = null;
                run();
            }, 250);
        }
        function scheduleRetries() {
            var delays = [0, 500, 1500, 4000, 8000];
            delays.forEach(function (ms) {
                setTimeout(run, ms);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', scheduleRetries);
        } else {
            scheduleRetries();
        }
        window.addEventListener('load', scheduleRetries);
        if (typeof MutationObserver !== 'undefined') {
            new MutationObserver(function (mutations) {
                for (var i = 0; i < mutations.length; i++) {
                    var added = mutations[i].addedNodes;
                    for (var j = 0; j < added.length; j++) {
                        var node = added[j];
                        if (node.nodeType !== 1) {
                            continue;
                        }
                        if (
                            (node.matches && node.matches('ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])'))
                            || (node.querySelector && node.querySelector('ins.adsbygoogle[data-ad-slot]:not([data-adsbygoogle-status])'))
                        ) {
                            scheduleRun();
                            return;
                        }
                    }
                }
            }).observe(document.documentElement, { childList: true, subtree: true });
        }
    })();
</script>
@endif
