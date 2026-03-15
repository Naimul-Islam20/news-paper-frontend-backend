<x-layout>
    <x-slot:title>{{ $video->category->name ?? $video->title }} - দ্য ডেইলি নিউজ</x-slot>

        <div class="py-4 md:py-10 min-h-screen bg-white">
            <div class="container">
                @php
                \Carbon\Carbon::setLocale('bn');
                // Extract YouTube video ID
                $youtubeId = null;
                if ($video->youtube_link) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->youtube_link, $matches);
                $youtubeId = $matches[1] ?? null;
                }
                $categoryName = $video->category->name ?? 'ভিডিও';
                @endphp

                <!-- Header + Breadcrumb -->
                <div class="mb-4 md:mb-10 text-left">
                    <h1 class="text-4xl md:text-3xl font-semibold serif text-title mb-3">
                        {{ $categoryName }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6">
                        <a href="/" class="text-slate-500 hover:text-rose-600 transition-all flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-black font-bold line-clamp-1">{{ $categoryName }}</span>
                    </div>

                    <div class="w-full border-b border-slate-300 relative mb-8">
                        <div class="absolute -bottom-[1px] left-0 w-40 h-[2px] bg-rose-600"></div>
                    </div>
                </div>

                <style>
                    .details-grid {
                        display: grid;
                        gap: 0.7rem;
                        grid-template-columns: 1fr;
                    }

                    @media (min-width: 1024px) {
                        .details-grid {
                            grid-template-columns: 9fr 3fr;
                        }
                    }
                </style>

                <section class="details-grid">

                    <!-- প্রথম কলাম -->
                    <div class="flex flex-col gap-6 w-full">
                        <h1 class="text-2xl md:text-4xl font-bold serif text-title leading-tight">
                            {{ $video->title }}
                        </h1>

                        <div class="flex flex-col gap-1 pb-2 mb-2">
                            <span class="text-lg font-bold text-title">{{ optional($video->reporter)->desk ?? optional($video->reporter)->name ?? 'ডিজিটাল ভিডিও ডেস্ক' }}</span>
                            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-3 gap-4">
                                <span class="text-sm md:text-base text-desc">
                                    প্রকাশ : {{ published_at($video->created_at) }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                                        class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-[#3b5998] hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if($video->description)
                        <div class="prose prose-lg max-w-none text-desc text-lg md:text-xl font-medium leading-relaxed">
                            {!! $video->description !!}
                        </div>
                        @endif

                        <!-- ভিডিও প্লেয়ার: থাম্বনেইল থাকলে উপরে দেখাবে, ক্লিকে ভিডিও চালু -->
                        @php
                        $videoThumbUrl = $video->image ? storage_image_url($video->image) : null;
                        $hasYoutube = (bool) $youtubeId;
                        @endphp
                        <div class="w-full bg-black aspect-video relative overflow-hidden shadow-2xl" id="video-player-wrap">
                            @if($hasYoutube && $videoThumbUrl)
                            {{-- ইউটিউব + কাস্টম থাম্বনেইল: থাম্বনেইল পোস্টার, ক্লিকে ইফ্রেম চালু --}}
                            <div id="video-poster" class="absolute inset-0 cursor-pointer flex items-center justify-center bg-black">
                                <img src="{{ $videoThumbUrl }}" alt="{{ $video->title }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 flex items-center justify-center bg-black/20 hover:bg-black/30 transition-colors">
                                    <div class="w-20 h-20 bg-rose-600/90 text-white rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <iframe id="video-iframe" src="about:blank" data-src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&rel=0" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full absolute inset-0 hidden"></iframe>
                            <script>
                                document.getElementById('video-poster').addEventListener('click', function() {
                                    var iframe = document.getElementById('video-iframe');
                                    iframe.src = iframe.getAttribute('data-src');
                                    iframe.classList.remove('hidden');
                                    this.classList.add('hidden');
                                });
                            </script>
                            @elseif($hasYoutube)
                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=0&rel=0" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full absolute inset-0"></iframe>
                            @elseif($video->image)
                            <div class="absolute inset-0 flex items-center justify-center">
                                <img src="{{ $videoThumbUrl }}" alt="{{ $video->title }}" class="w-full h-full object-cover opacity-60">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-20 h-20 bg-rose-600/90 text-white rounded-full flex items-center justify-center shadow-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gray-900">
                                <div class="text-white text-center">
                                    <div class="w-20 h-20 bg-rose-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm">ভিডিও লিঙ্ক পাওয়া যায়নি</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- দ্বিতীয় কলাম (৩ ভাগ) -->
                    <div class="flex flex-col gap-10 w-full">

                        @php $adSidebarList = ad_slot('sidebar_list'); @endphp
                        @if($adSidebarList && $adSidebarList->image)
                        <div class="w-full max-w-[280px] bg-slate-50 overflow-hidden border border-slate-100 shadow-sm">
                            <span class="text-[10px] uppercase font-bold text-slate-400 p-2 block text-center border-b border-slate-100">বিজ্ঞাপন</span>
                            <a href="{{ $adSidebarList->link ?? '#' }}" class="block hover:opacity-95 transition-opacity" target="_blank" rel="noopener">
                                <div class="img-placeholder w-full aspect-[4/3] overflow-hidden">
                                    <img src="{{ storage_image_url($adSidebarList->image) }}" alt="{{ $adSidebarList->caption ?? 'বিজ্ঞাপন' }}" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                </div>
                            </a>
                        </div>
                        @endif

                        <!-- আরও ভিডিও (সাইডবার) -->
                        @if($related->isNotEmpty())
                        <div class="flex flex-col gap-6">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-2">
                                <div class="w-1.5 h-6 bg-rose-600"></div>
                                <h3 class="text-xl font-bold serif text-title">আরও ভিডিও</h3>
                            </div>
                            @foreach($related->take(2) as $rel)
                            @php
                            $relYoutubeId = null;
                            if ($rel->youtube_link) {
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $rel->youtube_link, $relMatches);
                            $relYoutubeId = $relMatches[1] ?? null;
                            }
                            $relThumb = $relYoutubeId
                            ? "https://img.youtube.com/vi/{$relYoutubeId}/mqdefault.jpg"
                            : ($rel->image ? storage_image_url($rel->image) : 'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=400');
                            @endphp
                            <a href="{{ route('videos.show', $rel->slug) }}" class="group flex flex-col gap-2">
                                <div class="relative aspect-video overflow-hidden">
                                    <img src="{{ $relThumb }}"
                                        alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                        <div class="w-8 h-8 bg-black/60 text-white rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-sm md:text-base font-bold text-title group-hover:text-rose-600">
                                    {{ Str::limit($rel->title, 80) }}
                                </h4>
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
</x-layout>