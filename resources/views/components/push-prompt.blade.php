<div
    id="push-prompt-root"
    class="hidden w-full px-2 sm:px-3 py-2 flex justify-center"
    aria-hidden="true"
    role="dialog"
    aria-label="নোটিফিকেশন অনুরোধ"
    data-push-config-url="{{ route('push.config') }}"
    data-push-subscribe-url="{{ route('push.subscribe') }}"
    data-push-unsubscribe-url="{{ route('push.unsubscribe') }}"
    data-sw-url="{{ asset('sw.js') }}">
    <div class="w-full max-w-xl rounded-xl border border-slate-200 bg-white shadow-md overflow-hidden animate-[pushSlideUp_0.3s_ease-out]">
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 p-2.5 sm:p-3">
            <div class="flex items-center gap-2.5 min-w-0 flex-1">
                @if(!empty(optional($siteMeta)->site_icon))
                <img src="{{ storage_image_url($siteMeta->site_icon) }}" alt="" width="36" height="36" class="w-9 h-9 rounded-lg object-contain bg-slate-50 shrink-0 border border-slate-100">
                @else
                <div class="w-9 h-9 rounded-lg bg-primary text-white flex items-center justify-center shrink-0 font-bold text-sm">
                    {{ mb_substr(site_name_bn() ?: site_name(), 0, 1) }}
                </div>
                @endif
                <div class="min-w-0">
                    <p class="text-[13px] font-semibold text-slate-900 leading-tight truncate">{{ site_name_bn() ?: site_name() }}</p>
                    <p class="text-[11px] sm:text-xs text-slate-600 leading-snug">সর্বশেষ খবর পেতে নোটিফিকেশন চালু করবেন?</p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0 sm:ml-auto">
                <button
                    type="button"
                    data-push-no-secondary
                    class="flex-1 sm:flex-none px-4 py-1.5 text-xs sm:text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                    না
                </button>
                <button
                    type="button"
                    data-push-yes
                    class="flex-1 sm:flex-none px-4 py-1.5 text-xs sm:text-sm font-semibold text-white bg-primary hover:opacity-90 rounded-lg transition-opacity min-w-[4rem]">
                    হ্যাঁ
                </button>
                <button
                    type="button"
                    data-push-no
                    class="hidden sm:flex w-7 h-7 items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors shrink-0"
                    aria-label="বন্ধ করুন">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
