<footer class="bg-white border-t border-black/10 text-black pt-16 pb-8">
    <div class="container overflow-visible px-4 md:px-0">
        <!-- Logo and App Links Row -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-8 mb-4 pb-4 border-b border-gray-300">
            <!-- Logo (Left) -->
            <a href="/" class="shrink-0 text-left">
                @if(!empty(optional($siteMeta)->site_logo))
                <img src="{{ storage_image_url($siteMeta->site_logo) }}" alt="{{ optional($siteMeta)->site_name ?? 'Logo' }}" class="h-14 md:h-20 w-auto object-contain" onerror="this.style.display='none'; this.nextElementSibling && this.nextElementSibling.classList.remove('hidden');">
                <h2 class="text-4xl md:text-5xl font-black serif tracking-tighter uppercase underline decoration-rose-500 underline-offset-8 decoration-4 hidden">
                    {{ optional($siteMeta)->site_name ?? 'দ্য ডেইলি নিউজ' }}
                </h2>
                @else
                <h2 class="text-4xl md:text-5xl font-black serif tracking-tighter uppercase underline decoration-rose-500 underline-offset-8 decoration-4">
                    {{ optional($siteMeta)->site_name ?? 'দ্য ডেইলি নিউজ' }}
                </h2>
                @endif
            </a>

            <!-- App Links (Right) -->
            <div class="flex flex-wrap justify-center md:justify-end gap-4">
                <a href="#" class="flex items-center gap-2 bg-black text-white px-6 py-2  hover:bg-slate-800 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.1 2.48-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.11-1.09-3.13-2.58C3.84 16.29 2.29 10.74 4.35 7.17c1.02-1.77 2.84-2.89 4.82-2.92 1.49-.03 2.9.99 3.81.99.9 0 2.59-1.21 4.38-1.03 1.62.06 2.85.65 3.6 1.47-3.17 1.89-2.66 6.32 1.05 8.16-.72 1.83-1.63 3.66-2.3 4.74M13 3.5c.81-1 1.35-2.4 1.2-3.5-1.04.05-2.29.74-3 1.62-.71.82-1.33 2.27-1.18 3.33 1.16.08 2.27-.61 2.98-1.45z"/></svg>
                    <div class="text-left leading-none">
                        <span class="text-[10px] uppercase font-bold text-slate-400">Download on the</span>
                        <div class="text-sm font-black">App Store</div>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-2 bg-black text-white px-6 py-2  hover:bg-slate-800 transition-all shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3 20.5V3.5C3 2.91 3.34 2.39 3.84 2.15L13.69 12L3.84 21.85C3.34 21.61 3 21.09 3 20.5M16.81 15.12L18.81 17.12C19.34 17.65 19.34 18.5 18.81 19.04C18.28 19.57 17.43 19.57 16.9 19.04L14.9 17.04L16.81 15.12M4.92 2L14.39 11.41L17.5 8.3L6.44 2.1C6.04 1.87 5.56 1.84 5.14 2.01L4.92 2M14.39 12.59L4.92 22L5.14 21.99C5.56 22.16 6.04 22.13 6.44 21.9L17.5 15.7L14.39 12.59Z"/></svg>
                    <div class="text-left leading-none">
                        <span class="text-[10px] uppercase font-bold text-slate-400">Get it on</span>
                        <div class="text-sm font-black">Google Play</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- 12-Column Grid for precise control -->
        <div class="grid grid-cols-2 md:grid-cols-12 gap-8 pt-4">
            <!-- Column 1: Info and Copyright (Span 3) -->
            <div class="col-span-2 md:col-span-3 space-y-6 md:border-r border-slate-200 md:pr-4">
                <div class="text-base font-md space-y-1">
                    @if(!empty(optional($siteMeta)->editor_name))
                    <p>সম্পাদক: {{ $siteMeta->editor_name }}</p>
                    @endif
                    @if(!empty(optional($siteMeta)->publisher_name))
                    <p>প্রকাশক: {{ $siteMeta->publisher_name }}</p>
                    @endif
                </div>
                @if(!empty(optional($siteMeta)->address_1))
                <div class="text-sm text-gray-900 leading-relaxed font-md prose prose-sm max-w-none">
                    {!! $siteMeta->address_1 !!}
                </div>
                @endif
                <p class="text-xs font-md text-gray-900 uppercase tracking-widest pt-4">
                    © প্রকাশক কর্তৃক সর্বস্বত্ব সংরক্ষিত
                </p>
            </div>

            <!-- Column 2: Category Links (Span 4) -->
            <div class="col-span-2 md:col-span-4 md:border-r border-slate-200 md:pr-4">
                @if(isset($footerCategories) && $footerCategories->isNotEmpty())
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-2 text-base font-semibold">
                    @foreach($footerCategories as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}" class="hover:text-rose-600 transition-colors">{{ $cat->name }}</a>
                    @endforeach
                </div>
                @else
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-4 gap-x-2 text-base font-semibold">
                    <a href="/gallery" class="hover:text-rose-600 transition-colors">ছবি</a>
                    <a href="/videos" class="hover:text-rose-600 transition-colors">ভিডিও</a>
                    <a href="/terms" class="hover:text-rose-600 transition-colors">শর্তাবলী</a>
                    <a href="/privacy-policy" class="hover:text-rose-600 transition-colors">গোপনীয়তা নীতি</a>
                </div>
                @endif
            </div>

            <!-- Column 3: Legal Links (Span 3) -->
            <div class="md:col-span-3 md:border-r border-slate-200 md:pr-4">
                <ul class="space-y-4 text-base font-semibold">
                    <li><a href="#" class="hover:text-rose-600 transition-colors">বিজ্ঞাপন</a></li>
                    <li><a href="#" class="hover:text-rose-600 transition-colors">যোগাযোগ</a></li>
                    <li><a href="/privacy-policy" class="hover:text-rose-600 transition-colors">গোপনীয়তা নীতি</a></li>
                    <li><a href="/terms" class="hover:text-rose-600 transition-colors">শর্তাবলী</a></li>
                </ul>
            </div>

            <!-- Column 4: Social Links (Span 2) -->
            <div class="md:col-span-2">
                <ul class="space-y-4 text-base font-semibold">
                    @if(!empty(optional($siteMeta)->facebook_link))
                    <li><a href="{{ $siteMeta->facebook_link }}" target="_blank" rel="noopener" class="hover:text-rose-600 transition-colors">Facebook</a></li>
                    @endif
                    @if(!empty(optional($siteMeta)->twitter_link))
                    <li><a href="{{ $siteMeta->twitter_link }}" target="_blank" rel="noopener" class="hover:text-rose-600 transition-colors">Twitter</a></li>
                    @endif
                    @if(!empty(optional($siteMeta)->instagram_link))
                    <li><a href="{{ $siteMeta->instagram_link }}" target="_blank" rel="noopener" class="hover:text-rose-600 transition-colors">Instagram</a></li>
                    @endif
                    @if(!empty(optional($siteMeta)->youtube_link))
                    <li><a href="{{ $siteMeta->youtube_link }}" target="_blank" rel="noopener" class="hover:text-rose-600 transition-colors">YouTube</a></li>
                    @endif
                    @if(!empty(optional($siteMeta)->extra_social_links) && is_array($siteMeta->extra_social_links))
                    @foreach($siteMeta->extra_social_links as $extraLink)
                    @if(!empty($extraLink))
                    <li><a href="{{ $extraLink }}" target="_blank" rel="noopener" class="hover:text-rose-600 transition-colors">লিংক</a></li>
                    @endif
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</footer>

