/**
 * Google AdSense — পেজ লোডের পর idle-এ lazy load (blank/hang রোধ)।
 */
(function () {
    const isMobile = () => window.matchMedia('(max-width: 767px)').matches;

    let loadPromise = null;
    const queue = [];
    let draining = false;
    let started = false;

    function hideSlot(ins) {
        const root = ins.closest('[data-ad-slot-root]');
        if (root) {
            root.setAttribute('data-ad-collapsed', '1');
        }
    }

    function frameLimit(frame, mobile) {
        const styles = getComputedStyle(frame);
        const key = mobile ? '--ad-mobile-max-height' : '--ad-max-height';
        const raw = styles.getPropertyValue(key).trim();
        const parsed = parseInt(raw, 10);

        return Number.isFinite(parsed) && parsed > 0 ? parsed : 90;
    }

    function frameWidth(frame) {
        let w = frame?.clientWidth || 0;

        if (w > 0) {
            return w;
        }

        w = frame?.offsetWidth || 0;
        if (w > 0) {
            return w;
        }

        const parent = frame?.parentElement;
        if (parent) {
            w = parent.clientWidth || parent.offsetWidth || 0;
            if (w > 0) {
                return w;
            }
        }

        return frame?.getAttribute('data-ad-layout') === 'box' ? 300 : 320;
    }

    function boxHeightFromAspect(frame, width, capH) {
        const styles = getComputedStyle(frame);
        const ar = styles.aspectRatio;

        if (ar && ar !== 'auto') {
            if (ar.includes('/')) {
                const parts = ar.split('/').map((part) => parseFloat(part.trim()));

                if (parts.length === 2 && parts[0] > 0 && parts[1] > 0) {
                    return Math.min(capH, Math.round(width * (parts[1] / parts[0])));
                }
            } else {
                const ratio = parseFloat(ar);

                if (Number.isFinite(ratio) && ratio > 0) {
                    return Math.min(capH, Math.round(width / ratio));
                }
            }
        }

        const maxW = parseInt(styles.getPropertyValue('--ad-max-width'), 10);
        const maxH = parseInt(styles.getPropertyValue('--ad-max-height'), 10);

        if (maxW > 0 && maxH > 0) {
            return Math.min(capH, Math.round(width * (maxH / maxW)));
        }

        return Math.min(capH, Math.round(width * 0.75));
    }

    function frameMetrics(frame, mobile) {
        const layout = frame.getAttribute('data-ad-layout') || 'strip';
        const capH = frameLimit(frame, mobile);
        const width = frameWidth(frame);

        if (layout === 'box') {
            const measured = frame.clientHeight;
            const height =
                measured > 0 ? Math.min(capH, measured) : boxHeightFromAspect(frame, width, capH);

            return { width, height, layout };
        }

        return { width, height: capH, layout };
    }

    function prepareBoxFrame(frame, height) {
        if (frame.getAttribute('data-ad-layout') !== 'box' || height <= 0) {
            return;
        }

        frame.style.height = height + 'px';
        frame.style.minHeight = height + 'px';
    }

    function fitBoxIframe(iframe, frame, targetH) {
        const frameW = frame.clientWidth || frameWidth(frame);
        const frameH = frame.clientHeight > 0 ? frame.clientHeight : targetH;

        if (frameW < 1 || frameH < 1) {
            return;
        }

        let adW = iframe.offsetWidth;
        let adH = iframe.offsetHeight;

        if (!adW || !adH) {
            adW = parseInt(iframe.getAttribute('width'), 10) || frameW;
            adH = parseInt(iframe.getAttribute('height'), 10) || frameH;
        }

        const scale = Math.min(frameW / adW, frameH / adH, 1);
        const w = Math.max(1, Math.round(adW * scale));
        const h = Math.max(1, Math.round(adH * scale));

        iframe.style.width = w + 'px';
        iframe.style.height = h + 'px';
        iframe.style.maxWidth = '100%';
        iframe.style.maxHeight = frameH + 'px';
        iframe.style.marginInline = 'auto';
    }

    function clampIframe(ins) {
        const frame = ins.closest('.ad-slot-frame');
        const iframe = ins.querySelector('iframe');
        if (!frame || !iframe) {
            return false;
        }

        const { width, height, layout } = frameMetrics(frame, isMobile());

        iframe.style.display = 'block';

        if (layout === 'box') {
            prepareBoxFrame(frame, height);
            fitBoxIframe(iframe, frame, height);
        } else {
            iframe.style.width = '100%';
            iframe.style.maxWidth = '100%';
            iframe.style.maxHeight = height + 'px';
            iframe.style.height = 'auto';
            iframe.style.marginInline = 'auto';
        }

        return true;
    }

    function tuneForViewport(ins) {
        const frame = ins.closest('.ad-slot-frame');
        if (!frame) {
            return;
        }

        const mobile = isMobile();
        const { width, height, layout } = frameMetrics(frame, mobile);

        if (layout === 'box') {
            prepareBoxFrame(frame, height);
        }

        ins.style.width = '100%';
        ins.style.maxWidth = '100%';
        ins.style.maxHeight = height + 'px';
        ins.setAttribute('data-ad-format', layout === 'strip' ? 'horizontal' : 'rectangle');
        ins.setAttribute('data-ad-width', String(Math.round(width)));
        ins.setAttribute('data-ad-height', String(Math.round(height)));
    }

    function fillUnit(ins) {
        if (ins.getAttribute('data-ad-loaded') === '1') {
            return;
        }

        tuneForViewport(ins);
        ins.setAttribute('data-ad-loaded', '1');

        try {
            (window.adsbygoogle = window.adsbygoogle || []).push({});
        } catch {
            hideSlot(ins);
            return;
        }

        let done = false;
        const finish = () => {
            if (done) {
                return;
            }
            if (clampIframe(ins)) {
                done = true;
                mo.disconnect();
            }
        };

        const mo = new MutationObserver(finish);
        mo.observe(ins, { childList: true, subtree: true });

        window.setTimeout(() => {
            mo.disconnect();
            if (!done && !clampIframe(ins)) {
                hideSlot(ins);
            }
        }, 8000);

        window.setTimeout(() => clampIframe(ins), 1500);
        window.setTimeout(() => clampIframe(ins), 3000);
    }

    function clampAllBoxAds() {
        document.querySelectorAll('ins.adsbygoogle[data-ad-loaded="1"]').forEach((ins) => {
            clampIframe(ins);
        });
    }

    function loadScript(client) {
        if (loadPromise) {
            return loadPromise;
        }

        loadPromise = new Promise((resolve, reject) => {
            if (document.querySelector('script[src*="adsbygoogle.js"]')) {
                resolve();
                return;
            }

            const s = document.createElement('script');
            s.async = true;
            s.src =
                'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' +
                encodeURIComponent(client);
            s.crossOrigin = 'anonymous';
            s.onload = () => resolve();
            s.onerror = () => reject(new Error('adsense'));
            document.head.appendChild(s);
        });

        return loadPromise;
    }

    function drainQueue() {
        if (draining || !queue.length) {
            return;
        }
        draining = true;

        const step = () => {
            const ins = queue.shift();
            if (!ins) {
                draining = false;
                return;
            }
            fillUnit(ins);
            if (queue.length) {
                window.setTimeout(step, 600);
            } else {
                draining = false;
            }
        };

        step();
    }

    function enqueue(ins) {
        const client = ins.getAttribute('data-ad-client');
        if (!client) {
            hideSlot(ins);
            return;
        }

        queue.push(ins);
        loadScript(client)
            .then(drainQueue)
            .catch(() => hideSlot(ins));
    }

    function initLazyLoad() {
        if (started) {
            return;
        }
        started = true;

        const units = document.querySelectorAll(
            'ins.adsbygoogle[data-ad-client]:not([data-ad-loaded])',
        );

        if (!units.length) {
            return;
        }

        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) {
                            return;
                        }
                        io.unobserve(entry.target);
                        enqueue(entry.target);
                    });
                },
                { rootMargin: '100px 0px', threshold: 0 },
            );
            units.forEach((u) => io.observe(u));
        } else {
            units.forEach(enqueue);
        }
    }

    function scheduleInit() {
        const run = () => window.setTimeout(initLazyLoad, 1200);

        if (document.readyState === 'complete') {
            run();
        } else {
            window.addEventListener('load', run, { once: true });
        }

        let resizeTimer = 0;
        window.addEventListener('resize', () => {
            window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(clampAllBoxAds, 200);
        });
    }

    scheduleInit();
})();
