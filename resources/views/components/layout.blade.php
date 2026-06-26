<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        (function() {
            var STORAGE_KEY = 'site_lang';

            function readPref() {
                try {
                    return localStorage.getItem(STORAGE_KEY);
                } catch (e) {
                    return null;
                }
            }

            function writePref(code) {
                try {
                    localStorage.setItem(STORAGE_KEY, code);
                } catch (e) {}
            }

            function cookieValue(name) {
                var match = document.cookie.match(new RegExp('(?:^|;\\s*)' + name + '=([^;]+)'));
                return match ? decodeURIComponent(match[1]) : '';
            }

            function isEnglishGoogTrans(value) {
                return value !== '' && /\/en(?:$|\/)/.test(value);
            }

            function clearGoogTrans() {
                var host = location.hostname;
                var domains = [''];
                if (host) {
                    domains.push(host);
                    var parts = host.split('.');
                    if (parts.length > 2) {
                        domains.push('.' + parts.slice(-2).join('.'));
                    }
                }

                domains.forEach(function(domain) {
                    var cookie = 'googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT';
                    if (domain) {
                        cookie += ';domain=' + domain;
                    }
                    document.cookie = cookie;
                });
            }

            function setGoogTransEnglish() {
                document.cookie = 'googtrans=/bn/en;path=/;SameSite=Lax';
            }

            window.__siteLangHelpers = {
                storageKey: STORAGE_KEY,
                clearGoogTrans: clearGoogTrans,
                setGoogTransEnglish: setGoogTransEnglish,
                writePref: writePref,
            };

            var pref = readPref();
            var googVal = cookieValue('googtrans');
            var wantsEnglish = pref === 'en';

            if (pref === 'bn' || pref === null) {
                clearGoogTrans();
                if (pref === null) {
                    writePref('bn');
                }
                wantsEnglish = false;
            } else if (!wantsEnglish && isEnglishGoogTrans(googVal)) {
                clearGoogTrans();
            } else if (wantsEnglish) {
                setGoogTransEnglish();
            }

            if (wantsEnglish) {
                document.documentElement.classList.add('site-lang-en');
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('[data-placeholder-en]').forEach(function(el) {
                        el.placeholder = el.getAttribute('data-placeholder-en');
                    });
                });
            }

            window.__siteLangEn = wantsEnglish;
        })();
    </script>
    <style>
        html .i18n-en {
            display: none !important;
        }

        html.site-lang-en .i18n-bn {
            display: none !important;
        }

        html.site-lang-en .i18n-en {
            display: inline !important;
        }
    </style>
    <script>
        (function() {
            function forceVisible() {
                document.documentElement.classList.remove('lang-pending-en');
                if (document.body) {
                    document.body.style.setProperty('visibility', 'visible', 'important');
                }
            }
            forceVisible();
            document.addEventListener('DOMContentLoaded', forceVisible);
            window.addEventListener('load', forceVisible);
            setTimeout(forceVisible, 1500);
        })();
    </script>
    <x-font-preload />
    <title>{{ $title ?? site_browser_title() }}</title>
    @if(!empty(optional($siteMeta)->site_keywords))
    <meta name="keywords" content="{{ $siteMeta->site_keywords }}">
    @endif
    @if(!empty(optional($siteMeta)->site_description) && ! isset($ogTitle))
    <meta name="description" content="{{ $siteMeta->site_description }}">
    @endif
    @if(!empty(optional($siteMeta)->site_icon))
    <link rel="icon" href="{{ storage_image_url($siteMeta->site_icon) }}" type="image/png">
    @endif

    {{-- Open Graph & Twitter Card: শেয়ার প্রিভিউ — ইমেজ + টাইটেল + site domain --}}
    @php
    $hasShareMeta = (isset($metaImage) && $metaImage !== '') || isset($ogTitle);
    $shareTitle = $ogTitle ?? $title ?? site_name();
    $sharePageUrl = isset($shareUrl) && trim((string) $shareUrl) !== '' ? trim((string) $shareUrl) : url()->current();
    $shareSiteLabel = share_site_label($sharePageUrl);
    @endphp
    @if($hasShareMeta)
    <link rel="canonical" href="{{ $sharePageUrl }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $sharePageUrl }}">
    <meta property="og:title" content="{{ $shareTitle }}">
    @if($shareSiteLabel !== '')
    <meta property="og:description" content="{{ $shareSiteLabel }}">
    @endif
    @if(isset($metaImage) && trim($metaImage) !== '')
    @php
    $shareImageUrl = trim($metaImage);
    $shareImageUrl = (str_starts_with($shareImageUrl, 'http://') || str_starts_with($shareImageUrl, 'https://')) ? $shareImageUrl : url($shareImageUrl);
    $shareImageUrlHttps = str_replace('http://', 'https://', $shareImageUrl);
    @endphp
    <meta property="og:image" content="{{ $shareImageUrlHttps }}">
    <meta property="og:image:secure_url" content="{{ $shareImageUrlHttps }}">
    <meta name="twitter:image" content="{{ $shareImageUrlHttps }}">
    @endif
    <meta property="og:site_name" content="{{ site_name() }}">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $shareTitle }}">
    @if($shareSiteLabel !== '')
    <meta name="twitter:description" content="{{ $shareSiteLabel }}">
    @endif
    @else
    {{-- সাধারণ পেজ: শেয়ার করলে সাইটের ডিফল্ট --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? site_name() }}">
    @if(!empty(optional($siteMeta)->site_description))
    <meta property="og:description" content="{{ $siteMeta->site_description }}">
    @endif
    @if(!empty(optional($siteMeta)->site_logo))
    <meta property="og:image" content="{{ storage_image_url($siteMeta->site_logo) }}">
    @endif
    <meta property="og:site_name" content="{{ site_name() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $title ?? site_name() }}">
    @if(!empty(optional($siteMeta)->site_description))
    <meta name="twitter:description" content="{{ $siteMeta->site_description }}">
    @endif
    @if(!empty(optional($siteMeta)->site_logo))
    <meta name="twitter:image" content="{{ storage_image_url($siteMeta->site_logo) }}">
    @endif
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
    $__primary = optional($siteMeta)->primary_color ?? null;
    $__primaryOk = is_string($__primary) && preg_match('/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/', $__primary);
    @endphp
    @if ($__primaryOk)
    <style>
        :root {
            --color-primary: {
                    {
                    $__primary
                }
            }

            !important;
            --site-name: "{{ site_name() }}";
        }
    </style>
    @else
    <style>
        :root {
            --site-name: "{{ site_name() }}";
        }
    </style>
    @endif
