@props(['post'])

@php
$siteDomain = photocard_site_domain(front_home_url());
$imageBasename = $post->image ? pathinfo(basename($post->image), PATHINFO_FILENAME) : '';
$photocardPayload = [
'id' => $post->id,
'title' => $post->title,
'image' => $post->image ? storage_image_url($post->image) : '',
'imageName' => $imageBasename,
'slug' => $post->slug,
'logo' => optional($siteMeta)->site_logo ? storage_image_url($siteMeta->site_logo) : '',
'icon' => optional($siteMeta)->site_icon ? storage_image_url($siteMeta->site_icon) : '',
'siteName' => site_name(),
'siteUrl' => $siteDomain,
'primaryColor' => optional($siteMeta)->primary_color ?: '#28a745',
'date' => published_at($post->created_at, 'd M Y'),
];
@endphp

<button
    type="button"
    class="post-photocard-open w-7 h-7 p-0 border border-[#22c55e] flex items-center justify-center bg-[#22c55e] text-white hover:opacity-90 transition-all"
    title="ফটোকার্ড"
    aria-label="ফটোকার্ড দেখুন ও ডাউনলোড করুন"
    data-photocard='@json($photocardPayload)'>
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <path d="M21 15l-5-5L5 21"></path>
    </svg>
</button>

@once
<div id="post-photocard-modal" class="hidden fixed inset-0 z-[120] flex items-center justify-center p-4" aria-hidden="true" role="dialog" aria-modal="true" aria-label="ফটোকার্ড প্রিভিউ">
    <div class="absolute inset-0 bg-black/70" data-photocard-close></div>

    <div id="post-photocard-panel" class="relative z-10 flex flex-col bg-white shadow-2xl overflow-hidden">
        <div data-photocard-header class="flex-shrink-0 flex items-center justify-between gap-2 border-b border-slate-200 bg-white px-3 py-2">
            <h3 class="text-base font-bold text-title">ফটোকার্ড</h3>
            <div class="flex items-center gap-2">
                <button type="button" data-photocard-download class="w-9 h-9 border border-primary flex items-center justify-center bg-primary text-white hover:opacity-90 transition-all disabled:opacity-50" title="ডাউনলোড করুন" aria-label="ডাউনলোড করুন">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                </button>
                <button type="button" data-photocard-close class="w-9 h-9 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100" aria-label="বন্ধ করুন">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="post-photocard-viewport" class="overflow-hidden leading-none">
            <div id="post-photocard-card" class="inline-block"></div>
        </div>
    </div>
</div>
@endonce