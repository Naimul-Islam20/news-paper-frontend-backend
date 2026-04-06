@php
\Carbon\Carbon::setLocale('bn');
// Extract YouTube video ID
$youtubeId = null;
if ($video->youtube_link) {
    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $video->youtube_link, $matches);
    $youtubeId = $matches[1] ?? null;
}
$categoryName = $video->category->name ?? 'ভিডিও';

$videoShareTitle = $video->title . ' - দ্য ডেইলি নিউজ';
$videoShareDesc = \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($video->description ?? '')), 160);

$videoThumb = $video->image ? storage_image_url($video->image) : null;
if (!$videoThumb && $youtubeId) {
    $videoThumb = 'https://img.youtube.com/vi/'.$youtubeId.'/hqdefault.jpg';
}
$videoShareImage = $videoThumb ? trim(url($videoThumb)) : null;
@endphp
<x-layout>
    <x-slot:title>{{ $videoShareTitle }}</x-slot>
    @if($videoShareImage)
    <x-slot:metaImage>{{ $videoShareImage }}</x-slot>
    @endif
    <x-slot:metaDescription>{{ $videoShareDesc }}</x-slot>
    <x-slot:ogTitle>{{ $video->title }}</x-slot>

        <div class="py-4 md:py-10 min-h-screen bg-white">
            <div class="container">

                <!-- Header + Breadcrumb -->
                <div class="mb-4 md:mb-10 text-left">
                    <h1 class="text-2xl md:text-3xl font-semibold serif text-title mb-3">
                        {{ $categoryName }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6">
                        <a href="/" class="text-slate-500 hover:text-rose-600 transition-all flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-500">
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
                                @php $shareUrl = url()->current(); $shareTitle = $video->title; @endphp
                                <div class="flex items-center gap-3">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-[#3b5998] hover:text-white transition-all" title="Facebook"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                                        </svg></a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-[#0084ff] hover:text-white transition-all" title="Messenger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.639.639 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.639.639 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76zm5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.441.441 0 0 1 .51-.011l1.802 1.307c.51.37 1.158.27 1.55-.223l2.356-3.728c.226-.359-.214-.761-.551-.506l-2.525 1.917a.441.441 0 0 1-.51.011L6.595 5.893a.903.903 0 0 0-1.049.408z" />
                                        </svg></a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-black hover:text-white transition-all" title="X"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                        </svg></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-[#0077b5] hover:text-white transition-all" title="LinkedIn"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H3.362v7.225h1.581zm-1-8.306c.564 0 1.022-.458 1.022-1.022 0-.564-.458-1.022-1.022-1.022-.564 0-1.022.458-1.022 1.022 0 .564.458 1.022 1.022 1.022zm11.035 8.306V9.759c0-1.847-.988-2.706-2.301-2.706-1.059 0-1.532.584-1.797.994V6.169h-1.582c.021.445 0 7.225 0 7.225h1.582V9.759c0-.399.028-.799.145-1.087.32-.799 1.05-1.625 2.275-1.625 1.605 0 2.247 1.223 2.247 3.016v4.185h1.582z" />
                                        </svg></a>
                                    <a href="javascript:window.print()" class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-800 hover:text-white transition-all" title="Print"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                        </svg></a>
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
                                    {{ \Illuminate\Support\Str::limit($rel->title, 80) }}
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