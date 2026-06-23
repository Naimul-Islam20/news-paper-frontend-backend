const MODAL_ID = "post-photocard-modal";
const PANEL_ID = "post-photocard-panel";
const CARD_ID = "post-photocard-card";
const VIEWPORT_ID = "post-photocard-viewport";
const MODAL_MAX_CARD_SIZE = 600;
const CARD_SIZE = 1080;
const IMAGE_ASPECT = 16 / 9;
const IMAGE_HEIGHT = Math.round(CARD_SIZE / IMAGE_ASPECT);
const BOTTOM_HEIGHT = CARD_SIZE - IMAGE_HEIGHT;
const SECTION_X_PADDING = 68;
const TITLE_X_PADDING = 44;
const FOOTER_HINT_SIZE = 32;
const FOOTER_URL_SIZE = 36;
const FOOTER_URL_WEIGHT = "500";
const FOOTER_URL_LETTER_SPACING = 5;
const DATE_SIZE = 32;
const LOGO_HEIGHT = 58;
const LOGO_MAX_WIDTH = 280;
const EXPORT_SCALE = 1;
const PHOTOCARD_FONT = "SolaimanLipi, sans-serif";
const OVERLAY_DARK_SOLID = "rgba(45,5,5,1)";
const IMAGE_OVERLAY_DARK_BAND = 0;
const IMAGE_OVERLAY_FADE_BAND = 0.18;

let currentPhotocardData = null;

function unifiedOverlayMetrics() {
    const imageDarkBand = Math.round(IMAGE_HEIGHT * IMAGE_OVERLAY_DARK_BAND);
    const imageFadeBand = Math.round(IMAGE_HEIGHT * IMAGE_OVERLAY_FADE_BAND);
    const height = BOTTOM_HEIGHT + imageDarkBand + imageFadeBand;
    const solidEnd = (BOTTOM_HEIGHT + imageDarkBand) / height;

    return { height, solidEnd };
}

function unifiedOverlayStops() {
    const { solidEnd } = unifiedOverlayMetrics();
    const darkPlateau = Math.max(0.5, solidEnd - 0.02);
    const fadeRange = 1 - solidEnd;
    const fadePos = (t) => solidEnd + fadeRange * t;

    return [
        { pos: 0, color: "rgba(96,20,20,1)" },
        { pos: 0.1, color: "rgba(86,16,16,0.98)" },
        { pos: 0.2, color: "rgba(76,12,12,0.98)" },
        { pos: 0.3, color: "rgba(66,10,10,0.99)" },
        { pos: 0.4, color: "rgba(56,8,8,0.99)" },
        { pos: 0.48, color: OVERLAY_DARK_SOLID },
        { pos: darkPlateau, color: OVERLAY_DARK_SOLID },
        { pos: solidEnd, color: OVERLAY_DARK_SOLID },
        { pos: fadePos(0.18), color: "rgba(45,5,5,0.8)" },
        { pos: fadePos(0.38), color: "rgba(45,5,5,0.45)" },
        { pos: fadePos(0.58), color: "rgba(45,5,5,0.2)" },
        { pos: fadePos(0.78), color: "rgba(45,5,5,0.07)" },
        { pos: fadePos(0.92), color: "rgba(45,5,5,0.02)" },
        { pos: 1, color: "rgba(45,5,5,0)" },
    ];
}

function unifiedOverlayGradientCss() {
    const stops = unifiedOverlayStops()
        .map(({ pos, color }) => `${color} ${Math.round(pos * 100)}%`)
        .join(", ");

    return `linear-gradient(to top, ${stops})`;
}

function isCrossOriginUrl(url) {
    try {
        const parsed = new URL(url, window.location.href);
        return parsed.origin !== window.location.origin;
    } catch {
        return false;
    }
}

function imageTagAttributes(url) {
    const src = escapeHtml(url);
    const crossOrigin = isCrossOriginUrl(url) ? ' crossorigin="anonymous"' : "";

    return `src="${src}" alt=""${crossOrigin}`;
}

