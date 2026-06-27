<div
    x-data="{
        lang: 'bn',
        init() {
            this.lang = this.readLang();
        },
        readLang() {
            try {
                const pref = localStorage.getItem('site_lang');
                if (pref === 'bn' || pref === 'en') {
                    return pref;
                }
            } catch (e) {}

            if (document.documentElement.classList.contains('translated-ltr')) {
                return 'en';
            }

            const match = document.cookie.match(/(?:^|;\s*)googtrans=([^;]+)/);
            return match && /\/en(?:$|\/)/.test(decodeURIComponent(match[1])) ? 'en' : 'bn';
        },
        switchLang(code) {
            const helpers = window.__siteLangHelpers;
            if (helpers) {
                helpers.writePref(code);
            } else {
                try {
                    localStorage.setItem('site_lang', code);
                } catch (e) {}
            }

            if (code === 'en') {
                if (helpers) {
                    helpers.setGoogTransEnglish();
                } else {
                    document.cookie = 'googtrans=/bn/en;path=/;SameSite=Lax';
                }
            } else {
                if (helpers) {
                    helpers.clearGoogTrans();
                } else {
                    document.cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
                }
                document.documentElement.classList.remove('translated-ltr');
                document.documentElement.lang = 'bn';
            }

            window.location.reload();
        },
        toggleLang() {
            this.switchLang(this.lang === 'bn' ? 'en' : 'bn');
        },
        label() {
            return this.lang === 'bn' ? 'English' : 'বাংলা';
        }
    }"
    class="inline notranslate">
    <button
        type="button"
        @click="toggleLang()"
        {{ $attributes->merge(['class' => 'inline p-0 m-0 bg-transparent border-0 font-normal text-inherit hover:text-primary transition-colors cursor-pointer']) }}
        :aria-label="lang === 'bn' ? 'Switch to English' : 'বাংলায় ফিরুন'">
        <span x-text="label()"></span>
    </button>
</div>