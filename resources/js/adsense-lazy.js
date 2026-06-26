/**
 * Google AdSense — lazy load, viewport অনুযায়ী সাইজ, খালি স্লট লুকানো।
 */
(function () {
    const units = document.querySelectorAll(
        "ins.adsbygoogle[data-ad-client]:not([data-ad-loaded])",
    );
    if (!units.length) {
        return;
    }

    const isMobile = () => window.matchMedia("(max-width: 767px)").matches;

    let loadPromise = null;
    const queue = [];
    let draining = false;

    function hideSlot(ins) {
        const root = ins.closest("[data-ad-slot-root]");
        if (root) {
            root.setAttribute("data-ad-collapsed", "1");
        }
    }

    function frameLimit(frame, mobile) {
        const styles = getComputedStyle(frame);
        const key = mobile ? "--ad-mobile-max-height" : "--ad-max-height";
        const raw = styles.getPropertyValue(key).trim();
        const parsed = parseInt(raw, 10);

        return Number.isFinite(parsed) && parsed > 0 ? parsed : 90;
    }

    function tuneForViewport(ins) {
        const frame = ins.closest(".ad-slot-frame");
        if (!frame) {
            return;
        }

        const mobile = isMobile();
        const layout = frame.getAttribute("data-ad-layout") || "strip";
        const maxH = frameLimit(frame, mobile);
        const width = Math.max(
            280,
            Math.min(
                frame.clientWidth || window.innerWidth,
                window.innerWidth - 24,
            ),
        );

        ins.style.width = "100%";
        ins.style.maxWidth = "100%";
        ins.style.maxHeight = maxH + "px";
        ins.setAttribute(
            "data-ad-format",
            layout === "strip" ? "horizontal" : "rectangle",
        );
        ins.setAttribute("data-ad-width", String(Math.round(width)));
        ins.setAttribute("data-ad-height", String(maxH));
    }

    function fillUnit(ins) {
        if (ins.getAttribute("data-ad-loaded") === "1") {
            return;
        }

        tuneForViewport(ins);
        ins.setAttribute("data-ad-loaded", "1");

        try {
            (window.adsbygoogle = window.adsbygoogle || []).push({});
        } catch {
            hideSlot(ins);
            return;
        }

        window.setTimeout(() => {
            const frame = ins.closest(".ad-slot-frame");
            const iframe = ins.querySelector("iframe");
            if (!iframe) {
                hideSlot(ins);
                return;
            }
            if (frame) {
                const maxH = frameLimit(frame, isMobile());
                iframe.style.maxHeight = maxH + "px";
                iframe.style.maxWidth = "100%";
            }
        }, 6000);
    }

    function loadScript(client) {
        if (loadPromise) {
            return loadPromise;
        }

        loadPromise = new Promise((resolve, reject) => {
            const s = document.createElement("script");
            s.async = true;
            s.src =
                "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=" +
                encodeURIComponent(client);
            s.crossOrigin = "anonymous";
            s.onload = resolve;
            s.onerror = reject;
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
                window.setTimeout(step, 400);
            } else {
                draining = false;
            }
        };

        step();
    }

    function enqueue(ins) {
        const client = ins.getAttribute("data-ad-client");
        if (!client) {
            hideSlot(ins);
            return;
        }

        queue.push(ins);
        loadScript(client)
            .then(drainQueue)
            .catch(() => {
                units.forEach(hideSlot);
            });
    }

    if ("IntersectionObserver" in window) {
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
            { rootMargin: "250px 0px", threshold: 0 },
        );
        units.forEach((u) => io.observe(u));
    } else {
        units.forEach(enqueue);
    }
})();
