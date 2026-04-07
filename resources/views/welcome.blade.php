<x-layout>
    <x-slot:title>
        {{ optional($siteMeta)->site_title ?? optional($siteMeta)->site_name ?? 'দ্য ডেইলি নিউজ | প্রিমিয়াম নিউজপেপার সাইট' }}
        </x-slot>

        @php $adBelowMenu = ad_slot('below_menu'); @endphp
        @if($adBelowMenu && $adBelowMenu->image)
        <div class="py-4 md:py-8 flex justify-center bg-transparent px-0 md:px-4">
            <div class="container flex justify-center overflow-hidden">
                <a href="{{ $adBelowMenu->link ?? '#' }}" class="w-full flex justify-center max-w-[1000px] mx-auto" target="_blank" rel="noopener">
                    <div class="img-placeholder w-full max-w-[1000px] h-[90px] md:h-[100px] overflow-hidden shrink-0">
                        <img src="{{ storage_image_url($adBelowMenu->image) }}"
                            alt="{{ $adBelowMenu->caption ?? 'Advertisement' }}"
                            class="w-full h-full object-cover object-center shadow-sm"
                            onload="this.parentElement.classList.remove('img-placeholder')">
                    </div>
                </a>
            </div>
        </div>
        @endif

        <div class="container">
            <!-- Hero Section -->
            <section class="flex flex-col lg:grid lg:grid-cols-[2.7fr_6.3fr_3fr] gap-6 lg:gap-3 mb-8 border-b border-custom pb-8">
                <!-- Left Column: Top Stories (Order 2 on mobile, Order 1 on Desktop) -->
                <!-- Left Column: Top Stories (Order 2 on mobile, Order 1 on Desktop) -->
                <div class="lg:border-r border-custom lg:pr-3 text-left order-2 lg:order-1">
                    @forelse($hero_layer_4_posts as $index => $post)
                    <a
                        href="{{ news_url($post) }}"
                        class="block group mb-3 lg:mb-2 cursor-pointer text-left lg:pt-0 lg:pb-1{{ $index > 0 ? ' border-t border-custom pt-5' : '' }}">
                        <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden">
                            @if($post->image)
                            <img
                                src="{{ Storage::url($post->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onload="this.parentElement.classList.remove('img-placeholder')">
                            @endif
                        </div>
                        <h4 class="text-xl lg:text-2xl font-semibold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                            {{ $post->title }}
                        </h4>
                        @php
                        $excerpt = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($post->description)), 100);
                        @endphp
                        @if($excerpt)
                        <p class="text-sm md:text-base font-normal text-desc leading-relaxed line-clamp-2 mt-1 text-left">
                            {!! $excerpt !!}
                        </p>
                        @endif
                    </a>
                    @empty
                    {{-- hero_layer_1_posts খালি থাকলে চাইলে আগের demo card এখানে রাখো --}}
                    @endforelse
                </div>

                <!-- Center: Featured News (Order 1 on mobile, Order 2 on Desktop) -->
                <div class="order-1 lg:order-2 px-0 lg:px-0">
                    {{-- 1st layer: বড় মেইন লিড --}}
                    @php $lead = $hero_layer_1_posts->first(); @endphp
                    @if($lead)
                    <a
                        href="{{ news_url($lead) }}"
                        class="block group cursor-pointer">
                        <div class="img-placeholder relative overflow-hidden aspect-[16/9] mb-4">
                            @if($lead->image)
                            <img
                                src="{{ Storage::url($lead->image) }}"
                                alt="{{ $lead->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                onload="this.parentElement.classList.remove('img-placeholder')">
                            @endif
                        </div>
                        <div class="text-center">
                            <h2 class="text-xl md:text-2xl font-semibold serif leading-tight text-center text-title group-hover:text-rose-600 transition-colors">
                                {{ $lead->title }}
                            </h2>
                            @php
                            $leadExcerpt = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($lead->description)), 100);
                            @endphp
                            @if($leadExcerpt)
                            <p class="text-sm md:text-base text-desc leading-relaxed mt-1 mb-4 text-center line-clamp-2 font-normal px-6 md:px-0 max-w-[340px] md:max-w-none mx-auto">
                                {!! $leadExcerpt !!}
                            </p>
                            @endif
                        </div>
                    </a>
                    @endif

                    {{-- 2nd layer: মাঝের গ্রিডের ২টা আইটেম --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4 pt-4 border-t border-custom">
                        @foreach($hero_layer_2_posts->take(2) as $post)
                        <a
                            href="{{ news_url($post) }}"
                            class="block group cursor-pointer{{ !$loop->first ? ' mt-4 md:mt-0' : '' }}">
                            <div class="img-placeholder overflow-hidden aspect-video mb-3">
                                @if($post->image)
                                <img
                                    src="{{ Storage::url($post->image) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onload="this.parentElement.classList.remove('img-placeholder')">
                                @endif
                            </div>
                            <h3 class="text-base md:text-lg font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left">
                                {{ $post->title }}
                            </h3>
                        </a>
                        @endforeach
                    </div>

                    {{-- 3rd layer: নিচের ২টা full-width আইটেম --}}
                    @foreach($hero_layer_3_posts->take(2) as $post)
                    <a
                        href="{{ news_url($post) }}"
                        class="block group cursor-pointer mt-5 pt-5 border-t border-custom">
                        <div class="img-placeholder overflow-hidden aspect-video mb-3 md:hidden">
                            @if($post->image)
                            <img
                                src="{{ Storage::url($post->image) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                onload="this.parentElement.classList.remove('img-placeholder')">
                            @endif
                        </div>
                        <h3 class="text-lg md:text-xl font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left mb-2">
                            {{ $post->title }}
                        </h3>
                        @php
                        $thirdExcerpt = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($post->description)), 130);
                        @endphp
                        @if($thirdExcerpt)
                        <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-2">
                            {!! $thirdExcerpt !!}
                        </p>
                        @endif
                    </a>
                    @endforeach


                </div>

                <!-- Right: উপরে ১ অ্যাড, মাঝে মিনি সেকশন, নিচে ১ অ্যাড -->
                <div class="md:border-l border-custom px-0 md:pl-3 md:px-0 text-left order-3 lg:order-3 flex flex-col h-full min-h-0">
                    @php
                    $adHeroRight1 = ad_slot('hero_right_1');
                    $adHeroRight2 = ad_slot('hero_right_2');
                    @endphp
                    @if($adHeroRight1 && $adHeroRight1->image)
                    <div class="shrink-0 mb-4 flex justify-center md:justify-start">
                        <a href="{{ $adHeroRight1->link ?? '#' }}" target="_blank" rel="noopener" class="block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/3] w-full max-w-[280px]">
                            <img src="{{ storage_image_url($adHeroRight1->image) }}" alt="{{ $adHeroRight1->caption ?? 'বিজ্ঞাপন' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" onload="this.parentElement.classList.remove('img-placeholder')">
                        </a>
                    </div>
                    @endif

                    <!-- Opinion / Mini Section (মাঝখানে) -->
                    <div class="flex-1 flex flex-col justify-center min-h-0 py-2">
                        <div class="space-y-4 w-full">
                            @forelse($mini_posts as $post)
                            <div class="group cursor-pointer{{ !$loop->first ? ' pt-4 border-t border-custom' : '' }}">
                                <a
                                    href="{{ news_url($post) }}"
                                    class="flex items-center gap-3 mb-2">
                                    <div class="img-placeholder w-15 h-15 overflow-hidden shrink-0">
                                        @if($post->image)
                                        <img
                                            src="{{ Storage::url($post->image) }}"
                                            alt="{{ $post->title }}"
                                            class="w-full h-full object-cover"
                                            onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                        {{ $post->title }}
                                    </h4>
                                </a>
                                @if(optional($post->reporter)->desk || optional($post->reporter)->name)
                                <div class="flex items-center gap-1.5 pt-1">
                                    <svg class="w-3.5 h-3.5 hidden md:block text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-[12px] hidden md:block text-desc font-bold text-left ml-0 leading-none">
                                        {{ $post->reporter->desk ?? $post->reporter->name }}
                                    </span>
                                </div>
                                @endif
                            </div>
                            @empty
                            <!-- Fallback: original columnist cards when no mini posts -->
                            <!-- Columnist 1 -->
                            <div class="group cursor-pointer">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                    <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                        পুলিশ ব্যবস্থার বর্তমান বাস্তবতা ও ভবিষ্যৎ পথরেখা
                                    </h4>
                                </div>
                                <div class="flex items-center gap-1.5 pt-1">
                                    <svg class="w-3.5 h-3.5 hidden md:block text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-[12px] hidden md:block text-desc font-bold text-left ml-0 leading-none">ড. মো. রুহুল আমিন সরকার</span>
                                </div>
                            </div>

                            <!-- Columnist 2 -->
                            <div class="group cursor-pointer pt-4 border-t border-custom">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                    <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                        উচ্চশিক্ষার মানোন্নয়ন ও আগামীর চ্যালেঞ্জ
                                    </h4>
                                </div>
                                <div class="flex items-center gap-1.5 pt-1">
                                    <svg class="w-3.5 h-3.5 hidden md:block text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-[12px] hidden md:block text-desc font-bold text-left ml-0 leading-none">অধ্যাপক ড. এম শাহিনুর রহমান</span>
                                </div>
                            </div>

                            <!-- Columnist 3 -->
                            <div class="group cursor-pointer pt-4 border-t border-custom">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                    <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                        নারীর ক্ষমতায়ন ও সামাজিক বিবর্তন
                                    </h4>
                                </div>
                                <div class="flex items-center gap-1.5 pt-1">
                                    <svg class="w-3.5 h-3.5 hidden md:block text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="text-[12px] hidden md:block text-desc font-bold text-left ml-0 leading-none">ড. নীলুফার পারভীন</span>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    @if($adHeroRight2 && $adHeroRight2->image)
                    <div class="shrink-0 mt-4 flex justify-center md:justify-start">
                        <a href="{{ $adHeroRight2->link ?? '#' }}" target="_blank" rel="noopener" class="block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/3] w-full max-w-[280px]">
                            <img src="{{ storage_image_url($adHeroRight2->image) }}" alt="{{ $adHeroRight2->caption ?? 'বিজ্ঞাপন' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" onload="this.parentElement.classList.remove('img-placeholder')">
                        </a>
                    </div>
                    @endif

                </div>

            </section>
            @php $adHeroBelow = ad_slot('hero_below'); @endphp
            @if($adHeroBelow && $adHeroBelow->image)
            <div class="py-4 md:py-8 flex justify-center bg-transparent px-0 md:px-4">
                <div class="container flex justify-center overflow-hidden">
                    <a href="{{ $adHeroBelow->link ?? '#' }}" class="w-full flex justify-center max-w-[1000px] mx-auto" target="_blank" rel="noopener">
                        <div class="img-placeholder w-full max-w-[1000px] h-[90px] md:h-[100px] overflow-hidden shrink-0">
                            <img src="{{ storage_image_url($adHeroBelow->image) }}"
                                alt="{{ $adHeroBelow->caption ?? 'Advertisement' }}"
                                class="w-full h-full object-cover object-center shadow-sm"
                                onload="this.parentElement.classList.remove('img-placeholder')">
                        </div>
                    </a>
                </div>
            </div>
            @endif
            <!-- Section: Politics (রাজনীতি) -->
            @php
            $politicsSection = $layoutSections['section-politics'] ?? null;
            $politicsCategory = optional($politicsSection)->category;
            $politicsTitle = optional($politicsCategory)->name;
            $politicsPosts = $sectionPosts['section-politics'] ?? collect();
            @endphp
            <section class="mt-8 lg:mt-12">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                        @if($politicsCategory)
                        <a href="{{ category_url($politicsCategory) }}" class="hover:text-rose-600 transition-colors">{{ $politicsTitle }}</a>
                        @elseif($politicsTitle)
                        {{ $politicsTitle }}
                        @endif
                        <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                    </h2>
                    @if($politicsCategory)
                    <a href="{{ category_url($politicsCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                    @else
                    <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-0 lg:-mx-3">
                    @forelse($politicsPosts->take(4) as $index => $post)
                    <div class="group cursor-pointer lg:px-3{{ $index < 3 ? ' lg:border-r border-custom' : '' }}">
                        <a
                            href="{{ news_url($post) }}">
                            <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm">
                                @if($post->image)
                                <img
                                    src="{{ Storage::url($post->image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    onload="this.parentElement.classList.remove('img-placeholder')">
                                @endif
                            </div>
                            <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                                {{ $post->title }}
                            </h3>
                            @php
                            $politicsExcerpt = \Illuminate\Support\Str::limit(strip_tags($post->description ?? ''), 100);
                            @endphp
                            @if($politicsExcerpt)
                            <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                {!! $politicsExcerpt !!}
                            </p>
                            @endif
                        </a>
                    </div>
                    @empty
                    <!-- fallback: আগের static ৪টা item চাইলে এখানে কপি করো -->
                    @endforelse
                </div>

                @php $adHomeVideo = ad_slot('home_video'); @endphp
                @if($adHomeVideo && $adHomeVideo->video_youtube_id)
                <!-- ভিডিও: ভিউপোর্টে এলে অটো অন; ক্লিক করলে URL-এ যাবে -->
                <div id="home-video-container" class="mt-8 pt-8 border-t border-custom flex justify-center">
                    <div class="rounded-lg overflow-hidden shadow-md w-full max-w-[600px] aspect-video relative">
                        <div id="home-video-player" class="w-full h-full"></div>
                        @if(!empty($adHomeVideo->link))
                        <a href="{{ $adHomeVideo->link }}" target="_blank" rel="noopener noreferrer" class="absolute inset-0 z-10 block" aria-label="ভিডিওতে ক্লিক করে লিংকে যান"></a>
                        @endif
                    </div>
                </div>
                <script>
                    (function() {
                        var videoId = {
                            {
                                json_encode($adHomeVideo - > video_youtube_id)
                            }
                        };
                        var homeVideoPlayer = null;

                        function initHomeVideo() {
                            if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
                                window.onYouTubeIframeAPIReady = function() {
                                    homeVideoPlayer = new YT.Player('home-video-player', {
                                        videoId: videoId,
                                        width: '100%',
                                        height: '100%',
                                        playerVars: {
                                            enablejsapi: 1,
                                            autoplay: 0,
                                            rel: 0
                                        },
                                        events: {
                                            onReady: onHomeVideoReady
                                        }
                                    });
                                };
                                var tag = document.createElement('script');
                                tag.src = 'https://www.youtube.com/iframe_api';
                                var first = document.getElementsByTagName('script')[0];
                                first.parentNode.insertBefore(tag, first);
                            } else {
                                homeVideoPlayer = new YT.Player('home-video-player', {
                                    videoId: videoId,
                                    width: '100%',
                                    height: '100%',
                                    playerVars: {
                                        enablejsapi: 1,
                                        autoplay: 0,
                                        rel: 0
                                    },
                                    events: {
                                        onReady: onHomeVideoReady
                                    }
                                });
                            }
                        }

                        function onHomeVideoReady(event) {
                            var player = event.target;
                            var container = document.getElementById('home-video-container');
                            if (!container) return;
                            var observer = new IntersectionObserver(function(entries) {
                                if (!player || !player.getPlayerState) return;
                                var entry = entries[0];
                                if (entry.isIntersecting) {
                                    try {
                                        player.playVideo();
                                    } catch (e) {}
                                } else {
                                    try {
                                        player.pauseVideo();
                                    } catch (e) {}
                                }
                            }, {
                                threshold: 0.4,
                                rootMargin: '0px'
                            });
                            observer.observe(container);
                        }
                        if (document.readyState === 'loading') {
                            document.addEventListener('DOMContentLoaded', initHomeVideo);
                        } else {
                            initHomeVideo();
                        }
                    })();
                </script>
                @endif

                <!-- Section: National (জাতীয়) -->
                @php
                $nationalSection = $layoutSections['section-national'] ?? null;
                $nationalCategory = optional($nationalSection)->category;
                $nationalTitle = optional($nationalCategory)->name;
                $nationalPosts = $sectionPosts['section-national'] ?? collect();
                @endphp
                <section class="mt-12">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($nationalCategory)
                            <a href="{{ category_url($nationalCategory) }}" class="hover:text-rose-600 transition-colors">{{ $nationalTitle }}</a>
                            @else
                            {{ $nationalTitle }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($nationalCategory)
                        <a href="{{ category_url($nationalCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-[5.5fr_3fr_3.5fr] gap-3">
                        <!-- Left Column (Wide) -> প্রথম পোস্ট -->
                        <div class="space-y-6">
                            @if($nationalPosts->isNotEmpty())
                            @php $mainNational = $nationalPosts->first(); @endphp
                            <a
                                href="{{ news_url($mainNational) }}"
                                class="group cursor-pointer">
                                <div class="img-placeholder overflow-hidden aspect-[16/10] mb-2 relative shadow-sm">
                                    @if($mainNational->image)
                                    <img
                                        src="{{ Storage::url($mainNational->image) }}"
                                        alt="{{ $mainNational->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-1.5">
                                    {{ $mainNational->title }}
                                </h3>
                                @php
                                    $mainNationalExcerpt = \Illuminate\Support\Str::limit(
                                        html_entity_decode(strip_tags($mainNational->description ?? '')),
                                        120
                                    );
                                @endphp
                                @if($mainNationalExcerpt)
                                    <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left">
                                        {!! $mainNationalExcerpt !!}
                                </p>
                                @endif
                            </a>
                            @else
                            <div class="group cursor-pointer">
                                <div class="img-placeholder overflow-hidden aspect-[16/10] mb-2 relative shadow-sm"><img src="https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                </div>
                                <h3 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-1.5">
                                    মেট্রোরেলের নতুন রুট উদ্বোধন: বদলে যাচ্ছে রাজধানীর যাতায়াত দৃশ্যপট
                                </h3>
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left">
                                    প্রধানমন্ত্রী আজ সকালে মেট্রোরেলের নতুন বর্ধিত অংশের উদ্বোধন করেছেন। এর ফলে মতিঝিল থেকে উত্তরা পর্যন্ত যেতে সময় লাগবে মাত্র ৩০ মিনিট। আধুনিক এই যাতায়াত ব্যবস্থা রাজধানীর যানজট নিরসনে বিশাল ভূমিকা রাখবে বলে আশা করা হচ্ছে...
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Middle Column (Narrow) -> পরের ২টা পোস্ট -->
                        <div class="space-y-6">
                            @foreach($nationalPosts->slice(1, 2) as $idx => $post)
                            <a
                                href="{{ news_url($post) }}"
                                class="group.cursor-pointer{{ $idx > 0 ? ' pt-3 border-t border-custom' : '' }}">
                                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm">
                                    @if($post->image)
                                    <img
                                        src="{{ Storage::url($post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    {{ $post->title }}
                                </h3>
                            </a>
                            @endforeach
                        </div>

                        <!-- Right Column: Tabbed Stories List -->
                        <div>
                            <!-- Tab Bar -->
                            <div class="flex w-full border-b border-custom mb-4">
                                <button id="tab-latest" onclick="switchTab('latest')" class="flex-1 text-sm font-bold py-2 border-b-2 border-rose-600 text-rose-600 -mb-px transition-all duration-200 text-center">
                                    সর্বশেষ
                                </button>
                                <button id="tab-popular" onclick="switchTab('popular')" class="flex-1 text-sm font-bold py-2 border-b-2 border-custom text-gray-400 -mb-px hover:text-gray-600 transition-all duration-200 text-center">
                                    পঠিত
                                </button>
                            </div>
                            <!-- সর্বশেষ Panel (লেটেস্ট ৬ পোস্ট, পোস্ট-টাইপ ক্যাটাগরি) -->
                            @php $bnNum = ['১', '২', '৩', '৪', '৫', '৬']; @endphp
                            <div id="panel-latest" class="space-y-4">
                                @foreach($latestSidebarPosts ?? [] as $index => $post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0 block">
                                    <span class="text-3xl font-bold text-gray-400 serif shrink-0 leading-none">{{ $bnNum[$index] ?? ($index + 1) }}.</span>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                            {{ $post->title }}
                                        </h4>
                                    </div>
                                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm">
                                        @if($post->image)
                                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>

                            <!-- পঠিত Panel (ভিউ অনুযায়ী টপ ৬, hidden by default) -->
                            <div id="panel-popular" class="space-y-4 hidden">
                                @foreach($popularSidebarPosts ?? [] as $index => $post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom last:border-0 last:pb-0 block">
                                    <span class="text-3xl font-bold text-gray-400 serif shrink-0 leading-none">{{ $bnNum[$index] ?? ($index + 1) }}.</span>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                            {{ $post->title }}
                                        </h4>
                                    </div>
                                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm">
                                        @if($post->image)
                                        <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section: Capital (রাজধানী) -->
                @php
                $capitalSection = $layoutSections['section-capital'] ?? null;
                $capitalCategory = optional($capitalSection)->category;
                $capitalTitle = optional($capitalCategory)->name;
                $capitalPosts = $sectionPosts['section-capital'] ?? collect();
                @endphp
                <section class="mt-5 lg:mt-20 border-b border-custom pb-6">
                    <div class="flex items-center justify-between mb-5 md:pt-8 pt-5 border-t border-custom">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($capitalCategory)
                            <a href="{{ category_url($capitalCategory) }}" class="hover:text-rose-600 transition-colors">{{ $capitalTitle }}</a>
                            @elseif($capitalTitle)
                            {{ $capitalTitle }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($capitalCategory)
                        <a href="{{ category_url($capitalCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-0 lg:-mx-3">
                        @forelse($capitalPosts->take(4) as $index => $post)
                        @php
                        $excerpt = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($post->description)), 100);
                        @endphp
                        <div class="group cursor-pointer lg:px-3{{ $index < 3 ? ' lg:border-r border-custom' : '' }}">
                            <a
                                href="{{ news_url($post) }}">
                                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm">
                                    @if($post->image)
                                    <img
                                        src="{{ Storage::url($post->image) }}"
                                        alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                </div>
                                <h3 class="text-lg xl:text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-2 mb-1.5">
                                    {{ $post->title }}
                                </h3>
                                @if($excerpt)
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                    {!! $excerpt !!}
                                </p>
                                @endif
                            </a>
                        </div>
                        @empty
                        <!-- fallback: আগের static ৪টা item চাইলে এখানে কপি করো -->
                        @endforelse
                    </div>
                </section>

                @php
                $sportsSectionBottom = $layoutSections['section-sports'] ?? null;
                $sportsCategoryBottom = optional($sportsSectionBottom)->category;
                $sportsTitleBottom = optional($sportsCategoryBottom)->name;
                $sportsPostsBottom = ($sectionPosts['section-sports'] ?? collect())->values();

                $sportsMain = $sportsPostsBottom->get(0);
                $sportsSecondary = $sportsPostsBottom->get(1);
                $sportsMid1 = $sportsPostsBottom->get(2);
                $sportsMid2 = $sportsPostsBottom->get(3);
                $sportsMid3 = $sportsPostsBottom->get(4);
                $sportsRight1 = $sportsPostsBottom->get(5);
                $sportsRight2 = $sportsPostsBottom->get(6);
                $sportsRight3 = $sportsPostsBottom->get(7);
                $sportsRight4 = $sportsPostsBottom->get(8);
                @endphp

                <!-- Section: Sports (খেলা) -->

                <section class="mt-12">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($sportsCategoryBottom)
                            <a href="{{ category_url($sportsCategoryBottom) }}" class="hover:text-rose-600 transition-colors">{{ $sportsTitleBottom ?: 'খেলা' }}</a>
                            @else
                            {{ $sportsTitleBottom ?: 'খেলা' }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($sportsCategoryBottom)
                        <a href="{{ category_url($sportsCategoryBottom) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    @if($sportsPostsBottom->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-3 space-y-3 md:space-y-0 lg:gap-0 lg:-mx-3">
                        <!-- Sports Left Column -->
                        <div class="lg:px-3 lg:border-r border-custom space-y-4">
                            <!-- Large Featured Item -->
                            <div class="group cursor-pointer">
                                @if($sportsMain)
                                @php
                                $mainExcerpt = \Illuminate\Support\Str::limit(strip_tags($sportsMain->description), 100);
                                @endphp
                                <a href="{{ news_url($sportsMain) }}" class="block">
                                    <div class="img-placeholder overflow-hidden aspect-video mb-2 relative shadow-sm">
                                        @if($sportsMain->image)
                                        <img src="{{ Storage::url($sportsMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h3 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-1">
                                        {{ $sportsMain->title }}
                                    </h3>
                                    @if($mainExcerpt)
                                    <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                        {{ $mainExcerpt }}
                                    </p>
                                    @endif
                                </a>
                                @endif
                            </div>

                            <!-- Secondary Item (Middle Column Style) -->
                            <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                @if($sportsSecondary)
                                @php
                                $secondaryExcerpt = \Illuminate\Support\Str::limit(strip_tags($sportsSecondary->description), 100);
                                @endphp
                                <a href="{{ news_url($sportsSecondary) }}" class="block">
                                    <div class="flex gap-2 lg:gap-4">
                                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm">
                                            @if($sportsSecondary->image)
                                            <img src="{{ Storage::url($sportsSecondary->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-normal serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                            {{ $sportsSecondary->title }}
                                        </h4>
                                    </div>
                                    @if($secondaryExcerpt)
                                    <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1 mt-1">
                                        {!! $secondaryExcerpt !!}
                                    </p>
                                    @endif
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Sports Middle Column (3 Items) -->
                        <div class="lg:px-3 lg:border-r border-custom space-y-2">
                            @foreach([['post' => $sportsMid1], ['post' => $sportsMid2], ['post' => $sportsMid3]] as $item)
                            @php $post = $item['post']; @endphp
                            @if($post)
                            @php
                            $excerpt = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($post->description)), 100);
                            @endphp
                            <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                <a href="{{ news_url($post) }}" class="block">
                                    <div class="flex gap-2 lg:gap-4">
                                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm">
                                            @if($post->image)
                                            <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                            {{ $post->title }}
                                        </h4>
                                    </div>
                                    @if($excerpt)
                                    <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1 mt-1">
                                        {!! $excerpt !!}
                                    </p>
                                    @endif
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <!-- Sports Right Column (4 Horizontal Items) -->
                        <div class="lg:px-3 space-y-3">
                            @foreach([$sportsRight1, $sportsRight2, $sportsRight3, $sportsRight4] as $post)
                            @if($post)
                            <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                                <a href="{{ news_url($post) }}" class="block">
                                    <div class="flex gap-2 lg:gap-4">
                                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm">
                                            @if($post->image)
                                            <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                            {{ $post->title }}
                                        </h4>
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @else
                    {{-- Sports সেকশনে এখনও কোনো পোস্ট নেই --}}
                    @endif
                </section>

                @php
                $countrySection = $layoutSections['section-countrywide'] ?? null;
                $countryCategory = optional($countrySection)->category;
                $countryTitle = optional($countryCategory)->name;
                $countryPosts = ($sectionPosts['section-countrywide'] ?? collect())->values();

                $countryMain = $countryPosts->get(0);
                $countryMid1 = $countryPosts->get(1);
                $countryMid2 = $countryPosts->get(2);
                $countryBot1 = $countryPosts->get(3);
                $countryBot2 = $countryPosts->get(4);
                $countryBot3 = $countryPosts->get(5);
                @endphp

                <!-- Section: Countrywide (সারাদেশ) -->
                <section class="mt-10 border-t border-custom pt-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($countryCategory)
                            <a href="{{ category_url($countryCategory) }}" class="hover:text-rose-600 transition-colors">{{ $countryTitle ?: 'সারাদেশ' }}</a>
                            @else
                            {{ $countryTitle ?: 'সারাদেশ' }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($countryCategory)
                        <a href="{{ category_url($countryCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    @if($countryPosts->isNotEmpty())
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-y-8 lg:gap-0 lg:-mx-3">
                        <!-- Main Content Area (9 Columns) -->
                        <div class="lg:col-span-9 lg:px-3">
                            <!-- Top Row: 6 + 3 -->
                            <div class="grid grid-cols-1 lg:grid-cols-9 lg:-mx-3">
                                <!-- Featured (6 Columns) -->
                                <div class="lg:col-span-6 lg:px-3 lg:border-r border-custom mb-6 lg:mb-0">
                                    @if($countryMain)
                                    @php
                                    $mainExcerpt = \Illuminate\Support\Str::limit(strip_tags($countryMain->description), 180);
                                    @endphp
                                    <a href="{{ news_url($countryMain) }}" class="group cursor-pointer">
                                        <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm">
                                            @if($countryMain->image)
                                            <img src="{{ Storage::url($countryMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h3 class="text-3xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-4">
                                            {{ $countryMain->title }}
                                        </h3>
                                        @if($mainExcerpt)
                                        <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                            {{ $mainExcerpt }}
                                        </p>
                                        @endif
                                    </a>
                                    @endif
                                </div>

                                <!-- Middle Column: Vertical Items (3 Columns) -->
                                <div class="lg:col-span-3 lg:px-3 space-y-2">
                                    <!-- Middle Item 1 -->
                                    @if($countryMid1)
                                    <a href="{{ news_url($countryMid1) }}" class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                        <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3">
                                                @if($countryMid1->image)
                                                <img src="{{ Storage::url($countryMid1->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                                @endif
                                            </div>
                                            <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                                {{ $countryMid1->title }}
                                            </h4>
                                        </div>
                                    </a>
                                    @endif

                                    <!-- Middle Item 2 -->
                                    @if($countryMid2)
                                    <a href="{{ news_url($countryMid2) }}" class="group cursor-pointer">
                                        <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3">
                                                @if($countryMid2->image)
                                                <img src="{{ Storage::url($countryMid2->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                                @endif
                                            </div>
                                            <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                                {{ $countryMid2->title }}
                                            </h4>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Bottom Row: 3 equal columns -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-3 lg:gap-6 mt-4 pt-4 border-t border-custom">
                                <!-- Bottom Item 1 -->
                                <div class="">
                                    @if($countryBot1)
                                    <a href="{{ news_url($countryBot1) }}" class="group cursor-pointer pb-3 border-b border-custom md:border-b-0 md:pb-0">
                                        <div class="flex flex-row md:block gap-2 md:gap-0">
                                            <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2">
                                                @if($countryBot1->image)
                                                <img src="{{ Storage::url($countryBot1->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                                @endif
                                            </div>
                                            <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                                {{ $countryBot1->title }}
                                            </h4>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                                <!-- Bottom Item 2 -->
                                <div class="">
                                    @if($countryBot2)
                                    <a href="{{ news_url($countryBot2) }}" class="group cursor-pointer pb-3 border-b border-custom md:border-b-0 md:pb-0">
                                        <div class="flex flex-row md:block gap-2 md:gap-0">
                                            <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2">
                                                @if($countryBot2->image)
                                                <img src="{{ Storage::url($countryBot2->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                                @endif
                                            </div>
                                            <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                                {{ $countryBot2->title }}
                                            </h4>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                                <!-- Bottom Item 3 -->
                                <div class="">
                                    @if($countryBot3)
                                    <a href="{{ news_url($countryBot3) }}" class="group cursor-pointer">
                                        <div class="flex flex-row md:block gap-2 md:gap-0">
                                            <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2">
                                                @if($countryBot3->image)
                                                <img src="{{ Storage::url($countryBot3->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                                @endif
                                            </div>
                                            <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                                {{ $countryBot3->title }}
                                            </h4>
                                        </div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Regional News Search (3 Columns) -->
                        <div class="lg:col-span-3 lg:px-3 lg:border-l border-custom">
                            <div class="bg-gray-50 p-6  border border-custom shadow-sm">
                                <h3 class="text-xl font-bold serif text-title mb-6 border-b pb-2 border-rose-600 inline-block">
                                    এলাকার খবর
                                </h3>

                                <form action="#" class="space-y-4">
                                    <!-- Division -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">বিভাগ</label>
                                        <select id="division-select" class="w-full border-custom  text-sm focus:ring-rose-500 focus:border-rose-500 py-2.5 bg-white">
                                            <option value="">বিভাগ নির্বাচন করুন</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->slug }}">{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- District -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">জেলা</label>
                                        <select class="w-full border-custom  text-sm focus:ring-rose-500 focus:border-rose-500 py-2.5 bg-white">
                                            <option>জেলা নির্বাচন করুন</option>
                                        </select>
                                    </div>

                                    <!-- Upazila -->
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1">উপজেলা</label>
                                        <select class="w-full border-custom  text-sm focus:ring-rose-500 focus:border-rose-500 py-2.5 bg-white">
                                            <option>উপজেলা নির্বাচন করুন</option>
                                        </select>
                                    </div>

                                    <!-- Search Button -->
                                    <button type="button" id="regional-search-btn" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3  transition-colors mt-4 shadow-md flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                        খুঁজুন
                                    </button>
                                </form>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const searchBtn = document.getElementById('regional-search-btn');
                                        const divisionSelect = document.getElementById('division-select');

                                        if (searchBtn && divisionSelect) {
                                            searchBtn.addEventListener('click', function() {
                                                const slug = divisionSelect.value;
                                                if (slug) {
                                                    window.location.href = '/topic/' + slug;
                                                } else {
                                                    alert('দয়া করে একটি বিভাগ নির্বাচন করুন।');
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    @else
                    {{-- সারাদেশ সেকশনে এখনও কোনো পোস্ট নেই --}}
                    @endif
                </section>
                @php
                $worldSection = $layoutSections['section-world'] ?? null;
                $worldCategory = optional($worldSection)->category;
                $worldTitle = optional($worldCategory)->name;
                $worldPosts = ($sectionPosts['section-world'] ?? collect())->values();

                $worldMain = $worldPosts->get(0);
                $worldMid1 = $worldPosts->get(1);
                $worldMid2 = $worldPosts->get(2);
                $worldRight1 = $worldPosts->get(3);
                $worldRight2 = $worldPosts->get(4);
                $worldRight3 = $worldPosts->get(5);
                $worldRight4 = $worldPosts->get(6);
                @endphp
                <!-- Section: World News (বিশ্ব সংবাদ) -->
                <section class="mt-12 border-t border-custom pt-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($worldCategory)
                            <a href="{{ category_url($worldCategory) }}" class="hover:text-rose-600 transition-colors">{{ $worldTitle ?: 'বিশ্ব সংবাদ' }}</a>
                            @else
                            {{ $worldTitle ?: 'বিশ্ব সংবাদ' }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($worldCategory)
                        <a href="{{ category_url($worldCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    @if($worldPosts->isNotEmpty())
                    <div class="grid grid-cols-1 lg:grid-cols-[5.6fr_2.5fr_3.9fr] gap-y-10 lg:gap-0 lg:-mx-3">
                        <!-- World News: Featured (5.25 Columns) -->
                        <div class="lg:px-3 lg:border-r border-custom">
                            @if($worldMain)
                            @php
                            $mainExcerpt = \Illuminate\Support\Str::limit(strip_tags($worldMain->description), 200);
                            @endphp
                            <a href="{{ news_url($worldMain) }}" class="group cursor-pointer">
                                <div class="img-placeholder overflow-hidden aspect-video mb-2 relative shadow-sm">
                                    @if($worldMain->image)
                                    <img src="{{ Storage::url($worldMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                                    {{ $worldMain->title }}
                                </h3>
                                @if($mainExcerpt)
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                    {{ $mainExcerpt }}
                                </p>
                                @endif
                            </a>
                            @endif
                        </div>

                        <!-- World News: Middle (2.5 Columns) -->
                        <div class="lg:px-3 lg:border-r border-custom space-y-3">
                            <!-- Middle Item 1 -->
                            @if($worldMid1)
                            @php
                            $excerpt = \Illuminate\Support\Str::limit(strip_tags($worldMid1->description), 100);
                            @endphp
                            <a href="{{ news_url($worldMid1) }}" class="group cursor-pointer pb-4 border-b border-custom last:border-0 last:pb-0">
                                <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden shadow-sm mb-0 lg:mb-3">
                                        @if($worldMid1->image)
                                        <img src="{{ Storage::url($worldMid1->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold serif leading-snug lg:leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5 lg:mt-0">
                                        {{ $worldMid1->title }}
                                    </h4>
                                </div>
                                @if($excerpt)
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1 mt-1">
                                    {!! $excerpt !!}
                                </p>
                                @endif
                            </a>
                            @endif
                            <!-- Middle Item 2 -->
                            @if($worldMid2)
                            @php
                            $excerpt = \Illuminate\Support\Str::limit(strip_tags($worldMid2->description), 100);
                            @endphp
                            <a href="{{ news_url($worldMid2) }}" class="group cursor-pointer pb-4 border-b border-custom last:border-0 last:pb-0">
                                <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden shadow-sm mb-0 lg:mb-3">
                                        @if($worldMid2->image)
                                        <img src="{{ Storage::url($worldMid2->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold serif leading-snug lg:leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5 lg:mt-0">
                                        {{ $worldMid2->title }}
                                    </h4>
                                </div>
                                @if($excerpt)
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1 mt-1">
                                    {!! $excerpt !!}
                                </p>
                                @endif
                            </a>
                            @endif
                        </div>

                        <!-- World News: Right (3.9 Columns) -->
                        <div class="lg:px-3 space-y-3">
                            @foreach([$worldRight1, $worldRight2, $worldRight3, $worldRight4] as $post)
                            @if($post)
                            <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                                <a href="{{ news_url($post) }}">
                                    <div class="flex gap-2">
                                        <div class="img-placeholder w-36 h-24 shrink-0 overflow-hidden shadow-sm">
                                            @if($post->image)
                                            <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                            {{ $post->title }}
                                        </h4>
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @else
                    {{-- বিশ্ব সংবাদ সেকশনে এখনও কোনো পোস্ট নেই --}}
                    @endif
                </section>
                @php
                $entSection = $layoutSections['section-entertainment'] ?? null;
                $entCategory = optional($entSection)->category;
                $entTitle = optional($entCategory)->name;
                $entPosts = ($sectionPosts['section-entertainment'] ?? collect())->values();

                $entLeft1 = $entPosts->get(0);
                $entLeft2 = $entPosts->get(1);
                $entLeft3 = $entPosts->get(2);
                $entLeft4 = $entPosts->get(3);
                $entMid = $entPosts->get(4);
                $entRight1 = $entPosts->get(5);
                $entRight2 = $entPosts->get(6);
                $entRight3 = $entPosts->get(7);
                $entRight4 = $entPosts->get(8);
                @endphp
                <!-- Section: Entertainment (বিনোদন) -->
                <section class="mt-12 border-t border-custom pt-8">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                            @if($entCategory)
                            <a href="{{ category_url($entCategory) }}" class="hover:text-rose-600 transition-colors">{{ $entTitle ?: 'বিনোদন' }}</a>
                            @else
                            {{ $entTitle ?: 'বিনোদন' }}
                            @endif
                            <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
                        </h2>
                        @if($entCategory)
                        <a href="{{ category_url($entCategory) }}" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @else
                        <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
                        @endif
                    </div>

                    @if($entPosts->isNotEmpty())
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-10 lg:gap-0 lg:-mx-3">
                        <!-- Left Column: Horizontal Items -->
                        <div class="lg:px-3 lg:border-r border-custom space-y-4">
                            @foreach([['post' => $entLeft1], ['post' => $entLeft2], ['post' => $entLeft3], ['post' => $entLeft4]] as $item)
                            @php $post = $item['post']; @endphp
                            @if($post)
                            <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                                <a href="{{ news_url($post) }}" class="flex gap-2 lg:gap-4">
                                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $post->title }}
                                    </h4>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>

                        <!-- Middle Column: Featured Vertical Item -->
                        <div class="lg:px-3 lg:border-r  border-custom">
                            @if($entMid)
                            @php
                            $excerpt = \Illuminate\Support\Str::limit(strip_tags($entMid->description), 180);
                            @endphp
                            <a href="{{ news_url($entMid) }}" class="group cursor-pointer">
                                <div class="img-placeholder overflow-hidden h-84 mb-3 relative shadow-sm">
                                    @if($entMid->image)
                                    <img src="{{ Storage::url($entMid->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                </div>
                                <h3 class="text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                                    {{ $entMid->title }}
                                </h3>
                                @if($excerpt)
                                <p class="text-sm md:text-base font-normal text-desc leading-relaxed text-left line-clamp-1">
                                    {!! $excerpt !!}
                                </p>
                                @endif
                            </a>
                            @endif
                        </div>

                        <!-- Right Column: Horizontal Items -->
                        <div class="lg:px-3 space-y-4">
                            @foreach([$entRight1, $entRight2, $entRight3, $entRight4] as $post)
                            @if($post)
                            <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                                <a href="{{ news_url($post) }}" class="flex gap-2 lg:gap-4">
                                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $post->title }}
                                    </h4>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @else
                    {{-- বিনোদন সেকশনে এখনও কোনো পোস্ট নেই --}}
                    @endif
                </section>
                @php
                $lifeSection = $layoutSections['section-lifestyle'] ?? null;
                $lifeCategory = optional($lifeSection)->category;
                $lifeTitle = optional($lifeCategory)->name;
                $lifePosts = ($sectionPosts['section-lifestyle'] ?? collect())->values();

                $techSection = $layoutSections['section-tech'] ?? null;
                $techCategory = optional($techSection)->category;
                $techTitle = optional($techCategory)->name;
                $techPosts = ($sectionPosts['section-tech'] ?? collect())->values();

                $diffSection = $layoutSections['section-different-eye'] ?? null;
                $diffCategory = optional($diffSection)->category;
                $diffTitle = optional($diffCategory)->name;
                $diffPosts = ($sectionPosts['section-different-eye'] ?? collect())->values();

                $lifeMain = $lifePosts->get(0);
                $lifeList1 = $lifePosts->get(1);
                $lifeList2 = $lifePosts->get(2);
                $lifeList3 = $lifePosts->get(3);

                $techMain = $techPosts->get(0);
                $techList1 = $techPosts->get(1);
                $techList2 = $techPosts->get(2);
                $techList3 = $techPosts->get(3);

                $diffMain = $diffPosts->get(0);
                $diffList1 = $diffPosts->get(1);
                $diffList2 = $diffPosts->get(2);
                $diffList3 = $diffPosts->get(3);
                @endphp
                <!-- Section: Lifestyle, Tech, Different Eyes (লাইফস্টাইল, টেক, ভিন্নচোখে) -->
                <section class="mt-12 border-t border-custom pt-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-10 lg:gap-0 lg:-mx-3">
                        <!-- Column 1: Lifestyle (লাইফস্টাইল) -->
                        <div class="lg:px-3 lg:border-r border-custom">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">@if($lifeCategory)<a href="{{ category_url($lifeCategory) }}" class="hover:text-rose-600 transition-colors">{{ $lifeTitle ?: 'লাইফস্টাইল' }}</a>@else{{ $lifeTitle ?: 'লাইফস্টাইল' }}@endif</h3>
                            </div>

                            <!-- Lifestyle: Featured -->
                            @if($lifeMain)
                            <a href="{{ news_url($lifeMain) }}" class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3">
                                        @if($lifeMain->image)
                                        <img src="{{ Storage::url($lifeMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $lifeMain->title }}
                                    </h4>
                                </div>
                            </a>
                            @endif

                            <!-- Lifestyle: List -->
                            <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                                @foreach([$lifeList1, $lifeList2, $lifeList3] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-lg font-normal serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $post->title }}
                                    </h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Column 2: Tech (টেক) -->
                        <div class="lg:px-3 lg:border-r border-custom">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">@if($techCategory)<a href="{{ category_url($techCategory) }}" class="hover:text-rose-600 transition-colors">{{ $techTitle ?: 'টেক' }}</a>@else{{ $techTitle ?: 'টেক' }}@endif</h3>
                            </div>

                            <!-- Tech: Featured -->
                            @if($techMain)
                            <a href="{{ news_url($techMain) }}" class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3">
                                        @if($techMain->image)
                                        <img src="{{ Storage::url($techMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $techMain->title }}
                                    </h4>
                                </div>
                            </a>
                            @endif

                            <!-- Tech: List -->
                            <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                                @foreach([$techList1, $techList2, $techList3] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-lg font-normal serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $post->title }}
                                    </h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Column 3: Different Eyes (ভিন্নচোখে) -->
                        <div class="lg:px-3">
                            <div class="mb-6">
                                <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">@if($diffCategory)<a href="{{ category_url($diffCategory) }}" class="hover:text-rose-600 transition-colors">{{ $diffTitle ?: 'ভিন্নচোখে' }}</a>@else{{ $diffTitle ?: 'ভিন্নচোখে' }}@endif</h3>
                            </div>

                            <!-- Different Eyes: Featured -->
                            @if($diffMain)
                            <a href="{{ news_url($diffMain) }}" class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3">
                                        @if($diffMain->image)
                                        <img src="{{ Storage::url($diffMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $diffMain->title }}
                                    </h4>
                                </div>
                            </a>
                            @endif

                            <!-- Different Eyes: List -->
                            <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                                @foreach([$diffList1, $diffList2, $diffList3] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-lg font-normal serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                        {{ $post->title }}
                                    </h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Section: Tabbed Content (প্রজন্ম, ক্যাম্পাস, চাকরি) -->
                @php
                $genSection = $layoutSections['section-generation'] ?? null;
                $genCategory = optional($genSection)->category;
                $genTitle = optional($genCategory)->name;
                $genPosts = ($sectionPosts['section-generation'] ?? collect())->values();

                $campusSection = $layoutSections['section-campus'] ?? null;
                $campusCategory = optional($campusSection)->category;
                $campusTitle = optional($campusCategory)->name;
                $campusPosts = ($sectionPosts['section-campus'] ?? collect())->values();

                $jobSection = $layoutSections['section-job'] ?? null;
                $jobCategory = optional($jobSection)->category;
                $jobTitle = optional($jobCategory)->name;
                $jobPosts = ($sectionPosts['section-job'] ?? collect())->values();

                // Projonmo mapping (9 items)
                $genMain = $genPosts->get(0);
                $genCol2_1 = $genPosts->get(1);
                $genCol2_2 = $genPosts->get(2);
                $genCol2_3 = $genPosts->get(3);
                $genCol2_4 = $genPosts->get(4);
                $genCol3_1 = $genPosts->get(5);
                $genCol3_2 = $genPosts->get(6);
                $genCol3_3 = $genPosts->get(7);
                $genCol3_4 = $genPosts->get(8);

                // Campus mapping (9 items)
                $campusMain = $campusPosts->get(0);
                $campusCol2_1 = $campusPosts->get(1);
                $campusCol2_2 = $campusPosts->get(2);
                $campusCol2_3 = $campusPosts->get(3);
                $campusCol2_4 = $campusPosts->get(4);
                $campusCol3_1 = $campusPosts->get(5);
                $campusCol3_2 = $campusPosts->get(6);
                $campusCol3_3 = $campusPosts->get(7);
                $campusCol3_4 = $campusPosts->get(8);

                // Job mapping (9 items)
                $jobMain = $jobPosts->get(0);
                $jobCol2_1 = $jobPosts->get(1);
                $jobCol2_2 = $jobPosts->get(2);
                $jobCol2_3 = $jobPosts->get(3);
                $jobCol2_4 = $jobPosts->get(4);
                $jobCol3_1 = $jobPosts->get(5);
                $jobCol3_2 = $jobPosts->get(6);
                $jobCol3_3 = $jobPosts->get(7);
                $jobCol3_4 = $jobPosts->get(8);
                @endphp
                <section class="mt-12 border-t border-custom pt-8">
                    <!-- Tabs Header (শুধু ট্যাব, ক্যাটাগরি পেজে নেয় না) -->
                    <div class="flex items-center gap-8 border-b border-custom mb-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
                        <button type="button" onclick="switchTopicTab('projonmo')" id="tab-projonmo" class="tab-topic text-xl font-bold serif pb-3 border-b-2 border-rose-600 text-rose-600 transition-all duration-180">{{ $genTitle ?: 'প্রজন্ম' }}</button>
                        <button type="button" onclick="switchTopicTab('campus')" id="tab-campus" class="tab-topic text-xl font-bold serif pb-3 border-b-2 border-transparent text-gray-500 hover:text-rose-600 transition-all duration-180">{{ $campusTitle ?: 'ক্যাম্পাস' }}</button>
                        <button type="button" onclick="switchTopicTab('chakri')" id="tab-chakri" class="tab-topic text-xl font-bold serif pb-3 border-b-2 border-transparent text-gray-500 hover:text-rose-600 transition-all duration-180">{{ $jobTitle ?: 'চাকরি' }}</button>
                    </div>

                    <!-- Tab Panels Container -->
                    <div id="projonmo-panel" class="topic-panel">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <!-- Col 1: Big Vertical -->
                            <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                @if($genMain)
                                <a href="{{ news_url($genMain) }}">
                                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2">
                                            @if($genMain->image)
                                            <img src="{{ Storage::url($genMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">{{ $genMain->title }}</h4>
                                    </div>
                                </a>
                                @endif
                            </div>
                            <!-- Col 2: Horizontal List -->
                            <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                                @foreach([$genCol2_1, $genCol2_2, $genCol2_3, $genCol2_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>

                            <!-- Col 3: Horizontal List -->
                            <div class="space-y-4">
                                @foreach([$genCol3_1, $genCol3_2, $genCol3_3, $genCol3_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Campus panel -->
                    <div id="campus-panel" class="topic-panel hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <!-- Col 1: Big Vertical -->
                            <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                @if($campusMain)
                                <a href="{{ news_url($campusMain) }}">
                                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2">
                                            @if($campusMain->image)
                                            <img src="{{ Storage::url($campusMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">{{ $campusMain->title }}</h4>
                                    </div>
                                </a>
                                @endif
                            </div>
                            <!-- Col 2: Horizontal List -->
                            <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                                @foreach([$campusCol2_1, $campusCol2_2, $campusCol2_3, $campusCol2_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>

                            <!-- Col 3: Horizontal List -->
                            <div class="space-y-3">
                                @foreach([$campusCol3_1, $campusCol3_2, $campusCol3_3, $campusCol3_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Job panel -->
                    <div id="chakri-panel" class="topic-panel hidden">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                            <!-- Col 1: Big Vertical -->
                            <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                @if($jobMain)
                                <a href="{{ news_url($jobMain) }}">
                                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2">
                                            @if($jobMain->image)
                                            <img src="{{ Storage::url($jobMain->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                        </div>
                                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">{{ $jobMain->title }}</h4>
                                    </div>
                                </a>
                                @endif
                            </div>
                            <!-- Col 2: Horizontal List -->
                            <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                                @foreach([$jobCol2_1, $jobCol2_2, $jobCol2_3, $jobCol2_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>

                            <!-- Col 3: Horizontal List -->
                            <div class="space-y-3">
                                @foreach([$jobCol3_1, $jobCol3_2, $jobCol3_3, $jobCol3_4] as $post)
                                @if($post)
                                <a href="{{ news_url($post) }}" class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                                    <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm">
                                        @if($post->image)
                                        <img src="{{ Storage::url($post->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                    </div>
                                    <h5 class="text-base font-normal serif leading-snug group-hover:text-rose-600 transition-colors">{{ $post->title }}</h5>
                                </a>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>

                <script>
                    function switchTopicTab(topic) {
                        // Hide all panels
                        document.querySelectorAll('.topic-panel').forEach(panel => {
                            panel.classList.add('hidden');
                        });
                        // Show selected panel
                        document.getElementById(`${topic}-panel`).classList.remove('hidden');

                        // Reset all tab buttons
                        ['projonmo', 'campus', 'chakri'].forEach(t => {
                            const btn = document.getElementById(`tab-${t}`);
                            btn.classList.remove('border-rose-600', 'text-rose-600');
                            btn.classList.add('border-transparent', 'text-gray-500');
                        });
                        // Set active tab button
                        const activeBtn = document.getElementById(`tab-${topic}`);
                        activeBtn.classList.add('border-rose-600', 'text-rose-600');
                        activeBtn.classList.remove('border-transparent', 'text-gray-500');
                    }

                    function switchTab(tab) {
                        const latestPanel = document.getElementById('panel-latest');
                        const popularPanel = document.getElementById('panel-popular');
                        const latestBtn = document.getElementById('tab-latest');
                        const popularBtn = document.getElementById('tab-popular');
                        if (tab === 'latest') {
                            latestPanel.classList.remove('hidden');
                            popularPanel.classList.add('hidden');
                            latestBtn.classList.add('border-rose-600', 'text-rose-600');
                            latestBtn.classList.remove('border-custom', 'text-gray-400');
                            popularBtn.classList.add('border-custom', 'text-gray-400');
                            popularBtn.classList.remove('border-rose-600', 'text-rose-600');
                        } else {
                            popularPanel.classList.remove('hidden');
                            latestPanel.classList.add('hidden');
                            popularBtn.classList.add('border-rose-600', 'text-rose-600');
                            popularBtn.classList.remove('border-custom', 'text-gray-400');
                            latestBtn.classList.add('border-custom', 'text-gray-400');
                            latestBtn.classList.remove('border-rose-600', 'text-rose-600');
                        }
                    }
                </script>
                <!-- Section: Video (ভিডিও) -->
                @php
                $videoSection = $layoutSections['section-video'] ?? null;
                $videoCategory = optional($videoSection)->category;
                $videoTitle = optional($videoCategory)->name;
                $videoList = $sectionVideos ?? collect();
                $mainVideo = $videoList->get(0);
                $side1 = $videoList->get(1);
                $side2 = $videoList->get(2);
                $side3 = $videoList->get(3);
                @endphp
                <section class="py-8 border-t border-custom mt-4">
                    <div class="">
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-2xl font-bold serif text-gray-900">@if($videoCategory)<a href="{{ category_url($videoCategory) }}" class="hover:text-rose-600 transition-colors">{{ $videoTitle ?: 'ভিডিও' }}</a>@else{{ $videoTitle ?: 'ভিডিও' }}@endif</h2>
                            <div class="h-1 flex-grow bg-rose-600"></div>
                        </div>

                        @if($videoList->isNotEmpty())
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            <!-- Main Video: 7 Cols -->
                            <div class="lg:col-span-7 group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                                @if($mainVideo)
                                @php
                                    $mainThumb = null;
                                    if (!empty($mainVideo->image)) {
                                        $mainThumb = Storage::url($mainVideo->image);
                                    } elseif (!empty($mainVideo->youtube_link) && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $mainVideo->youtube_link, $m)) {
                                        $mainThumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                                    }
                                @endphp
                                <a href="{{ route('videos.show', $mainVideo->slug) }}">
                                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                        <div class="{{ $mainThumb ? 'img-placeholder' : '' }} w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0">
                                            @if($mainThumb)
                                                <img src="{{ $mainThumb }}" alt="{{ $mainVideo->title }}"
                                                    class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700"
                                                    onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                            <!-- Play Button Overlay -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-10 h-10 lg:w-16 lg:h-16 bg-rose-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-8 lg:h-8 fill-current" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="text-xl lg:text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors line-clamp-1 lg:line-clamp-1 lg:mt-3">{{ $mainVideo->title }}</h3>
                                    </div>
                                </a>
                                @endif
                            </div>

                            <!-- Side Videos: 5 Cols -->
                            <div class="lg:col-span-5">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-3 lg:gap-4">
                                    @foreach([$side1, $side2, $side3] as $video)
                                    @if($video)
                                    @php
                                        $sideThumb = null;
                                        if (!empty($video->image)) {
                                            $sideThumb = Storage::url($video->image);
                                        } elseif (!empty($video->youtube_link) && preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->youtube_link, $m)) {
                                            $sideThumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
                                        }
                                    @endphp
                                    <a href="{{ route('videos.show', $video->slug) }}" class="group cursor-pointer flex gap-2 lg:block pb-3 border-b border-custom last:border-0 lg:border-0 lg:pb-0">
                                        <div class="{{ $sideThumb ? 'img-placeholder' : '' }} w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0 lg:mb-2">
                                            @if($sideThumb)
                                                <img src="{{ $sideThumb }}" alt="{{ $video->title }}"
                                                    class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500"
                                                    onload="this.parentElement.classList.remove('img-placeholder')">
                                            @endif
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="w-10 h-10 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white border border-custom/20 group-hover:bg-rose-600 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="text-base lg:text-lg font-normal serif leading-snug group-hover:text-rose-600 transition-colors line-clamp-1">{{ $video->title }}</h4>
                                    </a>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Section: Photo (ছবি) -->
                @php
                $gallerySection = $layoutSections['section-gallery'] ?? null;
                $galleryCategory = optional($gallerySection)->category;
                $galleryTitle = optional($galleryCategory)->name;
                $galleryList = $sectionGalleries ?? collect();
                $galleryMain = $galleryList->get(0);
                $gallerySmall1 = $galleryList->get(1);
                $gallerySmall2 = $galleryList->get(2);
                $galleryRight = $galleryList->get(3);
                @endphp
                <section class="py-8 border-t border-custom mt-4">
                    <div class="">
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-2xl font-bold serif text-gray-900">@if($galleryCategory)<a href="{{ category_url($galleryCategory) }}" class="hover:text-rose-600 transition-colors">{{ $galleryTitle ?: 'ছবি' }}</a>@else{{ $galleryTitle ?: 'ছবি' }}@endif</h2>
                            <div class="h-1 flex-grow bg-rose-600"></div>
                        </div>

                        @if($galleryList->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-4">
                                @if($galleryMain)
                                @php $galleryMainCover = $galleryMain->images->first(); @endphp
                                <a href="{{ route('gallery.show', $galleryMain->slug) }}" class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[180px] md:h-[330px]">
                                    @if($galleryMainCover)
                                    <img src="{{ Storage::url($galleryMainCover->image) }}" alt="{{ $galleryMain->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')">
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4">
                                        <p class="text-white font-serif text-base font-normal leading-tight line-clamp-1">{{ $galleryMain->title }}</p>
                                    </div>
                                </a>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach([$gallerySmall1, $gallerySmall2] as $gallery)
                                    @if($gallery)
                                    @php $cover = $gallery->images->first(); @endphp
                                    <a href="{{ route('gallery.show', $gallery->slug) }}" class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[240px] md:h-[180px]">
                                        @if($cover)
                                        <img src="{{ Storage::url($cover->image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')">
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4">
                                            <p class="text-white font-serif text-base font-normal leading-tight line-clamp-1">{{ $gallery->title }}</p>
                                        </div>
                                    </a>
                                    @endif
                                    @endforeach
                                </div>
                            </div>

                            @if($galleryRight)
                            @php $galleryRightCover = $galleryRight->images->first(); @endphp
                            <a href="{{ route('gallery.show', $galleryRight->slug) }}" class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[180px] md:h-[505px]">
                                @if($galleryRightCover)
                                <img src="{{ Storage::url($galleryRightCover->image) }}" alt="{{ $galleryRight->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
                                    <span class="bg-rose-600 text-white text-xs font-bold px-2 py-1 w-max mb-3">ফিচারড ফটো</span>
                                    <h3 class="text-white text-xl md:text-3xl font-bold serif leading-tight line-clamp-1">{{ $galleryRight->title }}</h3>
                                </div>
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </section>

        </div>
</x-layout>