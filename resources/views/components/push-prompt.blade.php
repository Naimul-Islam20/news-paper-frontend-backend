<div
    id="push-prompt-root"
    class="hidden w-full bg-slate-900 text-white border-b border-slate-800"
    aria-hidden="true"
    role="dialog"
    aria-label="নোটিফিকেশন অনুরোধ"
    data-push-config-url="{{ route('push.config') }}"
    data-push-subscribe-url="{{ route('push.subscribe') }}"
    data-push-unsubscribe-url="{{ route('push.unsubscribe') }}"
    data-sw-url="{{ asset('sw.js') }}">
    <div class="container flex flex-wrap items-center justify-between gap-2 py-2 px-3 sm:px-4">
        <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
            @if(!empty(optional($siteMeta)->site_icon))
            <img src="{{ storage_image_url($siteMeta->site_icon) }}" alt="" width="32" height="32" class="w-8 h-8 rounded-full object-contain bg-white shrink-0">
            @else
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center shrink-0 font-bold text-sm">
                {{ mb_substr(site_name_bn() ?: site_name(), 0, 1) }}
            </div>
            @endif
            <p class="text-xs sm:text-sm leading-snug text-white/95">
                <span class="font-semibold">{{ site_name_bn() ?: site_name() }}</span>
                <span class="text-white/80"> — সর্বশেষ খবর পেতে নোটিফিকেশন চালু করবেন?</span>
            </p>
        </div>
        <div class="flex items-center gap-2 shrink-0 ml-auto">
            <button
                type="button"
                data-push-no
                class="px-3 py-1.5 text-xs sm:text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 rounded transition-colors">
                না
            </button>
            <button
                type="button"
                data-push-yes
                class="px-4 py-1.5 text-xs sm:text-sm font-semibold bg-primary text-white hover:opacity-90 rounded transition-opacity min-w-[4.5rem]">
                হ্যাঁ
            </button>
        </div>
    </div>
</div>