function parsePayload(button) {
    const raw = button.getAttribute("data-photocard");
    if (!raw) {
        return null;
    }

    try {
        return JSON.parse(raw);
    } catch {
        return null;
    }
}

function escapeHtml(value) {
    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

function titleFontSize(title) {
    const length = String(title ?? "").length;

    if (length > 120) {
        return 42;
    }

    if (length > 80) {
        return 48;
    }

    if (length > 50) {
        return 54;
    }

    return 60;
}

function footerUrlMaxWidth(hasLogo) {
    const logoReserved = hasLogo ? LOGO_MAX_WIDTH + 16 : 0;

    return CARD_SIZE - SECTION_X_PADDING * 2 - logoReserved;
}

function setFooterUrlTextStyle(ctx, fontSize) {
    ctx.font = `${FOOTER_URL_WEIGHT} ${fontSize}px ${PHOTOCARD_FONT}`;
    ctx.letterSpacing = `${FOOTER_URL_LETTER_SPACING}px`;
}

function measureFooterUrlText(ctx, text, fontSize) {
    setFooterUrlTextStyle(ctx, fontSize);

    return ctx.measureText(String(text ?? "")).width;
}

function fitFooterUrlFontSize(ctx, url, maxWidth) {
    const sizes = [FOOTER_URL_SIZE, 32, 28, 24, 22, 20, 18];
    const text = String(url ?? "");

    for (const size of sizes) {
        if (measureFooterUrlText(ctx, text, size) <= maxWidth) {
            return size;
        }
    }

    return 22;
}

function wrapUrlLines(ctx, url, maxWidth, fontSize) {
    const text = String(url ?? "");
    if (text === "") {
        return [""];
    }

    const lines = [];
    let line = "";

    for (const char of text) {
        const nextLine = line + char;
        if (
            measureFooterUrlText(ctx, nextLine, fontSize) > maxWidth &&
            line !== ""
        ) {
            lines.push(line);
            line = char;
        } else {
            line = nextLine;
        }
    }

    if (line) {
        lines.push(line);
    }

    return lines.length > 0 ? lines : [text];
}

function footerAreaHeight(hasLogo) {
    const logoBoxHeight = LOGO_HEIGHT;
    const textHeight = FOOTER_HINT_SIZE + FOOTER_URL_SIZE + 12;

    return Math.max(logoBoxHeight, textHeight) + 18;
}

function dateAreaHeight(hasDate) {
    return hasDate ? DATE_SIZE + 18 : 0;
}

function buildCardHtml(data) {
    const title = escapeHtml(data.title);
    const siteName = escapeHtml(data.siteName || "");
    const siteUrl = escapeHtml(data.siteUrl || "");
    const date = escapeHtml(data.date || "");
    const primary = escapeHtml(data.primaryColor || "#28a745");
    const fontSize = titleFontSize(data.title);
    const unifiedOverlay = unifiedOverlayGradientCss();
    const { height: overlayHeight } = unifiedOverlayMetrics();
    const urlMaxWidth = footerUrlMaxWidth(Boolean(data.logo));
    const measureCanvas = document.createElement("canvas");
    const measureCtx = measureCanvas.getContext("2d");
    const urlFontSize = fitFooterUrlFontSize(
        measureCtx,
        data.siteUrl,
        urlMaxWidth,
    );

    const imageBlock = data.image
        ? `<img ${imageTagAttributes(data.image)} style="display:block;width:100%;height:100%;object-fit:cover;object-position:center top;">`
        : `<div style="width:100%;height:100%;background:linear-gradient(135deg,${primary} 0%,#0f172a 100%);"></div>`;

    const logoBlock = data.logo
        ? `<img ${imageTagAttributes(data.logo)} style="display:block;height:${LOGO_HEIGHT}px;max-width:${LOGO_MAX_WIDTH}px;object-fit:contain;">`
        : `<span style="display:block;font-size:36px;font-weight:700;color:#ffffff;line-height:1.2;text-align:right;">${siteName}</span>`;

    const dateBlock = date
        ? `<p style="position:absolute;top:16px;left:0;right:0;margin:0;text-align:center;color:#ffffff;font-size:${DATE_SIZE}px;font-weight:500;line-height:1.3;text-shadow:0 1px 4px rgba(0,0,0,0.4);">${date}</p>`
        : "";

    const footerReserved = footerAreaHeight(Boolean(data.logo));
    const dateReserved = dateAreaHeight(Boolean(date));
    const titleTop = 16 + dateReserved + (date ? 8 : 0);
    const titleBottom = footerReserved + 18;

    return `
        <div class="post-photocard-export" style="position:relative;display:flex;flex-direction:column;width:${CARD_SIZE}px;height:${CARD_SIZE}px;flex-shrink:0;background:${OVERLAY_DARK_SOLID};font-family:'SolaimanLipi',sans-serif;overflow:hidden;box-shadow:0 10px 40px rgba(15,23,42,0.15);">
            <div class="post-photocard-image" style="position:relative;width:${CARD_SIZE}px;height:${IMAGE_HEIGHT}px;flex-shrink:0;overflow:hidden;line-height:0;">
                ${imageBlock}
            </div>

            <div class="post-photocard-bottom" style="position:relative;width:${CARD_SIZE}px;height:${BOTTOM_HEIGHT}px;flex-shrink:0;background:transparent;overflow:hidden;z-index:2;">
                <div style="position:relative;z-index:2;height:100%;box-sizing:border-box;">
                    ${dateBlock}
                    <h1 style="position:absolute;left:${TITLE_X_PADDING}px;right:${TITLE_X_PADDING}px;top:${titleTop}px;bottom:${titleBottom}px;margin:0;display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:${fontSize}px;line-height:1.32;font-weight:700;color:#ffffff;text-align:center;text-shadow:0 2px 8px rgba(0,0,0,0.45);">${title}</h1>
                    <div style="position:absolute;left:${SECTION_X_PADDING}px;right:${SECTION_X_PADDING}px;bottom:18px;display:flex;align-items:flex-end;justify-content:space-between;gap:16px;z-index:3;">
                        <div style="flex:1;min-width:0;text-align:left;color:#ffffff;">
                            <div style="font-size:${FOOTER_HINT_SIZE}px;font-weight:400;line-height:1.35;opacity:0.95;">বিস্তারিত কমেন্টে ...</div>
                            <div style="font-size:${urlFontSize}px;font-weight:${FOOTER_URL_WEIGHT};line-height:1.25;margin-top:6px;letter-spacing:${FOOTER_URL_LETTER_SPACING}px;word-break:break-all;">${siteUrl}</div>
                        </div>
                        <div style="flex-shrink:0;">${logoBlock}</div>
                    </div>
                </div>
            </div>
            <div aria-hidden="true" style="position:absolute;left:0;right:0;bottom:0;height:${overlayHeight}px;background:${unifiedOverlay};pointer-events:none;z-index:1;"></div>
        </div>
    `;
}

function getModal() {
    return document.getElementById(MODAL_ID);
}

function getCardRoot() {
    return document.getElementById(CARD_ID);
}

function closeModal() {
    const modal = getModal();
    if (!modal) {
        return;
    }

    currentPhotocardData = null;
    resetModalLayout();
    modal.classList.add("hidden");
    modal.setAttribute("aria-hidden", "true");
    document.body.classList.remove("overflow-hidden");
}

function loadImage(url) {
    return new Promise((resolve) => {
        if (!url) {
            resolve(null);
            return;
        }

        const img = new Image();
        if (isCrossOriginUrl(url)) {
            img.crossOrigin = "anonymous";
        }

        img.onload = () => resolve(img);
        img.onerror = () => resolve(null);
        img.src = url;
    });
}

function wrapTextLines(ctx, text, maxWidth) {
    const words = String(text ?? "")
        .trim()
        .split(/\s+/)
        .filter(Boolean);
    if (words.length === 0) {
        return [""];
    }

    const lines = [];
    let line = words[0];

    for (let i = 1; i < words.length; i += 1) {
        const nextLine = `${line} ${words[i]}`;
        if (ctx.measureText(nextLine).width > maxWidth) {
            lines.push(line);
            line = words[i];
        } else {
            line = nextLine;
        }
    }

    lines.push(line);
    return lines;
}

function drawCoverImage(ctx, img, destX, destY, destW, destH) {
    const srcRatio = img.naturalWidth / img.naturalHeight;
    const destRatio = destW / destH;

    let sx;
    let sy;
    let sw;
    let sh;

    if (srcRatio > destRatio) {
        sh = img.naturalHeight;
        sw = sh * destRatio;
        sx = (img.naturalWidth - sw) / 2;
        sy = 0;
    } else {
        sw = img.naturalWidth;
        sh = sw / destRatio;
        sx = 0;
        sy = 0;
    }

    ctx.drawImage(img, sx, sy, sw, sh, destX, destY, destW, destH);
}

function drawUnifiedOverlayGradient(ctx, cardHeight = CARD_SIZE) {
    const { height } = unifiedOverlayMetrics();
    const topY = cardHeight - height;
    const gradient = ctx.createLinearGradient(0, cardHeight, 0, topY);

    unifiedOverlayStops().forEach(({ pos, color }) => {
        gradient.addColorStop(pos, color);
    });

    ctx.fillStyle = gradient;
    ctx.fillRect(0, topY, CARD_SIZE, height);
}

async function ensurePhotocardFont(size, weight = "700") {
    if (!document.fonts?.load) {
        return;
    }

    const spec = `${weight} ${size}px ${PHOTOCARD_FONT}`;
    await document.fonts.load(spec).catch(() => {});
}

async function renderPhotocardCanvas(data) {
    const primary = data.primaryColor || "#28a745";
    const title = String(data.title ?? "");
    const siteName = String(data.siteName ?? "");
    const siteUrl = String(data.siteUrl ?? "");
    const date = String(data.date ?? "");
    const fontSize = titleFontSize(title);
    const lineHeight = Math.round(fontSize * 1.35);
    const titleMaxWidth = CARD_SIZE - TITLE_X_PADDING * 2;

    const [postImage, logoImage] = await Promise.all([
        loadImage(data.image),
        loadImage(data.logo),
    ]);

    const bottomTop = IMAGE_HEIGHT;

    await ensurePhotocardFont(fontSize);
    if (date) {
        await ensurePhotocardFont(DATE_SIZE, "500");
    }
    await ensurePhotocardFont(FOOTER_HINT_SIZE, "400");
    await ensurePhotocardFont(FOOTER_URL_SIZE, FOOTER_URL_WEIGHT);

    const footerHeight = footerAreaHeight(Boolean(logoImage));
    const dateHeight = dateAreaHeight(Boolean(date));
    const contentTop = bottomTop + 16;
    const titleBlockTop = contentTop + dateHeight + (date ? 8 : 0);
    const titleBlockBottom = CARD_SIZE - footerHeight - 18;
    const titleBlockHeight = Math.max(0, titleBlockBottom - titleBlockTop);

    const measureCanvas = document.createElement("canvas");
    const measureCtx = measureCanvas.getContext("2d");
    measureCtx.font = `700 ${fontSize}px ${PHOTOCARD_FONT}`;
    const titleLines = wrapTextLines(measureCtx, title, titleMaxWidth);
    const titleContentHeight = titleLines.length * lineHeight;
    const titleStartY =
        titleBlockTop +
        Math.max(0, (titleBlockHeight - titleContentHeight) / 2);

    const canvas = document.createElement("canvas");
    canvas.width = Math.round(CARD_SIZE * EXPORT_SCALE);
    canvas.height = Math.round(CARD_SIZE * EXPORT_SCALE);

    const ctx = canvas.getContext("2d");
    ctx.scale(EXPORT_SCALE, EXPORT_SCALE);

    if (postImage) {
        drawCoverImage(ctx, postImage, 0, 0, CARD_SIZE, IMAGE_HEIGHT);
    } else {
        const gradient = ctx.createLinearGradient(
            0,
            0,
            CARD_SIZE,
            IMAGE_HEIGHT,
        );
        gradient.addColorStop(0, primary);
        gradient.addColorStop(1, "#0f172a");
        ctx.fillStyle = gradient;
        ctx.fillRect(0, 0, CARD_SIZE, IMAGE_HEIGHT);
    }

    drawUnifiedOverlayGradient(ctx, CARD_SIZE);

    if (date) {
        ctx.fillStyle = "#ffffff";
        ctx.font = `500 ${DATE_SIZE}px ${PHOTOCARD_FONT}`;
        ctx.textAlign = "center";
        ctx.textBaseline = "top";
        ctx.shadowColor = "rgba(0,0,0,0.4)";
        ctx.shadowBlur = 4;
        ctx.shadowOffsetY = 1;
        ctx.fillText(date, CARD_SIZE / 2, contentTop);
        ctx.shadowColor = "transparent";
        ctx.shadowBlur = 0;
        ctx.shadowOffsetY = 0;
    }

    ctx.fillStyle = "#ffffff";
    ctx.font = `700 ${fontSize}px ${PHOTOCARD_FONT}`;
    ctx.textAlign = "center";
    ctx.textBaseline = "top";
    ctx.shadowColor = "rgba(0,0,0,0.45)";
    ctx.shadowBlur = 8;
    ctx.shadowOffsetY = 2;

    titleLines.forEach((line, index) => {
        ctx.fillText(line, CARD_SIZE / 2, titleStartY + index * lineHeight);
    });

    ctx.shadowColor = "transparent";
    ctx.shadowBlur = 0;
    ctx.shadowOffsetY = 0;

    const footerBaseY = CARD_SIZE - 18;

    let urlMaxWidth = CARD_SIZE - SECTION_X_PADDING * 2;
    let footerLogoBoxWidth = 0;

    if (logoImage) {
        const logoHeight = LOGO_HEIGHT;
        const logoWidth = Math.min(
            LOGO_MAX_WIDTH,
            logoImage.naturalWidth * (logoHeight / logoImage.naturalHeight),
        );
        footerLogoBoxWidth = logoWidth + 16;
        urlMaxWidth -= footerLogoBoxWidth;
    }

    const urlFontSize = fitFooterUrlFontSize(measureCtx, siteUrl, urlMaxWidth);
    await ensurePhotocardFont(urlFontSize, FOOTER_URL_WEIGHT);
    const urlLines = wrapUrlLines(
        measureCtx,
        siteUrl,
        urlMaxWidth,
        urlFontSize,
    );
    const urlLineHeight = Math.round(urlFontSize * 1.25);
    const urlBlockHeight = urlLines.length * urlLineHeight;
    const footerHintY = footerBaseY - urlBlockHeight - 6;

    ctx.textAlign = "left";
    ctx.textBaseline = "bottom";
    ctx.fillStyle = "rgba(255,255,255,0.95)";
    ctx.font = `400 ${FOOTER_HINT_SIZE}px ${PHOTOCARD_FONT}`;
    ctx.letterSpacing = "0px";
    ctx.fillText("বিস্তারিত কমেন্টে ...", SECTION_X_PADDING, footerHintY);

    ctx.fillStyle = "#ffffff";
    setFooterUrlTextStyle(ctx, urlFontSize);
    urlLines.forEach((line, index) => {
        const lineY =
            footerBaseY - (urlLines.length - 1 - index) * urlLineHeight;
        ctx.fillText(line, SECTION_X_PADDING, lineY);
    });
    ctx.letterSpacing = "0px";

    if (logoImage) {
        const logoHeight = LOGO_HEIGHT;
        const logoWidth = Math.min(
            LOGO_MAX_WIDTH,
            logoImage.naturalWidth * (logoHeight / logoImage.naturalHeight),
        );
        const logoX = CARD_SIZE - SECTION_X_PADDING - logoWidth;
        const logoY = footerBaseY - logoHeight;

        ctx.drawImage(logoImage, logoX, logoY, logoWidth, logoHeight);
    } else if (siteName) {
        ctx.fillStyle = "#ffffff";
        ctx.font = `700 36px ${PHOTOCARD_FONT}`;
        ctx.textAlign = "right";
        ctx.textBaseline = "bottom";
        ctx.fillText(siteName, CARD_SIZE - SECTION_X_PADDING, footerBaseY);
    }

    return canvas;
}

function replaceBrokenImages(container, primaryColor = "#28a745") {
    const images = Array.from(container.querySelectorAll("img")).filter(
        (img) => !img.getAttribute("aria-hidden"),
    );

    images.forEach((img) => {
        if (img.complete && img.naturalWidth > 0) {
            return;
        }

        const placeholder = document.createElement("div");
        placeholder.style.cssText =
            "width:100%;height:100%;background:linear-gradient(135deg," +
            primaryColor +
            " 0%,#0f172a 100%);";
        img.replaceWith(placeholder);
    });
}

function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.download = filename;
    link.href = url;
    link.style.display = "none";
    document.body.appendChild(link);
    link.click();

    setTimeout(() => {
        URL.revokeObjectURL(url);
        link.remove();
    }, 1000);
}

