/**
 * Google AdSense — priority slot তৎক্ষণাৎ, বাকি viewport-এ lazy load।
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

    function isBelowMenuStrip(frame) {
        return (
            Boolean(frame?.closest('[data-ad-below-menu]')) &&
            frame?.getAttribute('data-ad-layout') !== 'box'
        );
    }

    function frameMetrics(frame, mobile) {
        const layout = frame.getAttribute('data-ad-layout') || 'strip';
        const capH = frameLimit(frame, mobile);
        const width = frameWidth(frame);

        if (isBelowMenuStrip(frame)) {
            const height = mobile ? boxHeightFromAspect(frame, width, capH) : capH;

            return { width, height, layout };
        }

        if (layout === 'box') {
            const height = boxHeightFromAspect(frame, width, capH);

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

    function prepareStripFrame(frame, height) {
        if (frame.getAttribute('data-ad-layout') === 'box' || height <= 0) {
            return;
        }

        frame.style.height = height + 'px';
        frame.style.minHeight = height + 'px';
    }

    function prepareFilledFrame(ins, frame, height, layout) {
        if (layout === 'box') {
            prepareBoxFrame(frame, height);
        } else if (isBelowMenuStrip(frame)) {
            prepareStripFrame(frame, height);
        } else {
            return;
        }

        ins.style.height = height + 'px';
        ins.style.minHeight = height + 'px';
        ins.style.position = 'relative';
        ins.style.overflow = 'hidden';
    }

    function fitStripIframe(iframe, frame, targetH) {
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

        if (adW < 1 || adH < 1) {
            adW = frameW;
            adH = frameH;
        }

        // full width — local strip banner এর মতো প্রস্থ পূর্ণ
        const scale = frameW / adW;
        const w = Math.max(1, Math.round(adW * scale));
        const h = Math.max(1, Math.round(adH * scale));

        iframe.style.position = 'absolute';
        iframe.style.left = '50%';
        iframe.style.top = '50%';
        iframe.style.transform = 'translate(-50%, -50%)';
        iframe.style.width = w + 'px';
        iframe.style.height = h + 'px';
        iframe.style.maxWidth = 'none';
        iframe.style.maxHeight = 'none';
        iframe.style.marginInline = '0';
        iframe.style.display = 'block';
        iframe.style.border = '0';
    }

    function syncGoogleStripHosts(ins) {
        if (!ins) {
            return;
        }

        ins.querySelectorAll('div').forEach((host) => {
            host.style.position = 'absolute';
            host.style.inset = '0';
            host.style.width = '100%';
            host.style.maxWidth = '100%';
            host.style.height = '100%';
            host.style.maxHeight = '100%';
            host.style.overflow = 'hidden';
            host.style.margin = '0';
        });
    }

    function fitBelowMenuStripIframe(iframe, frame, targetH) {
        const frameW = frame.clientWidth || frameWidth(frame);
        const frameH = frame.clientHeight > 0 ? frame.clientHeight : targetH;

        if (frameW < 1 || frameH < 1) {
            return;
        }

        let adW = iframe.offsetWidth;
        let adH = iframe.offsetHeight;

        if (!adW || !adH) {
            adW = parseInt(iframe.getAttribute('width'), 10) || frameW;
            adH = parseInt(iframe.getAttribute('height'), 10) || Math.round(frameW / 13);
        }

        if (adW < 1 || adH < 1) {
            adW = frameW;
            adH = Math.round(frameW / 13);
        }

        // local strip — container width পূর্ণ, height cap
        const w = frameW;
        const h = Math.min(frameH, Math.max(1, Math.round((adH / adW) * w)));

        const ins = iframe.closest('ins.adsbygoogle');
        syncGoogleStripHosts(ins);

        iframe.style.position = 'absolute';
        iframe.style.left = '0';
        iframe.style.top = '50%';
        iframe.style.transform = 'translateY(-50%)';
        iframe.style.width = w + 'px';
        iframe.style.height = h + 'px';
        iframe.style.maxWidth = 'none';
        iframe.style.maxHeight = frameH + 'px';
        iframe.style.margin = '0';
        iframe.style.display = 'block';
        iframe.style.border = '0';
    }

    function fitFilledIframe(iframe, frame, targetH, layout) {
        if (layout === 'box') {
            fitBoxIframe(iframe, frame, targetH);
            return;
        }

        if (isBelowMenuStrip(frame)) {
            fitBelowMenuStripIframe(iframe, frame, targetH);
            return;
        }

        fitStripIframe(iframe, frame, targetH);
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

        if (adW < 1 || adH < 1) {
            adW = frameW;
            adH = frameH;
        }

        // object-cover — local sidebar ad এর মতো frame পূর্ণ করতে scale
        const scale = Math.max(frameW / adW, frameH / adH);
        const w = Math.max(1, Math.round(adW * scale));
        const h = Math.max(1, Math.round(adH * scale));

        iframe.style.position = 'absolute';
        iframe.style.left = '50%';
        iframe.style.top = '50%';
        iframe.style.transform = 'translate(-50%, -50%)';
        iframe.style.width = w + 'px';
        iframe.style.height = h + 'px';
        iframe.style.maxWidth = 'none';
        iframe.style.maxHeight = 'none';
        iframe.style.marginInline = '0';
        iframe.style.display = 'block';
        iframe.style.border = '0';
    }

    function clampIframe(ins) {
        const frame = ins.closest('.ad-slot-frame');
        const iframe = ins.querySelector('iframe');
        if (!frame || !iframe) {
            return false;
        }

        const { width, height, layout } = frameMetrics(frame, isMobile());

        iframe.style.display = 'block';

        if (layout === 'box' || isBelowMenuStrip(frame)) {
            prepareFilledFrame(ins, frame, height, layout);
            fitFilledIframe(iframe, frame, height, layout);
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
        const belowMenu = isBelowMenuStrip(frame);

        if (layout === 'box' || belowMenu) {
            prepareFilledFrame(ins, frame, height, layout);
        }

        ins.style.display = 'block';
        ins.style.width = '100%';
        ins.style.maxWidth = '100%';

        if (belowMenu) {
            ins.style.height = height + 'px';
            ins.style.minHeight = height + 'px';
            ins.style.maxHeight = height + 'px';
            ins.style.marginInline = 'auto';
            ins.setAttribute('data-ad-format', 'horizontal');
            ins.setAttribute('data-ad-width', String(Math.round(width)));
            ins.setAttribute('data-ad-height', String(Math.round(height)));

            return;
        }

        ins.style.maxHeight = height + 'px';
        ins.setAttribute('data-ad-format', layout === 'strip' ? 'horizontal' : 'rectangle');
        ins.setAttribute('data-ad-width', String(Math.round(width)));
        ins.setAttribute('data-ad-height', String(Math.round(height)));
    }

    function watchUnit(ins) {
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

        finish();

        window.setTimeout(() => {
            mo.disconnect();
            if (!done && !clampIframe(ins) && !ins.hasAttribute('data-ad-eager')) {
                hideSlot(ins);
            }
        }, 8000);

        window.setTimeout(() => clampIframe(ins), 100);
        window.setTimeout(() => clampIframe(ins), 500);
    }

    function fillUnit(ins) {
        if (ins.getAttribute('data-ad-loaded') === '1') {
            watchUnit(ins);
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

        watchUnit(ins);
    }

    function clampAllBoxAds() {
        reserveBelowMenuSlots();
        document.querySelectorAll('ins.adsbygoogle[data-ad-loaded="1"]').forEach((ins) => {
            clampIframe(ins);
        });
    }

    function reserveBelowMenuSlots() {
        document
            .querySelectorAll(
                '[data-ad-below-menu] .ad-slot-frame.ad-slot-google:not([data-ad-layout="box"])',
            )
            .forEach((frame) => {
                const ins = frame.querySelector('ins.adsbygoogle');
                if (!ins) {
                    return;
                }

                const { height } = frameMetrics(frame, isMobile());
                if (height < 1) {
                    return;
                }

                prepareStripFrame(frame, height);
                ins.style.display = 'block';
                ins.style.position = 'relative';
                ins.style.overflow = 'hidden';
                ins.style.width = '100%';
                ins.style.height = height + 'px';
                ins.style.minHeight = height + 'px';
                ins.style.maxHeight = height + 'px';
            });
    }

    function loadScript(client) {
        if (loadPromise) {
            return loadPromise;
        }

        loadPromise = new Promise((resolve, reject) => {
            const existing = document.querySelector('script[src*="adsbygoogle.js"]');
            if (existing) {
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

    function isPriorityUnit(ins) {
        return Boolean(
            ins.closest('[data-ad-below-menu]') || ins.closest('#header-ad-slot'),
        );
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
                step();
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

        const units = Array.from(
            document.querySelectorAll(
                'ins.adsbygoogle[data-ad-client]:not([data-ad-loaded])',
            ),
        );

        if (!units.length) {
            return;
        }

        const priority = units.filter((unit) => isPriorityUnit(unit));
        const deferred = units.filter((unit) => !isPriorityUnit(unit));

        priority.forEach((unit) => enqueue(unit));

        if (!deferred.length) {
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
                { rootMargin: '200px 0px', threshold: 0 },
            );
            deferred.forEach((unit) => io.observe(unit));
        } else {
            deferred.forEach((unit) => enqueue(unit));
        }
    }

    function watchEagerUnits() {
        document
            .querySelectorAll('ins.adsbygoogle[data-ad-eager][data-ad-loaded="1"]')
            .forEach((ins) => {
                tuneForViewport(ins);
                watchUnit(ins);
            });
    }

    function boot() {
        reserveBelowMenuSlots();
        watchEagerUnits();
        initLazyLoad();
    }

    boot();

    let resizeTimer = 0;
    window.addEventListener('resize', () => {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(clampAllBoxAds, 200);
    });
})();
