@props(['openUp' => false])

<div
    x-data="{
        open: false,
        lang: 'bn',
        init() {
            this.lang = this.readLang();
        },
        readLang() {
            const match = document.cookie.match(/(?:^|;\s*)googtrans=([^;]+)/);
            return match && /\/en(?:$|\/)/.test(decodeURIComponent(match[1])) ? 'en' : 'bn';
        },
        switchLang(code) {
            if (code === this.lang) {
                this.open = false;
                return;
            }

            if (code === 'en') {
                document.cookie = 'googtrans=/bn/en;path=/';
            } else {
                document.cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
            }

            window.location.reload();
        },
        label() {
            return this.lang === 'en' ? 'English' : 'বাংলা';
        }
    }"
    class="relative z-[120] notranslate {{ $attributes->get('class') }}"
    @click.outside="open = false">
    <button
        type="button"
        x-ref="langBtn"
        @click="open = !open"
        class="flex items-center gap-1.5 px-2 py-1 text-slate-700 hover:text-primary transition-colors border border-slate-200 rounded-sm text-sm font-medium bg-white"
        :aria-expanded="open"
        aria-haspopup="listbox"
        aria-label="ভাষা নির্বাচন">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="2" y1="12" x2="22" y2="12"></line>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
        </svg>
        <span x-text="label()"></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0 transition-transform" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 {{ $openUp ? 'translate-y-1' : '-translate-y-1' }}"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 {{ $openUp ? 'translate-y-1' : '-translate-y-1' }}"
        class="absolute right-0 min-w-[9.5rem] bg-white border border-slate-200 shadow-xl z-[9999] py-1 rounded-sm {{ $openUp ? 'bottom-full mb-1.5' : 'top-full mt-1.5' }}"
        role="listbox"
        x-cloak>
        <button
            type="button"
            role="option"
            @click="switchLang('bn')"
            class="w-full text-left px-3 py-2 text-sm hover:bg-slate-50 transition-colors"
            :class="lang === 'bn' ? 'text-primary font-semibold' : 'text-slate-700'">
            বাংলা
        </button>
        <button
            type="button"
            role="option"
            @click="switchLang('en')"
            class="w-full text-left px-3 py-2 text-sm hover:bg-slate-50 transition-colors"
            :class="lang === 'en' ? 'text-primary font-semibold' : 'text-slate-700'">
            English
        </button>
    </div>
</div>