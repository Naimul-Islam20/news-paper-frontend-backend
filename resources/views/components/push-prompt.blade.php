<div
    id="push-prompt-root"
    class="hidden fixed inset-x-0 bottom-0 z-[110] p-3 sm:p-4 pointer-events-none"
    aria-hidden="true"
    role="dialog"
    aria-label="নোটিফিকেশন অনুরোধ"
    data-push-config-url="{{ route('push.config') }}"
    data-push-subscribe-url="{{ route('push.subscribe') }}"
    data-push-unsubscribe-url="{{ route('push.unsubscribe') }}">
    <div class="pointer-events-auto mx-auto max-w-lg rounded-xl border border-slate-200 bg-white shadow-2xl overflow-hidden">
        <div class="flex items-start gap-3 p-4">
            @if(!empty(optional($siteMeta)->site_icon))
            <img src="{{ storage_image_url($siteMeta->site_icon) }}" alt="" width="48" height="48" class="w-12 h-12 rounded-full object-contain bg-slate-50 shrink-0 border border-slate-100">
            @else
            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0 font-bold text-lg">
                {{ mb_substr(site_name_bn() ?: site_name(), 0, 1) }}
            </div>
            @endif
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-bold text-slate-900 leading-snug">{{ site_name_bn() ?: site_name() }}</p>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed">সর্বশেষ খবর পেতে নোটিফিকেশন চালু করবেন?</p>
            </div>
        </div>
        <div class="grid grid-cols-2 border-t border-slate-100">
            <button
                type="button"
                data-push-no
                class="py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors border-r border-slate-100">
                না
            </button>
            <button
                type="button"
                data-push-yes
                class="py-3 text-sm font-semibold text-primary hover:bg-primary/5 transition-colors">
                হ্যাঁ
            </button>
        </div>
    </div>
</div>
