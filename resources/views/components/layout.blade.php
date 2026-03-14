<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? (optional($siteMeta)->site_title ?? optional($siteMeta)->site_name ?? 'The Daily News') }}</title>
        @if(!empty(optional($siteMeta)->site_keywords))
        <meta name="keywords" content="{{ $siteMeta->site_keywords }}">
        @endif
        @if(!empty(optional($siteMeta)->site_description))
        <meta name="description" content="{{ $siteMeta->site_description }}">
        @endif
        @if(!empty(optional($siteMeta)->site_icon))
        <link rel="icon" href="{{ storage_image_url($siteMeta->site_icon) }}" type="image/png">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased text-slate-900 overflow-x-hidden">
        
        <x-header />

        <main class="pt-[110px] md:pt-6 pb-12">
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
                            if(window.scrollY <= 300) btn.style.display = 'none';
                        }, 300);
                    }
                }
            });

            // Initial state
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('globalScrollToTopBtn');
                if (btn) {
                    btn.style.display = 'none';
                    btn.style.opacity = '0';
                }
            });

            function scrollToTopGlobal() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        </script>
    </body>
</html>

