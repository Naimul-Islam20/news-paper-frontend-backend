@props(['post'])

@php
$siteHost = share_site_label(front_home_url());
$photocardPayload = [
'title' => $post->title,
'image' => $post->image ? storage_image_url($post->image) : '',
'slug' => $post->slug,
'logo' => optional($siteMeta)->site_logo ? storage_image_url($siteMeta->site_logo) : '',
'siteName' => site_name(),
'siteUrl' => $siteHost !== '' ? $siteHost : parse_url(front_home_url(), PHP_URL_HOST),
'primaryColor' => optional($siteMeta)->primary_color ?: '#28a745',
];
@endphp

<button
    type="button"
    class="post-photocard-open w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all"
    title="ফটোকার্ড"
    aria-label="ফটোকার্ড দেখুন ও ডাউনলোড করুন"
    data-photocard='@json($photocardPayload)'>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="pointer-events-none" aria-hidden="true">
        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="8.5" r="1.5"></circle>
        <path d="M21 15l-5-5L5 21"></path>
    </svg>
</button>

@once
<div id="post-photocard-modal" class="hidden fixed inset-0 z-[120] flex items-center justify-center p-4" aria-hidden="true" role="dialog" aria-modal="true" aria-label="ফটোকার্ড প্রিভিউ">
    <div class="absolute inset-0 bg-black/70" data-photocard-close></div>

    <div class="relative z-10 w-full max-w-4xl max-h-[92vh] overflow-y-auto bg-white shadow-2xl">
        <div class="sticky top-0 z-20 flex items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 py-3">
            <h3 class="text-lg font-bold text-title">ফটোকার্ড</h3>
            <div class="flex items-center gap-2">
                <button type="button" data-photocard-download class="px-4 py-2 bg-primary text-white text-sm font-semibold hover:opacity-90 transition-opacity">
                    ডাউনলোড করুন
                </button>
                <button type="button" data-photocard-close class="w-9 h-9 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-100" aria-label="বন্ধ করুন">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="p-0 flex justify-center overflow-x-auto overflow-y-visible bg-white">
            <div id="post-photocard-card" class="flex justify-center min-w-0 w-full overflow-visible"></div>
        </div>
    </div>
</div>
@endonce