async function canvasToBlob(canvas) {
    return new Promise((resolve, reject) => {
        canvas.toBlob((blob) => {
            if (blob) {
                resolve(blob);
                return;
            }

            reject(new Error("Failed to create image blob"));
        }, "image/png");
    });
}

function sanitizeFilenamePart(value, fallback = "image") {
    const cleaned = String(value ?? "")
        .replace(/\.[^./\\]+$/u, "")
        .replace(/[^a-z0-9-_]+/gi, "-")
        .replace(/^-+|-+$/g, "")
        .toLowerCase();

    return cleaned || fallback;
}

function buildDownloadFilename(data) {
    const postId = sanitizeFilenamePart(
        data.id ?? data.postId ?? "post",
        "post",
    );

    return `photo-card-${postId}.png`;
}

async function waitForImages(container) {
    const images = Array.from(container.querySelectorAll("img")).filter(
        (img) => !img.getAttribute("aria-hidden"),
    );

    await Promise.all(
        images.map((img) => {
            if (img.complete) {
                return Promise.resolve();
            }

            return new Promise((resolve) => {
                const done = () => resolve();
                img.addEventListener("load", done, { once: true });
                img.addEventListener("error", done, { once: true });
            });
        }),
    );
}

async function renderPreview(data) {
    const cardRoot = getCardRoot();
    if (!cardRoot) {
        return;
    }

    cardRoot.innerHTML = buildCardHtml(data);
    await waitForImages(cardRoot);
    replaceBrokenImages(cardRoot, data.primaryColor);
    await new Promise((resolve) =>
        requestAnimationFrame(() => requestAnimationFrame(resolve)),
    );
    applyPreviewScale();
}

