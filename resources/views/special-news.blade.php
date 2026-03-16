<x-layout>
    <x-slot:title>বিশেষ সংবাদ - দ্য ডেইলি নিউজ</x-slot>

        <div class="py-4 md:py-10 min-h-screen">
            <div class="container">
                @php
                $categoryName = "বিশেষ সংবাদ";
                @endphp
                <!-- Category Header -->
                <div class="mb-10 text-left">
                    <h1 class="text-2xl md:text-3xl font-bold serif text-title mb-4">{{ $categoryName }}</h1>

                    <div class="flex items-center gap-1 text-sm font-bold text-slate-500 mb-6">
                        <!-- Home Icon -->
                        <a href="/" class="text-slate-500 hover:text-rose-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-black font-bold">{{ $categoryName }}</span>
                    </div>

                    <div class="w-full border-b border-slate-300 relative mb-8">
                        <div class="absolute -bottom-[1px] left-0 w-40 h-[2px] bg-rose-600"></div>
                    </div>
                </div>

                <style>
                    .special-grid {
                        display: grid;
                        gap: 0rem;
                        grid-template-columns: 1fr;
                    }

                    @media (min-width: 768px) {
                        .special-grid {
                            grid-template-columns: 9.1fr 2.9fr;
                        }
                    }

                    .national-grid {
                        display: grid;
                        gap: 0rem;
                        grid-template-columns: 1fr;
                    }

                    @media (min-width: 768px) {
                        .national-grid {
                            grid-template-columns: 1.7fr 7.4fr 2.9fr;
                        }
                    }
                </style>

                <section class="special-grid">
                    <!-- বাম কলাম: সংবাদ তালিকা (9.1) -->
                    @php
                    \Carbon\Carbon::setLocale('bn');
                    @endphp

                    <div class="bg-white flex flex-col gap-0 md:border-r md:border-slate-200 pr-0 md:pr-3">

                        @if(isset($posts) && $posts->count() > 0)
                        @php $featured = $posts->first(); @endphp
                        {{-- প্রধান নিউজ কার্ড (Featured Article) – নতুন প্রথমে --}}
                        <article class="flex flex-col-reverse md:flex-row gap-3 pb-3 last:border-0 text-left border-b border-gray-100">
                            <div class="flex flex-col justify-start gap-3 flex-1">
                                <a href="{{ url('/news/' . $featured->slug) }}">
                                    <h3 class="text-2xl md:text-3xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors">
                                        <span style="color: red !important;">{{ $categoryName }} /</span> {{ $featured->title }}
                                    </h3>
                                </a>
                                <p class="text-base font-semibold text-desc leading-relaxed line-clamp-4">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($featured->description), 280) !!}
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    <span class="text-xs font-medium">{{ $featured->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 group overflow-hidden w-full md:w-auto">
                                <a href="{{ url('/news/' . $featured->slug) }}">
                                    <div class="img-placeholder w-full aspect-video md:aspect-auto md:w-[625px] md:h-[355px]">
                                        <img
                                            src="{{ Storage::url($featured->image) }}"
                                            alt="{{ $featured->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                </a>
                            </div>
                        </article>

                        {{-- পরবর্তী ৩টা পোস্ট গ্রিড --}}
                        @php $gridPosts = $posts->slice(1, 3); @endphp
                        @if($gridPosts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-0 pt-3">
                            @foreach($gridPosts as $index => $post)
                            <article class="flex flex-row-reverse md:flex-col gap-2 md:gap-3 pb-4 border-b border-gray-100 md:border-b-0 md:pb-0 {{ $index < 2 ? 'md:pr-3 md:border-r md:border-slate-200' : 'md:pl-3' }}">
                                <a href="{{ url('/news/' . $post->slug) }}" class="group overflow-hidden shrink-0">
                                    <div class="img-placeholder w-36 h-24 md:w-full md:h-[180px]"><img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')"></div>
                                </a>
                                <div class="flex flex-col gap-1 flex-1">
                                    <a href="{{ url('/news/' . $post->slug) }}">
                                        <h4 class="text-base md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">{{ $post->title }}</h4>
                                    </a>
                                    <p class="text-sm md:text-base font-medium text-desc leading-relaxed line-clamp-2 md:line-clamp-3">{!! \Illuminate\Support\Str::limit(strip_tags($post->description), 120) !!}</p>
                                    <div class="flex items-center gap-1.5 mt-1 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                        <span class="text-[10px] md:text-xs font-medium">{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                        @endif
                        @if($posts->hasPages())
                        <div class="mt-6 flex justify-center">{{ $posts->links() }}</div>
                        @endif
                        @else
                        <p class="py-10 text-center text-slate-500">কোন বিশেষ সংবাদ নেই।</p>
                        @endif
                    </div>

                    <!-- ডান কলাম: সর্বশেষ / পঠিত ট্যাব -->
                    <div class="flex flex-col pl-0 md:pl-3 mt-4 md:mt-0">

                        <!-- Tab Bar -->
                        <div class="flex w-full border-b border-gray-200 mb-4 px-4 md:px-0">
                            <button id="sp-tab-latest" onclick="switchSpTab('latest')" class="flex-1 text-lg font-bold py-2 border-b-2 border-rose-600 text-rose-600 -mb-px transition-all duration-200 text-center">
                                সর্বশেষ
                            </button>
                            <button id="sp-tab-popular" onclick="switchSpTab('popular')" class="flex-1 text-lg font-bold py-2 border-b-2 border-transparent text-gray-400 -mb-px hover:text-gray-600 transition-all duration-200 text-center">
                                পঠিত
                            </button>
                        </div>

                        <!-- সর্বশেষ Panel -->
                        <div id="sp-panel-latest" class="space-y-4">
                            @forelse(isset($latestSidebarPosts) ? $latestSidebarPosts : [] as $index => $post)
                            @php $bn = ['১','২','৩','৪','৫','৬']; $num = $bn[$index] ?? ($index + 1); @endphp
                            <a href="{{ url('/news/' . $post->slug) }}" class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0 block">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">{{ $num }}.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">{{ $post->title }}</h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm" style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            </a>
                            @empty
                            <p class="text-slate-500 text-sm">কোন সংবাদ নেই।</p>
                            @endforelse
                        </div>

                        <!-- পঠিত Panel (hidden by default) -->
                        <div id="sp-panel-popular" class="space-y-4 hidden">
                            @forelse(isset($popularSidebarPosts) ? $popularSidebarPosts : [] as $index => $post)
                            @php $bn = ['১','২','৩','৪','৫','৬']; $num = $bn[$index] ?? ($index + 1); @endphp
                            <a href="{{ url('/news/' . $post->slug) }}" class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100 last:border-0 last:pb-0 block">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">{{ $num }}.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">{{ $post->title }}</h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm" style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            </a>
                            @empty
                            <p class="text-slate-500 text-sm">কোন সংবাদ নেই।</p>
                            @endforelse
                        </div>


                        <!-- কমন আরও বাটন -->
                        <div class="pt-4">
                            <a href="#" style="display:block; width:100%; text-align:center; background-color:#dc2626; color:white; font-weight:700; font-size:0.875rem; padding:0.5rem 0; border-radius:4px;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='#dc2626'">
                                আরও →
                            </a>
                        </div>

                        <script>
                            function switchSpTab(tab) {
                                document.getElementById('sp-panel-latest').classList.toggle('hidden', tab !== 'latest');
                                document.getElementById('sp-panel-popular').classList.toggle('hidden', tab !== 'popular');
                                document.getElementById('sp-tab-latest').className = 'flex-1 text-lg font-bold py-2 border-b-2 -mb-px transition-all duration-200 text-center ' + (tab === 'latest' ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-400 hover:text-gray-600');
                                document.getElementById('sp-tab-popular').className = 'flex-1 text-lg font-bold py-2 border-b-2 -mb-px transition-all duration-200 text-center ' + (tab === 'popular' ? 'border-rose-600 text-rose-600' : 'border-transparent text-gray-400 hover:text-gray-600');
                            }
                        </script>

                    </div>
                </section>

                <!-- Section: National Page Style (Exact Copy) -->
                <section class="national-grid mt-6 md:mt-12 pt-3 md:pt-12 border-t border-slate-200">
                    <!-- প্রথম কলাম: সরু -->
                    <div class="p-4">
                        {{-- কন্টেন্ট আপাতত খালি --}}
                    </div>

                    <!-- মাঝের কলাম: উপরের ৪টার পর বাকি বিশেষ সংবাদ – নতুন এড হলে উপরে যাবে, উপর থেকে বের হলে এখানে আসবে -->
                    @php
                        $belowPosts = isset($posts) && $posts->count() > 4
                            ? collect($posts->items())->slice(4)->values()
                            : collect();
                    @endphp

                    <div class="bg-white px-0 md:p-4 flex flex-col gap-0">

                        @if($belowPosts->count() > 0)
                            @foreach($belowPosts as $post)
                                <article class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 py-3 md:py-4 border-b border-gray-100 last:border-0">
                                    <a href="{{ url('/news/' . $post->slug) }}" class="flex-shrink-0">
                                        <div class="img-placeholder w-36 h-24 md:w-[305px] md:h-[170px]"><img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')"></div>
                                    </a>
                                    <div class="flex flex-col justify-start gap-1 md:gap-2 pt-0 md:pt-1 md:px-0 flex-1">
                                        <a href="{{ url('/news/' . $post->slug) }}">
                                            <h3 class="text-lg md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">{{ $post->title }}</h3>
                                        </a>
                                        <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">{!! \Illuminate\Support\Str::limit(strip_tags($post->description), 180) !!}</p>
                                        <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                            <span class="text-[10px] md:text-xs font-medium text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @else
                            {{-- নিচের কলামে ডাটা নেই – সkeleton --}}
                            @for($i = 0; $i < 4; $i++)
                                <div class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 py-3 md:py-4 border-b border-gray-100 last:border-0">
                                    <div class="skeleton flex-shrink-0 w-36 h-24 md:w-[305px] md:h-[170px] rounded"></div>
                                    <div class="flex-1 space-y-2">
                                        <div class="skeleton h-5 w-full rounded"></div>
                                        <div class="skeleton h-4 w-full rounded hidden md:block"></div>
                                        <div class="skeleton h-4 w-4/5 rounded hidden md:block"></div>
                                        <div class="skeleton h-3 w-24 rounded mt-2"></div>
                                    </div>
                                </div>
                            @endfor
                        @endif

                    </div>

                    <!-- ডান পাশের কলাম: বিজ্ঞাপন -->
                    <div class="flex flex-col gap-4">

                        {{-- বিজ্ঞাপন লেবেল --}}
                        <div class="flex items-center gap-2 mb-1">
                            <div class="h-px flex-1 bg-slate-200"></div>
                            <span class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">বিজ্ঞাপন</span>
                            <div class="h-px flex-1 bg-slate-200"></div>
                        </div>

                        {{-- বিজ্ঞাপন ১: বড় ব্যানার --}}
                        <a href="#" class="block overflow-hidden border border-slate-200 shadow-sm transition-all group relative">
                            <div class="relative h-[250px] w-full overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&auto=format&fit=crop&q=80"
                                    alt="বিজ্ঞাপন"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-center">
                                    <p class="text-white font-bold text-base leading-tight mb-2">আপনার ব্যবসার প্রসারে<br>আমাদের সাথে যোগ দিন</p>
                                    <span class="inline-block px-4 py-1.5 bg-rose-600 text-white text-xs font-bold hover:bg-rose-700 transition-colors">বিজ্ঞাপন দিন →</span>
                                </div>
                            </div>
                        </a>

                        {{-- বিজ্ঞাপন ২: মাঝারি ব্যানার --}}
                        <a href="#" class="block overflow-hidden border border-slate-200 shadow-sm transition-all group relative mt-4">
                            <div class="relative h-[180px] w-full overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=600&auto=format&fit=crop&q=80"
                                    alt="স্পনসরড"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3 text-center">
                                    <p class="text-white font-bold text-sm mb-1">স্পনসরড পোস্ট</p>
                                    <p class="text-gray-200 text-[11px] mb-2">সবচেয়ে কম মূল্যে আপনার পণ্য প্রচার করুন</p>
                                    <span class="inline-block px-3 py-1 bg-white/20 border border-white/40 text-white text-[10px] font-bold backdrop-blur-sm">বিস্তারিত দেখুন</span>
                                </div>
                            </div>
                        </a>

                    </div>
                </section>
            </div>
        </div>
</x-layout>