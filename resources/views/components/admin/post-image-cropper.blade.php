{{-- ১৬:৯ featured image — compact centered modal --}}
<div
    id="post-image-crop-modal"
    class="fixed inset-0 z-[99999] hidden items-center justify-center p-3 sm:p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="post-image-crop-title">
    <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" data-crop-dismiss></div>

    <div class="post-image-crop-card relative z-10 flex w-full max-w-xl flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900 sm:rounded-2xl">
        <div class="flex shrink-0 items-center gap-2 border-b border-slate-200 px-3 py-2.5 dark:border-slate-800 sm:px-4">
            <h2 id="post-image-crop-title" class="shrink-0 text-sm font-semibold text-slate-900 dark:text-slate-100">
                ছবি সাজান
            </h2>
            <div class="flex min-w-0 flex-1 rounded-md border border-slate-200 p-0.5 dark:border-slate-700" role="tablist">
                <button
                    type="button"
                    id="post-image-mode-fit"
                    class="post-image-mode-btn flex-1 rounded px-2 py-1.5 text-xs font-medium transition-colors"
                    role="tab"
                    aria-selected="true">
                    পুরো ছবি
                </button>
                <button
                    type="button"
                    id="post-image-mode-crop"
                    class="post-image-mode-btn flex-1 rounded px-2 py-1.5 text-xs font-medium transition-colors"
                    role="tab"
                    aria-selected="false">
                    ক্রপ
                </button>
            </div>
            <button
                type="button"
                class="shrink-0 rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 dark:hover:bg-slate-800"
                data-crop-dismiss
                aria-label="বন্ধ করুন">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="shrink-0 bg-slate-100 px-4 py-3 dark:bg-slate-950 sm:px-5 sm:py-4">
            <div id="post-image-stage" class="post-image-stage relative w-full overflow-hidden rounded-lg border border-slate-200 bg-slate-900 dark:border-slate-700">
                <div id="post-image-fit-panel" class="absolute inset-0">
                    <canvas id="post-image-fit-canvas" class="block h-full w-full"></canvas>
                </div>
                <div id="post-image-crop-panel" class="absolute inset-0 hidden">
                    <div id="post-image-crop-wrap" class="h-full w-full">
                        <img id="post-image-crop-source" src="" alt="Crop preview" class="block max-w-full">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2 border-t border-slate-200 px-3 py-2.5 dark:border-slate-800 sm:px-4 sm:py-3">
            <div id="post-image-crop-tools" class="hidden items-center gap-1">
                <button type="button" id="post-image-crop-zoom-out" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300" title="ছোট করুন" aria-label="Zoom out">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                </button>
                <button type="button" id="post-image-crop-zoom-in" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300" title="বড় করুন" aria-label="Zoom in">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </button>
                <button type="button" id="post-image-crop-reset" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-slate-200 text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300" title="রিসেট" aria-label="রিসেট">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v5h5"></path></svg>
                </button>
            </div>
            <div class="ml-auto flex min-w-0 flex-1 items-center justify-end gap-2">
                <button type="button" data-crop-dismiss class="inline-flex h-10 min-w-[5.5rem] flex-1 items-center justify-center rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 sm:flex-none sm:px-5">
                    বাতিল
                </button>
                <button type="button" id="post-image-crop-confirm" class="inline-flex h-10 min-w-[5.5rem] flex-1 items-center justify-center rounded-lg bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 sm:flex-none sm:px-5">
                    ব্যবহার করুন
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        #post-image-crop-modal {
            z-index: 99999 !important;
        }
        #post-image-crop-modal .post-image-crop-card {
            max-height: calc(100dvh - 1.5rem);
        }
        #post-image-crop-modal .post-image-stage {
            height: 17rem;
            max-height: 45dvh;
        }
        @media (min-width: 640px) {
            #post-image-crop-modal .post-image-stage {
                height: 22rem;
                max-height: 52dvh;
            }
        }
        #post-image-crop-wrap {
            position: relative;
            width: 100%;
            height: 100%;
        }
        #post-image-crop-wrap .cropper-container {
            width: 100% !important;
            height: 100% !important;
        }
        #post-image-crop-modal .post-image-mode-btn[aria-selected="true"] {
            background-color: #4f46e5;
            color: #fff;
        }
        #post-image-crop-modal .post-image-mode-btn[aria-selected="false"] {
            color: #64748b;
        }
        #post-image-crop-modal .post-image-mode-btn[aria-selected="false"]:hover {
            background-color: #f8fafc;
            color: #334155;
        }
        .dark #post-image-crop-modal .post-image-mode-btn[aria-selected="false"]:hover {
            background-color: #1e293b;
            color: #e2e8f0;
        }
        #post-image-crop-modal .cropper-view-box,
        #post-image-crop-modal .cropper-face {
            border-radius: 2px;
        }
        #post-image-crop-modal .cropper-line,
        #post-image-crop-modal .cropper-point {
            background-color: #6366f1;
        }
        #post-image-crop-modal .cropper-view-box {
            outline: 2px solid #6366f1;
            outline-color: rgba(99, 102, 241, 0.85);
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
    (function () {
        const TARGET_RATIO = 16 / 9;
        const RATIO_TOLERANCE = 0.015;
        const MIN_OUTPUT_WIDTH = 1280;
        const MIN_OUTPUT_HEIGHT = 720;
        const MAX_OUTPUT_WIDTH = 1920;
        const MAX_OUTPUT_HEIGHT = 1080;

        let cropper = null;
        let pendingInput = null;
        let pendingFile = null;
        let pendingObjectUrl = null;
        let pendingSourceImage = null;
        let currentMode = 'fit';

        const modal = document.getElementById('post-image-crop-modal');
        const cropImg = document.getElementById('post-image-crop-source');
        const fitCanvas = document.getElementById('post-image-fit-canvas');
        const confirmBtn = document.getElementById('post-image-crop-confirm');
        const modeFitBtn = document.getElementById('post-image-mode-fit');
        const modeCropBtn = document.getElementById('post-image-mode-crop');
        const fitPanel = document.getElementById('post-image-fit-panel');
        const cropPanel = document.getElementById('post-image-crop-panel');
        const cropTools = document.getElementById('post-image-crop-tools');

        if (!modal || !cropImg || !fitCanvas || !confirmBtn || typeof Cropper === 'undefined') {
            return;
        }

        if (modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }

        function showModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function hideModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function isSixteenByNine(width, height) {
            if (!width || !height) {
                return false;
            }
            return Math.abs((width / height) - TARGET_RATIO) <= RATIO_TOLERANCE;
        }

        function loadImageFromFile(file) {
            return new Promise(function (resolve, reject) {
                const url = URL.createObjectURL(file);

                if (window.createImageBitmap) {
                    createImageBitmap(file, { imageOrientation: 'from-image' })
                        .then(function (bitmap) {
                            resolve({
                                width: bitmap.width,
                                height: bitmap.height,
                                url: url,
                                img: bitmap,
                            });
                        })
                        .catch(function () {
                            loadWithImageElement(url, resolve, reject);
                        });
                    return;
                }

                loadWithImageElement(url, resolve, reject);
            });
        }

        function loadWithImageElement(url, resolve, reject) {
            const img = new Image();
            img.onload = function () {
                resolve({
                    width: img.naturalWidth,
                    height: img.naturalHeight,
                    url: url,
                    img: img,
                });
            };
            img.onerror = reject;
            img.src = url;
        }

        function calcFitOutputSize(img) {
            const nw = img.naturalWidth || img.width;
            const nh = img.naturalHeight || img.height;
            let outW = MIN_OUTPUT_WIDTH;
            let outH = MIN_OUTPUT_HEIGHT;

            const fgScale = Math.min(outW / nw, outH / nh);
            const fgW = nw * fgScale;
            const targetFgW = Math.min(nw, 1600);

            if (fgW < targetFgW && nw > fgW) {
                const mul = targetFgW / fgW;
                outW = Math.min(MAX_OUTPUT_WIDTH, Math.round(outW * mul));
                outH = Math.round(outW / TARGET_RATIO);
            }

            return { width: outW, height: outH };
        }

        function getCropOutputSize(cropper) {
            const data = cropper.getData(true);
            let w = Math.max(1, Math.round(data.width));
            let h = Math.round(w / TARGET_RATIO);

            if (w < MIN_OUTPUT_WIDTH) {
                w = MIN_OUTPUT_WIDTH;
                h = MIN_OUTPUT_HEIGHT;
            } else if (w > MAX_OUTPUT_WIDTH) {
                w = MAX_OUTPUT_WIDTH;
                h = MAX_OUTPUT_HEIGHT;
            }

            return { width: w, height: h };
        }

        function getExportFormat(file) {
            if (file.type === 'image/png') {
                return { mime: 'image/png', ext: 'png', quality: null };
            }
            if (file.type === 'image/webp') {
                return { mime: 'image/webp', ext: 'webp', quality: 0.95 };
            }
            return { mime: 'image/jpeg', ext: 'jpg', quality: 0.95 };
        }

        function applyPreview(input, dataUrl) {
            const box = input.closest('[data-main-image-upload]');
            const preview = box
                ? box.querySelector('#mainImagePreview')
                : document.getElementById('mainImagePreview');
            const placeholder = box
                ? box.querySelector('#mainImagePlaceholder')
                : document.getElementById('mainImagePlaceholder');

            if (preview) {
                preview.src = dataUrl;
                preview.classList.remove('hidden');
            }
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        }

        function setFileOnInput(input, file) {
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
        }

        function destroyCropper() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        function renderFitCanvas(img, canvas) {
            const nw = img.naturalWidth || img.width;
            const nh = img.naturalHeight || img.height;
            const size = calcFitOutputSize(img);
            const width = size.width;
            const height = size.height;
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';

            ctx.fillStyle = '#0f172a';
            ctx.fillRect(0, 0, width, height);

            const coverScale = Math.max(width / nw, height / nh);
            const coverW = nw * coverScale;
            const coverH = nh * coverScale;
            const coverX = (width - coverW) / 2;
            const coverY = (height - coverH) / 2;

            ctx.save();
            ctx.filter = 'blur(28px) brightness(0.72) saturate(1.15)';
            ctx.drawImage(img, 0, 0, nw, nh, coverX, coverY, coverW, coverH);
            ctx.restore();

            ctx.save();
            ctx.fillStyle = 'rgba(15, 23, 42, 0.35)';
            ctx.fillRect(0, 0, width, height);
            ctx.restore();

            const containScale = Math.min(width / nw, height / nh);
            const fgW = nw * containScale;
            const fgH = nh * containScale;
            const fgX = (width - fgW) / 2;
            const fgY = (height - fgH) / 2;

            ctx.drawImage(img, 0, 0, nw, nh, fgX, fgY, fgW, fgH);

            return canvas;
        }

        function renderFitPreview(img, canvas, width, height) {
            const nw = img.naturalWidth || img.width;
            const nh = img.naturalHeight || img.height;
            const w = Math.max(1, Math.round(width));
            const h = Math.max(1, Math.round(height));
            canvas.width = w;
            canvas.height = h;
            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';

            ctx.fillStyle = '#0f172a';
            ctx.fillRect(0, 0, w, h);

            const coverScale = Math.max(w / nw, h / nh);
            const coverW = nw * coverScale;
            const coverH = nh * coverScale;
            const coverX = (w - coverW) / 2;
            const coverY = (h - coverH) / 2;

            ctx.save();
            ctx.filter = 'blur(28px) brightness(0.72) saturate(1.15)';
            ctx.drawImage(img, 0, 0, nw, nh, coverX, coverY, coverW, coverH);
            ctx.restore();

            ctx.fillStyle = 'rgba(15, 23, 42, 0.35)';
            ctx.fillRect(0, 0, w, h);

            const containScale = Math.min(w / nw, h / nh);
            const fgW = nw * containScale;
            const fgH = nh * containScale;
            const fgX = (w - fgW) / 2;
            const fgY = (h - fgH) / 2;
            ctx.drawImage(img, 0, 0, nw, nh, fgX, fgY, fgW, fgH);

            return canvas;
        }

        function updateFitPreview() {
            const stage = document.getElementById('post-image-stage');
            if (!pendingSourceImage || !fitCanvas || !stage) {
                return;
            }
            const rect = stage.getBoundingClientRect();
            renderFitPreview(pendingSourceImage, fitCanvas, rect.width, rect.height);
        }

        function observeStageResize() {
            const stage = document.getElementById('post-image-stage');
            if (!stage || typeof ResizeObserver === 'undefined') {
                return;
            }
            new ResizeObserver(function () {
                if (currentMode === 'fit' && !modal.classList.contains('hidden')) {
                    updateFitPreview();
                }
            }).observe(stage);
        }

        function centerCropBox() {
            if (!cropper) {
                return;
            }
            const imageData = cropper.getImageData();
            if (!imageData.width || !imageData.height) {
                return;
            }

            const imgRatio = imageData.width / imageData.height;
            let cropWidth;
            let cropHeight;

            if (imgRatio >= TARGET_RATIO) {
                cropHeight = imageData.height;
                cropWidth = cropHeight * TARGET_RATIO;
            } else {
                cropWidth = imageData.width;
                cropHeight = cropWidth / TARGET_RATIO;
            }

            cropper.setCropBoxData({
                left: imageData.left + (imageData.width - cropWidth) / 2,
                top: imageData.top + (imageData.height - cropHeight) / 2,
                width: cropWidth,
                height: cropHeight,
            });
        }

        function initCropper() {
            if (cropper || !pendingObjectUrl) {
                return;
            }

            cropper = new Cropper(cropImg, {
                aspectRatio: TARGET_RATIO,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.92,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                ready: function () {
                    centerCropBox();
                    cropper.resize();
                },
            });
        }

        window.addEventListener('resize', function () {
            if (modal.classList.contains('hidden')) {
                return;
            }
            if (currentMode === 'fit') {
                updateFitPreview();
            } else if (cropper) {
                cropper.resize();
            }
        });

        observeStageResize();

        function setMode(mode) {
            currentMode = mode === 'crop' ? 'crop' : 'fit';

            const isFit = currentMode === 'fit';
            modeFitBtn.setAttribute('aria-selected', isFit ? 'true' : 'false');
            modeCropBtn.setAttribute('aria-selected', isFit ? 'false' : 'true');

            fitPanel.classList.toggle('hidden', !isFit);
            cropPanel.classList.toggle('hidden', isFit);
            cropTools.classList.toggle('hidden', isFit);
            cropTools.classList.toggle('flex', !isFit);

            if (isFit) {
                updateFitPreview();
            } else {
                if (!pendingObjectUrl) {
                    return;
                }
                cropImg.src = pendingObjectUrl;
                if (!cropper) {
                    initCropper();
                } else {
                    cropper.replace(pendingObjectUrl);
                }
                window.requestAnimationFrame(function () {
                    cropper?.resize();
                    centerCropBox();
                });
            }
        }

        function closeModal(clearInput) {
            hideModal();
            destroyCropper();
            cropImg.removeAttribute('src');
            if (pendingSourceImage && typeof pendingSourceImage.close === 'function') {
                pendingSourceImage.close();
            }
            pendingSourceImage = null;
            currentMode = 'fit';
            modeFitBtn.setAttribute('aria-selected', 'true');
            modeCropBtn.setAttribute('aria-selected', 'false');
            fitPanel.classList.remove('hidden');
            cropPanel.classList.add('hidden');
            cropTools.classList.add('hidden');
            cropTools.classList.remove('flex');

            if (pendingObjectUrl) {
                URL.revokeObjectURL(pendingObjectUrl);
                pendingObjectUrl = null;
            }
            if (clearInput && pendingInput) {
                pendingInput.value = '';
            }
            pendingInput = null;
            pendingFile = null;
        }

        function openModal(file, loaded, input) {
            pendingInput = input;
            pendingFile = file;
            pendingObjectUrl = loaded.url;
            pendingSourceImage = loaded.img;

            showModal();
            destroyCropper();
            cropImg.removeAttribute('src');

            setMode('fit');
            window.requestAnimationFrame(function () {
                updateFitPreview();
            });
        }

        async function handleFileSelect(input) {
            const file = input.files && input.files[0];
            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                input.value = '';
                return;
            }

            if (file.type === 'image/gif') {
                alert('GIF ফাইল ক্রপ করা যায় না। JPEG, PNG বা WebP ব্যবহার করুন।');
                input.value = '';
                return;
            }

            try {
                const loaded = await loadImageFromFile(file);

                if (isSixteenByNine(loaded.width, loaded.height)) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        applyPreview(input, e.target.result);
                        document.dispatchEvent(new CustomEvent('post-featured-image-updated', {
                            detail: { dataUrl: e.target.result, fileName: file.name },
                        }));
                    };
                    reader.readAsDataURL(file);
                    URL.revokeObjectURL(loaded.url);
                    return;
                }

                openModal(file, loaded, input);
            } catch (error) {
                input.value = '';
            }
        }

        function exportCanvas(canvas, callback) {
            const format = getExportFormat(pendingFile);
            canvas.toBlob(function (blob) {
                const previewUrl = format.quality
                    ? canvas.toDataURL(format.mime, format.quality)
                    : canvas.toDataURL(format.mime);
                callback(blob, previewUrl, format);
            }, format.mime, format.quality ?? undefined);
        }

        confirmBtn.addEventListener('click', function () {
            if (!pendingInput || !pendingFile) {
                return;
            }

            confirmBtn.disabled = true;
            const originalText = confirmBtn.textContent;
            confirmBtn.textContent = 'প্রসেস হচ্ছে...';

            function finish(blob, dataUrl, format) {
                confirmBtn.disabled = false;
                confirmBtn.textContent = originalText;

                if (!blob || !format) {
                    return;
                }

                const baseName = pendingFile.name.replace(/\.[^.]+$/, '') || 'featured-image';
                const output = new File([blob], baseName + '.' + format.ext, {
                    type: format.mime,
                    lastModified: Date.now(),
                });

                setFileOnInput(pendingInput, output);
                applyPreview(pendingInput, dataUrl);
                document.dispatchEvent(new CustomEvent('post-featured-image-updated', {
                    detail: { dataUrl: dataUrl, fileName: output.name },
                }));
                closeModal(false);
            }

            if (currentMode === 'fit') {
                if (!pendingSourceImage) {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = originalText;
                    return;
                }
                const canvas = document.createElement('canvas');
                renderFitCanvas(pendingSourceImage, canvas);
                exportCanvas(canvas, finish);
                return;
            }

            if (!cropper) {
                confirmBtn.disabled = false;
                confirmBtn.textContent = originalText;
                return;
            }

            const cropSize = getCropOutputSize(cropper);
            const canvas = cropper.getCroppedCanvas({
                width: cropSize.width,
                height: cropSize.height,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) {
                confirmBtn.disabled = false;
                confirmBtn.textContent = originalText;
                return;
            }

            exportCanvas(canvas, finish);
        });

        modeFitBtn.addEventListener('click', function () {
            setMode('fit');
        });
        modeCropBtn.addEventListener('click', function () {
            setMode('crop');
        });

        modal.querySelectorAll('[data-crop-dismiss]').forEach(function (el) {
            el.addEventListener('click', function () {
                closeModal(true);
            });
        });

        document.getElementById('post-image-crop-zoom-in')?.addEventListener('click', function () {
            cropper?.zoom(0.1);
        });
        document.getElementById('post-image-crop-zoom-out')?.addEventListener('click', function () {
            cropper?.zoom(-0.1);
        });
        document.getElementById('post-image-crop-reset')?.addEventListener('click', function () {
            cropper?.reset();
            centerCropBox();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal(true);
            }
        });

        window.AdminPostImageCrop = {
            init: function (selector) {
                const input = typeof selector === 'string'
                    ? document.querySelector(selector)
                    : selector;

                if (!input || input.dataset.cropBound === '1') {
                    return;
                }

                input.dataset.cropBound = '1';
                input.addEventListener('change', function () {
                    handleFileSelect(this);
                });
            },
            handleFile: handleFileSelect,
        };
    })();
    </script>
    @endpush
@endonce