function ensurePreviewScaler(cardRoot, cardEl) {
    let scaler = cardRoot.querySelector(".post-photocard-scaler");

    if (!scaler) {
        scaler = document.createElement("div");
        scaler.className = "post-photocard-scaler";
        scaler.style.overflow = "hidden";
        scaler.style.lineHeight = "0";
        cardRoot.insertBefore(scaler, cardEl);
        scaler.appendChild(cardEl);
    }

    return scaler;
}

function getModalPanel() {
    return document.getElementById(PANEL_ID);
}

function resetModalLayout() {
    const panel = getModalPanel();
    const viewport = getCardViewport();

    if (panel) {
        panel.style.width = "";
        panel.style.height = "";
        panel.style.maxWidth = "";
    }

    if (viewport) {
        viewport.style.width = "";
        viewport.style.height = "";
        viewport.style.flex = "";
    }
}

function getCardViewport() {
    return document.getElementById(VIEWPORT_ID);
}

function applyPreviewScale() {
    const cardRoot = getCardRoot();
    const cardEl = cardRoot?.querySelector(".post-photocard-export");
    const viewport = getCardViewport();
    const panel = getModalPanel();
    if (!cardEl || !viewport || !panel) {
        return;
    }

    const scaler = cardRoot.querySelector(".post-photocard-scaler");

    cardEl.style.transform = "";
    cardEl.style.transformOrigin = "";
    cardRoot.style.width = "";
    cardRoot.style.height = "";
    cardRoot.style.overflow = "";

    if (scaler) {
        scaler.style.width = "";
        scaler.style.height = "";
    }

    const header = panel.querySelector("[data-photocard-header]");
    const headerHeight = header?.offsetHeight ?? 52;
    const modalGutter = 40;
    const maxWidth = Math.min(
        window.innerWidth - modalGutter,
        MODAL_MAX_CARD_SIZE,
    );
    const maxHeight = Math.min(
        window.innerHeight - modalGutter - headerHeight,
        MODAL_MAX_CARD_SIZE,
    );
    const scale = Math.min(1, maxWidth / CARD_SIZE, maxHeight / CARD_SIZE);
    const scaled = Math.round(CARD_SIZE * scale);

    panel.style.width = `${scaled}px`;
    panel.style.maxWidth = `${scaled}px`;
    panel.style.height = `${scaled + headerHeight}px`;

    viewport.style.width = `${scaled}px`;
    viewport.style.height = `${scaled}px`;
    viewport.style.flex = "0 0 auto";

    const previewScaler = ensurePreviewScaler(cardRoot, cardEl);

    previewScaler.style.width = `${scaled}px`;
    previewScaler.style.height = `${scaled}px`;
    cardRoot.style.width = `${scaled}px`;
    cardRoot.style.height = `${scaled}px`;

    if (scale < 1) {
        cardEl.style.transform = `scale(${scale})`;
        cardEl.style.transformOrigin = "top left";
    }
}

