<footer class="bg-white border-t border-black/10 text-black pt-16 pb-8">
    <div class="container overflow-visible px-4 md:px-0">
        <!-- Logo + Email Subscribe Row -->
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

            <!-- Email Subscribe (Right, replacing app links) -->
            <div class="w-full md:w-auto md:max-w-sm flex-shrink-0">
                @if(session('subscribe_success'))
                <p class="text-sm text-green-600 font-medium mb-2">{{ session('subscribe_success') }}</p>
                @endif
                <form action="{{ route('frontend.subscribe') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" name="email" required placeholder="ইমেইল লিখুন" class="flex-1 min-w-[220px] px-4 py-2.5 border border-gray-300 bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-rose-500/30 focus:border-rose-500 text-sm">
                    <button type="submit" class="shrink-0 px-5 py-2.5 bg-black text-white font-semibold text-sm hover:bg-slate-800 transition-colors">
                        সাবস্ক্রাইব
                    </button>
                </form>
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