</head>

<body class="antialiased text-slate-900 overflow-x-hidden">

    <div id="google_translate_element" class="hidden" aria-hidden="true"></div>

    <script>
        (function() {
            if (!window.__siteLangEn) {
                return;
            }

            window.googleTranslateElementInit = function() {
                new google.translate.TranslateElement({
                    pageLanguage: 'bn',
                    includedLanguages: 'bn,en',
                    autoDisplay: false,
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                }, 'google_translate_element');
            };

            var script = document.createElement('script');
            script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
            document.head.appendChild(script);
        })();
    </script>

    <x-header />

    <main id="main-content" class="pb-4 md:pb-6 pt-0">
        {{ $slot }}
    </main>

    <x-footer />

    <!-- Global Scroll to Top Button -->
    <button id="globalScrollToTopBtn"
        style="position: fixed; bottom: 30px; right: 30px; z-index: 999999; width: 50px; height: 50px; background-color: #ffffff; color: #000000; border: none; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 2px 10px rgba(0,0,0,0.1); transition: all 0.3s ease; outline: none;"
        onclick="scrollToTopGlobal()"
        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)';"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.1)';">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>

    <script>
        // Show/hide logic
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('globalScrollToTopBtn');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.style.display = 'flex';
                    btn.style.opacity = '1';
                    btn.style.transform = 'translateY(0)';
                } else {
                    // Keep it flex but transparent if we want transition, 
                    // or just none for simplicity
                    btn.style.opacity = '0';
                    btn.style.transform = 'translateY(20px)';
                    // Optional: hide after transition
                    setTimeout(() => {
                        if (window.scrollY <= 300) btn.style.display = 'none';
                    }, 300);
                }
            }
        });

        function syncMainHeaderOffset() {
            const shell = document.getElementById('site-header-shell');
            const main = document.getElementById('main-content');
            if (!shell || !main) return;
            if (window.matchMedia('(min-width: 768px)').matches) {
                main.style.paddingTop = '';
            } else {
                const extraGap = 12;
                main.style.paddingTop = shell.offsetHeight + extraGap + 'px';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('globalScrollToTopBtn');
            if (btn) {
                btn.style.display = 'none';
                btn.style.opacity = '0';
            }

            syncMainHeaderOffset();
            window.addEventListener('resize', syncMainHeaderOffset);
            const shell = document.getElementById('site-header-shell');
            if (shell && typeof ResizeObserver !== 'undefined') {
                new ResizeObserver(syncMainHeaderOffset).observe(shell);
            }
            window.addEventListener('load', syncMainHeaderOffset);
        });

        function scrollToTopGlobal() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function shareOnMessenger(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('data-share-url');
            if (!url) return;

            const encoded = encodeURIComponent(url);
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

            if (isMobile) {
                window.location.href = 'fb-messenger://share/?link=' + encoded;
                return;
            }

            window.open(
                'https://www.facebook.com/dialog/send?link=' + encoded + '&redirect_uri=' + encoded + '&display=popup',
                'messenger-share-dialog',
                'width=600,height=520,scrollbars=yes'
            );
        }
    </script>

    <script>
        if (!window.__siteLangEn) {
            document.documentElement.classList.remove('translated-ltr');
            document.documentElement.lang = 'bn';
        }
    </script>
    @stack('scripts')
</body>

</html>