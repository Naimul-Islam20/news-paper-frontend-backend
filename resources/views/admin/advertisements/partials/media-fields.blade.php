@php
$display = $display ?? null;
$mediaType = old('media_type', $display?->resolvedMediaType() ?? 'image');
$idPrefix = $idPrefix ?? '';
$mediaSpec = $mediaSpec ?? null;
@endphp

<div class="p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30 space-y-4">

    <div>
        <label for="{{ $idPrefix }}media_type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">মিডিয়া ধরন</label>
        <select name="media_type" id="{{ $idPrefix }}media_type" class="ad-media-type-select w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm" data-prefix="{{ $idPrefix }}">
            <option value="image" @selected($mediaType==='image' )>ইমেজ / GIF</option>
            <option value="video" @selected($mediaType==='video' )>ভিডিও ফাইল (MP4, WebM)</option>
            <option value="youtube" @selected($mediaType==='youtube' )>YouTube</option>
        </select>
    </div>

    <div>
        <label for="{{ $idPrefix }}link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL (ক্লিক করলে যাবে) <span class="text-rose-600">*</span></label>
        <input type="url" name="link" id="{{ $idPrefix }}link" value="{{ old('link', $display?->link ?? '') }}" placeholder="https://example.com/..." required class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
    </div>

    <div id="{{ $idPrefix }}media-image" class="ad-media-panel space-y-4 {{ $mediaType !== 'image' ? 'hidden' : '' }}">
        <div>
            <label for="{{ $idPrefix }}caption" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Caption (ঐচ্ছিক)</label>
            <input type="text" name="caption" id="{{ $idPrefix }}caption" value="{{ old('caption', $display?->caption ?? '') }}" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
        </div>
        <div>
            <label for="{{ $idPrefix }}image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ডেস্কটপ ইমেজ / GIF <span class="text-rose-600">*</span></label>
            @if($display?->image)
            <div class="mb-2 flex items-center gap-3">
                <img src="{{ storage_image_url($display->image) }}" alt="" class="h-16 w-24 object-contain rounded border border-slate-200 dark:border-slate-700 bg-white">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-rose-600">
                    <span>ইমেজ মুছুন</span>
                </label>
            </div>
            @endif
            <input type="file" name="image" id="{{ $idPrefix }}image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700">
        </div>
        <div>
            <label for="{{ $idPrefix }}image_mobile" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">মোবাইল ইমেজ (ঐচ্ছিক)</label>
            @if($display?->image_mobile)
            <div class="mb-2 flex items-center gap-3">
                <img src="{{ storage_image_url($display->image_mobile) }}" alt="" class="h-16 w-20 object-contain rounded border border-slate-200 dark:border-slate-700 bg-white">
                <label class="inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="remove_image_mobile" value="1" class="rounded border-slate-300 text-rose-600">
                    <span>মোবাইল ইমেজ মুছুন</span>
                </label>
            </div>
            @endif
            <input type="file" name="image_mobile" id="{{ $idPrefix }}image_mobile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700">
        </div>
    </div>

    <div id="{{ $idPrefix }}media-video" class="ad-media-panel space-y-4 {{ $mediaType !== 'video' ? 'hidden' : '' }}">
        <div>
            <label for="{{ $idPrefix }}video" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ডেস্কটপ ভিডিও <span class="text-rose-600">*</span></label>
            @if($display?->video)
            <div class="mb-2">
                <video src="{{ storage_image_url($display->video) }}" class="max-h-32 rounded border border-slate-200" controls muted playsinline></video>
                <label class="mt-2 inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="remove_video" value="1" class="rounded border-slate-300 text-rose-600">
                    <span>ভিডিও মুছুন</span>
                </label>
            </div>
            @endif
            <input type="file" name="video" id="{{ $idPrefix }}video" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700">
            <p class="mt-1 text-xs text-slate-500">সর্বোচ্চ ৫০MB — MP4, WebM, MOV</p>
        </div>
        <div>
            <label for="{{ $idPrefix }}video_mobile" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">মোবাইল ভিডিও (ঐচ্ছিক)</label>
            @if($display?->video_mobile)
            <div class="mb-2">
                <video src="{{ storage_image_url($display->video_mobile) }}" class="max-h-32 rounded border border-slate-200" controls muted playsinline></video>
                <label class="mt-2 inline-flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="remove_video_mobile" value="1" class="rounded border-slate-300 text-rose-600">
                    <span>মোবাইল ভিডিও মুছুন</span>
                </label>
            </div>
            @endif
            <input type="file" name="video_mobile" id="{{ $idPrefix }}video_mobile" accept="video/mp4,video/webm,video/quicktime,.mp4,.webm,.mov" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700">
        </div>
    </div>

    <div id="{{ $idPrefix }}media-youtube" class="ad-media-panel space-y-4 {{ $mediaType !== 'youtube' ? 'hidden' : '' }}">
        <div>
            <label for="{{ $idPrefix }}video_youtube_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">YouTube Video ID বা URL <span class="text-rose-600">*</span></label>
            <input type="text" name="video_youtube_id" id="{{ $idPrefix }}video_youtube_id" value="{{ old('video_youtube_id', $display?->video_youtube_id ?? '') }}" placeholder="https://youtube.com/watch?v=..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
        </div>
    </div>
</div>