const MODAL_ID = "post-photocard-modal";
const CARD_ID = "post-photocard-card";
const CARD_WIDTH = 900;
const IMAGE_HEIGHT = 506; // 16:9
const SECTION_X_PADDING = 24;
const TITLE_Y_PADDING = 20;
const TITLE_X_PADDING = 48;
const FOOTER_PADDING_TOP = 8;
const FOOTER_PADDING_BOTTOM = 8;
const FOOTER_ROW_HEIGHT = 32;
const EXPORT_SCALE = 1.5;
const PHOTOCARD_FONT = "SolaimanLipi, sans-serif";

let currentPhotocardData = null;

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
        return 22;
    }

    if (length > 80) {
        return 26;
    }

    if (length > 50) {
        return 28;
    }

    return 30;
}

function buildCardHtml(data) {
    const title = escapeHtml(data.title);
    const siteName = escapeHtml(data.siteName || "");
    const siteUrl = escapeHtml(data.siteUrl || "");
    const primary = escapeHtml(data.primaryColor || "#28a745");
    const fontSize = titleFontSize(data.title);

    const imageBlock = data.image
        ? `<img ${imageTagAttributes(data.image)} style="display:block;width:100%;height:auto;vertical-align:top;">`
        : `<div style="width:100%;height:${IMAGE_HEIGHT}px;background:linear-gradient(135deg,${primary} 0%,#0f172a 100%);"></div>`;

    const logoBlock = data.logo
        ? `<img ${imageTagAttributes(data.logo)} style="display:block;height:32px;max-width:160px;object-fit:contain;margin:0;vertical-align:middle;">`
        : `<span style="display:block;font-size:18px;font-weight:700;color:#1d8f45;line-height:1;margin:0;">${siteName}</span>`;

    return `
        <div class="post-photocard-export" style="width:${CARD_WIDTH}px;background:#ffffff;font-family:'SolaimanLipi',sans-serif;overflow:visible;box-shadow:0 10px 40px rgba(15,23,42,0.15);display:flex;flex-direction:column;">
            <div class="post-photocard-image" style="width:100%;overflow:hidden;flex-shrink:0;line-height:0;">
                ${imageBlock}
            </div>

            <div style="padding:${TITLE_Y_PADDING}px ${TITLE_X_PADDING}px;background:#ffffff;flex-shrink:0;box-sizing:border-box;width:100%;min-height:88px;display:flex;align-items:center;justify-content:center;">
                <h1 style="margin:0;font-size:${fontSize}px;line-height:1.45;font-weight:700;color:#111111;text-align:center;max-width:100%;">${title}</h1>
            </div>

            <div style="background:#f3eee4;box-sizing:border-box;flex-shrink:0;padding:${FOOTER_PADDING_TOP}px ${SECTION_X_PADDING}px ${FOOTER_PADDING_BOTTOM}px;">
                <div style="display:grid;grid-template-columns:1fr auto 1fr;align-items:center;column-gap:12px;height:${FOOTER_ROW_HEIGHT}px;">
                    <div style="display:flex;align-items:center;justify-content:flex-start;height:100%;">
                        ${logoBlock}
                    </div>
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;background:${primary};color:#ffffff;padding:4px 16px;border-radius:999px;font-size:14px;font-weight:700;white-space:nowrap;line-height:1;margin:0;">
                        বিস্তারিত কমেন্টে
                    </div>
                    <div style="display:flex;align-items:center;justify-content:flex-end;height:100%;font-size:14px;font-weight:700;color:#111111;line-height:1;word-break:break-word;text-align:right;margin:0;">
                        ${siteUrl}
                    </div>
                </div>
            </div>
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
    const words = String(text ?? "").trim().split(/\s+/).filter(Boolean);
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

function drawRoundedRect(ctx, x, y, width, height, radius) {
    const r = Math.min(radius, width / 2, height / 2);
    ctx.beginPath();
    ctx.moveTo(x + r, y);
    ctx.lineTo(x + width - r, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + r);
    ctx.lineTo(x + width, y + height - r);
    ctx.quadraticCurveTo(x + width, y + height, x + width - r, y + height);
    ctx.lineTo(x + r, y + height);
    ctx.quadraticCurveTo(x, y + height, x, y + height - r);
    ctx.lineTo(x, y + r);
    ctx.quadraticCurveTo(x, y, x + r, y);
    ctx.closePath();
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
    const fontSize = titleFontSize(title);
    const lineHeight = Math.round(fontSize * 1.45);
    const titleMaxWidth = CARD_WIDTH - TITLE_X_PADDING * 2;

    const [postImage, logoImage] = await Promise.all([
        loadImage(data.image),
        loadImage(data.logo),
    ]);

    const imageHeight = postImage
        ? Math.round(
              CARD_WIDTH * (postImage.naturalHeight / postImage.naturalWidth),
          )
        : IMAGE_HEIGHT;

    await ensurePhotocardFont(fontSize);

    const measureCanvas = document.createElement("canvas");
    const measureCtx = measureCanvas.getContext("2d");
    measureCtx.font = `700 ${fontSize}px ${PHOTOCARD_FONT}`;
    const titleLines = wrapTextLines(measureCtx, title, titleMaxWidth);
    const titleContentHeight = titleLines.length * lineHeight;
    const titleSectionHeight = Math.max(
        88,
        titleContentHeight + TITLE_Y_PADDING * 2,
    );

    const footerHeight =
        FOOTER_PADDING_TOP + FOOTER_ROW_HEIGHT + FOOTER_PADDING_BOTTOM;
    const totalHeight = imageHeight + titleSectionHeight + footerHeight;

    const canvas = document.createElement("canvas");
    canvas.width = Math.round(CARD_WIDTH * EXPORT_SCALE);
    canvas.height = Math.round(totalHeight * EXPORT_SCALE);

    const ctx = canvas.getContext("2d");
    ctx.scale(EXPORT_SCALE, EXPORT_SCALE);
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, CARD_WIDTH, totalHeight);

    let y = 0;

    if (postImage) {
        ctx.drawImage(postImage, 0, y, CARD_WIDTH, imageHeight);
    } else {
        const gradient = ctx.createLinearGradient(0, y, CARD_WIDTH, y + imageHeight);
        gradient.addColorStop(0, primary);
        gradient.addColorStop(1, "#0f172a");
        ctx.fillStyle = gradient;
        ctx.fillRect(0, y, CARD_WIDTH, imageHeight);
    }

    y += imageHeight;

    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, y, CARD_WIDTH, titleSectionHeight);
    ctx.fillStyle = "#111111";
    ctx.font = `700 ${fontSize}px ${PHOTOCARD_FONT}`;
    ctx.textAlign = "center";
    ctx.textBaseline = "top";

    const titleStartY =
        y +
        TITLE_Y_PADDING +
        Math.max(0, (titleSectionHeight - titleContentHeight - TITLE_Y_PADDING * 2) / 2);

    titleLines.forEach((line, index) => {
        ctx.fillText(line, CARD_WIDTH / 2, titleStartY + index * lineHeight);
    });

    y += titleSectionHeight;

    ctx.fillStyle = "#f3eee4";
    ctx.fillRect(0, y, CARD_WIDTH, footerHeight);

    const rowTop = y + FOOTER_PADDING_TOP;
    const rowCenterY = rowTop + FOOTER_ROW_HEIGHT / 2;

    if (logoImage) {
        const logoHeight = 32;
        const logoWidth = Math.min(
            160,
            logoImage.naturalWidth * (logoHeight / logoImage.naturalHeight),
        );
        ctx.drawImage(
            logoImage,
            SECTION_X_PADDING,
            rowCenterY - logoHeight / 2,
            logoWidth,
            logoHeight,
        );
    } else if (siteName) {
        ctx.fillStyle = "#1d8f45";
        ctx.font = `700 18px ${PHOTOCARD_FONT}`;
        ctx.textAlign = "left";
        ctx.textBaseline = "middle";
        ctx.fillText(siteName, SECTION_X_PADDING, rowCenterY);
    }

    const pillText = "বিস্তারিত কমেন্টে";
    ctx.font = `700 14px ${PHOTOCARD_FONT}`;
    const pillTextWidth = ctx.measureText(pillText).width;
    const pillWidth = pillTextWidth + 32;
    const pillHeight = 22;
    const pillX = (CARD_WIDTH - pillWidth) / 2;
    const pillY = rowCenterY - pillHeight / 2;

    ctx.fillStyle = primary;
    drawRoundedRect(ctx, pillX, pillY, pillWidth, pillHeight, pillHeight / 2);
    ctx.fill();

    ctx.fillStyle = "#ffffff";
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.fillText(pillText, CARD_WIDTH / 2, rowCenterY);

    if (siteUrl) {
        ctx.fillStyle = "#111111";
        ctx.font = `700 14px ${PHOTOCARD_FONT}`;
        ctx.textAlign = "right";
        ctx.textBaseline = "middle";
        ctx.fillText(siteUrl, CARD_WIDTH - SECTION_X_PADDING, rowCenterY);
    }

    return canvas;
}

function replaceBrokenImages(container, primaryColor = "#28a745") {
    const images = Array.from(container.querySelectorAll("img"));

    images.forEach((img) => {
        if (img.complete && img.naturalWidth > 0) {
            return;
        }

        const placeholder = document.createElement("div");
        placeholder.style.cssText = `display:block;width:100%;height:${IMAGE_HEIGHT}px;background:linear-gradient(135deg,${primaryColor} 0%,#0f172a 100%);`;
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

async function waitForImages(container) {
    const images = Array.from(container.querySelectorAll("img"));

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

function applyPreviewScale() {
    const cardRoot = getCardRoot();
    const cardEl = cardRoot?.querySelector(".post-photocard-export");
    const viewport = cardRoot?.parentElement;
    if (!cardEl || !viewport) {
        return;
    }

    cardEl.style.transform = "";
    cardEl.style.transformOrigin = "";
    cardRoot.style.width = "";
    cardRoot.style.height = "";
    cardRoot.style.minHeight = "";
    cardRoot.style.overflow = "visible";

    const available = viewport.clientWidth;
    const scale = Math.min(1, available / CARD_WIDTH);

    if (scale < 1) {
        const fullHeight = cardEl.offsetHeight;
        cardEl.style.transform = `scale(${scale})`;
        cardEl.style.transformOrigin = "top center";
        cardRoot.style.width = `${CARD_WIDTH * scale}px`;
        cardRoot.style.minHeight = `${Math.ceil(fullHeight * scale)}px`;
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
        downloadBtn.textContent = "তৈরি হচ্ছে...";
    }

    try {
        const canvas = await renderPhotocardCanvas(data);
        const blob = await canvasToBlob(canvas);
        const slug = (data.slug || "post").replace(/[^a-z0-9-_]+/gi, "-");
        downloadBlob(blob, `photocard-${slug}.png`);
    } catch (error) {
        console.error("Photocard download failed:", error);
        window.alert("ফটোকার্ড ডাউনলোড করা যায়নি। পেজ রিফ্রেশ করে আবার চেষ্টা করুন।");
    } finally {
        if (downloadBtn) {
            downloadBtn.disabled = false;
            downloadBtn.textContent = "ডাউনলোড করুন";
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
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPostPhotocard);
} else {
    initPostPhotocard();
}
