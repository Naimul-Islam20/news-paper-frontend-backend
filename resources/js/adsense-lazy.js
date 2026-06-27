/**
 * Google AdSense — iframe sizing/clamping (push HTML-এ inline হয়)।
 */
(function () {
    const isMobile = () => window.matchMedia('(max-width: 767px)').matches;

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

        ins.style.display = 'block';
        ins.style.width = '100%';
        ins.style.overflow = 'hidden';

        if (isBelowMenuStrip(frame)) {
            ins.style.position = 'absolute';
            ins.style.inset = '0';
            ins.style.height = '100%';
            ins.style.minHeight = '100%';
            ins.style.maxHeight = '100%';
        } else {
            ins.style.position = 'relative';
            ins.style.height = height + 'px';
            ins.style.minHeight = height + 'px';
        }
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

    function watchUnit(ins) {
        if (ins.getAttribute('data-ad-watched') === '1') {
            return;
        }
        ins.setAttribute('data-ad-watched', '1');

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

        window.setTimeout(() => clampIframe(ins), 50);
        window.setTimeout(() => clampIframe(ins), 200);
        window.setTimeout(() => clampIframe(ins), 800);
    }

    function clampAllBoxAds() {
        document.querySelectorAll('ins.adsbygoogle[data-ad-client]').forEach((ins) => {
            clampIframe(ins);
        });
    }

    function boot() {
        document.querySelectorAll('ins.adsbygoogle[data-ad-client]').forEach((ins) => {
            watchUnit(ins);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot, { once: true });
    } else {
        boot();
    }

    let resizeTimer = 0;
    window.addEventListener('resize', () => {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(clampAllBoxAds, 150);
    });
})();