async function downloadCard(data) {
    const cardRoot = getCardRoot();
    if (!cardRoot?.querySelector(".post-photocard-export")) {
        window.alert("ফটোকার্ড তৈরি করা যায়নি। আবার চেষ্টা করুন।");
        return;
    }

    const modal = getModal();
    const downloadBtn = modal?.querySelector("[data-photocard-download]");
    if (downloadBtn) {
        downloadBtn.disabled = true;
    }

    try {
        const canvas = await renderPhotocardCanvas(data);
        const blob = await canvasToBlob(canvas);
        downloadBlob(blob, buildDownloadFilename(data));
    } catch (error) {
        console.error("Photocard download failed:", error);
        window.alert(
            "ফটোকার্ড ডাউনলোড করা যায়নি। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।",
        );
    } finally {
        if (downloadBtn) {
            downloadBtn.disabled = false;
        }
    }
}

function openModal(button) {
    const data = parsePayload(button);
    const modal = getModal();

    if (!data || !modal) {
        return;
    }

    currentPhotocardData = data;
    modal.classList.remove("hidden");
    modal.setAttribute("aria-hidden", "false");
    document.body.classList.add("overflow-hidden");

    void renderPreview(data);
}

function initPostPhotocard() {
    document.addEventListener("click", (event) => {
        const openBtn = event.target.closest(".post-photocard-open");
        if (openBtn) {
            event.preventDefault();
            openModal(openBtn);
            return;
        }

        const downloadBtn = event.target.closest("[data-photocard-download]");
        if (downloadBtn) {
            event.preventDefault();
            if (currentPhotocardData) {
                void downloadCard(currentPhotocardData);
            }
            return;
        }

        if (event.target.closest("[data-photocard-close]")) {
            event.preventDefault();
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeModal();
        }
    });

    window.addEventListener("resize", () => {
        if (currentPhotocardData && !getModal()?.classList.contains("hidden")) {
            applyPreviewScale();
        }
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPostPhotocard);
} else {
    initPostPhotocard();
}
