<x-layout>
    <x-slot:title>{{ $gallery->category->name ?? $gallery->title }} - দ্য ডেইলি নিউজ</x-slot>

    <div class="py-4 md:py-10 min-h-screen bg-white">
        <div class="container">
            @php
                \Carbon\Carbon::setLocale('bn');
                $categoryName = $gallery->category->name ?? 'গ্যালারি';
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="m9 18 6-6-6-6"/></svg>
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
                        {{ $gallery->title }}
                    </h1>

                    <div class="flex flex-col gap-1 pb-2 mb-2">
                        <span class="text-lg font-bold text-title leading-tight">ফটো ডেস্ক</span>
                        <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-3 gap-4">
                            <span class="text-sm md:text-base text-desc">
                                প্রকাশ : {{ $gallery->created_at->format('d M Y, H:i') }}
                            </span>
                            <div class="flex items-center gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                                   class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-[#3b5998] hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/></svg>
                                </a>
                                <a href="javascript:window.print()"
                                   class="w-8 h-8 border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-800 hover:text-white transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($gallery->description)
                    <div class="w-full prose prose-lg max-w-none text-desc text-lg md:text-xl font-medium leading-relaxed">
                        {!! $gallery->description !!}
                    </div>
                    @endif

                    <!-- ছবি গ্যালারি গ্রিড -->
                    @if($gallery->images->isNotEmpty())
                    <div class="w-full">
                        @php $firstImage = $gallery->images->first(); @endphp
                        <!-- প্রধান ছবি -->
                        <div class="img-placeholder w-full aspect-[3/2] overflow-hidden shadow-md mb-3">
                            <img src="{{ $firstImage->image }}"
                                 alt="{{ $gallery->title }}"
                                 class="w-full h-auto"
                                 onload="this.parentElement.classList.remove('img-placeholder')">
                        </div>
                        <p class="text-base font-medium text-desc mb-6">{{ $gallery->title }}। ছবি: সংগৃহীত</p>

                        <!-- বাকি ছবিগুলো গ্রিডে -->
                        @if($gallery->images->count() > 1)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-4">
                            @foreach($gallery->images->skip(1) as $image)
                            <div class="img-placeholder aspect-[4/3] overflow-hidden shadow-sm">
                                <img src="{{ $image->image }}"
                                     alt="{{ $gallery->title }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                     onload="this.parentElement.classList.remove('img-placeholder')">
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- দ্বিতীয় কলাম (৩ ভাগ) -->
                <div class="flex flex-col gap-10 w-full">

                    <!-- বিজ্ঞাপন -->
                    <div class="w-full bg-slate-50 overflow-hidden border border-slate-100 shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest p-2 block bg-white/50 text-center">বিজ্ঞাপন</span>
                        <div class="h-[300px] flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400 font-bold italic text-sm">
                            বিজ্ঞাপন
                        </div>
                    </div>

                    <!-- আরও গ্যালারি (সাইডবার) -->
                    @if($related->isNotEmpty())
                    <div class="hidden lg:flex flex-col gap-6 pt-5">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-2">
                            <div class="w-1.5 h-6 bg-rose-600"></div>
                            <h3 class="text-xl font-bold serif text-title">আরও গ্যালারি</h3>
                        </div>
                        @foreach($related as $rel)
                        @php $relThumb = $rel->images->first(); @endphp
                        <a href="{{ route('gallery.show', $rel->slug) }}" class="group cursor-pointer flex flex-col gap-2">
                            <div class="img-placeholder aspect-[16/9] overflow-hidden">
                                <img src="{{ $relThumb ? $relThumb->image : 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?w=400' }}"
                                     alt="{{ $rel->title }}"
                                     class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                     onload="this.parentElement.classList.remove('img-placeholder')">
                            </div>
                            <h4 class="text-base font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors">
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
