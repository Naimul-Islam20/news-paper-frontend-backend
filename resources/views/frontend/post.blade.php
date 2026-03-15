<x-layout>
    <x-slot:title>{{ $post->title }} - দ্য ডেইলি নিউজ</x-slot>

        <div class="py-4 md:py-10 min-h-screen bg-white">
            <div class="container">
                @php
                \Carbon\Carbon::setLocale('bn');
                $primaryCategory = $post->categories->first();
                $parentCategory = optional($primaryCategory)->parent;
                $categoryName = $parentCategory ? $parentCategory->name : ($primaryCategory->name ?? 'সংবাদ');
                @endphp

                <!-- Header + Breadcrumbs -->
                <div class="mb-4 md:mb-10 text-left">
                    <!-- বড় header: category / parent name -->
                    <h1 class="text-4xl md:text-3xl font-semibold serif text-title mb-3">
                        {{ $categoryName }}
                    </h1>

                    {{-- Subcategory strip (same style as category page) --}}
                    @php
                    $subCategorySource = $parentCategory ?: $primaryCategory;
                    @endphp
                    @if($subCategorySource && $subCategorySource->subCategories && $subCategorySource->subCategories->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-3">
                        @foreach($subCategorySource->subCategories as $child)
                        @php
                        $isActive = $primaryCategory && $primaryCategory->id === $child->id;
                        $parentSlugForChild = $parentCategory
                        ? $parentCategory->slug
                        : $subCategorySource->slug;
                        @endphp
                        <a href="{{ route('category.show.child', [$parentSlugForChild, $child->slug]) }}"
                            class="px-3 py-1 text-xs md:text-sm font-semibold border {{ $isActive ? 'border-rose-500 text-rose-600' : 'border-slate-200 text-slate-700 hover:text-rose-600 hover:border-rose-500' }} bg-white">
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Breadcrumb line -->
                    <div class="flex flex-wrap items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6">
                        <a href="/" class="text-slate-500 hover:text-rose-600 transition-all flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>
                        @if($parentCategory)
                        {{-- Home > Parent Category > Subcategory --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <a href="{{ route('category.show', $parentCategory->slug) }}" class="text-black hover:text-rose-600 transition-colors">
                            {{ $parentCategory->name }}
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <a href="{{ route('category.show.child', [$parentCategory->slug, $primaryCategory->slug]) }}" class="text-black font-bold hover:text-rose-600 transition-colors">
                            {{ $primaryCategory->name }}
                        </a>
                        @elseif($primaryCategory)
                        {{-- Home > Single Category --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <a href="{{ route('category.show', $primaryCategory->slug) }}" class="text-black font-bold hover:text-rose-600 transition-colors">
                            {{ $primaryCategory->name }}
                        </a>
                        @else
                        {{-- Home > Generic label --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="text-black font-bold">
                            সংবাদ
                        </span>
                        @endif
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

                <!-- Main Layout Grid -->
                <section class="details-grid">

                    <!-- প্রথম কলাম (৮ ভাগ) -->
                    <div class="flex flex-col gap-6 w-full">
                        <!-- শিরোনাম: post title -->
                        <h1 class="text-2xl md:text-4xl font-bold serif text-title leading-tight">
                            {{ $post->title }}
                        </h1>
                        @if($post->sub_title)
                        <p class="text-lg md:text-xl text-desc font-bold leading-relaxed mt-2 whitespace-pre-line">
                            {{ $post->sub_title }}
                        </p>
                        @endif

                        <div class="flex flex-col gap-1 pb-2 mb-2">
                            <span class="text-lg font-bold text-title leading-tight">
                                {{ $post->reporter->desk ?? $post->reporter->name ?? 'ডিজিটাল ডেস্ক' }}
                            </span>
                            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-3 gap-4">
                                <span class="text-sm md:text-base text-desc">
                                    প্রকাশ : {{ published_at($post->created_at) }}
                                </span>

                                @php $shareUrl = url()->current(); $shareTitle = $post->title; @endphp
                                <!-- সোশ্যাল শেয়ার আইকনসমূহ -->
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

                        <!-- ফিচারড ইমেজ -->
                        <div class="w-full">
                            <div class="img-placeholder w-full aspect-[3/2] overflow-hidden shadow-md">
                                <img src="{{ storage_image_url($post->image) ?: 'https://loremflickr.com/1200/800/parliament,building?lock=1' }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover"
                                    onload="this.parentElement.classList.remove('img-placeholder')">
                            </div>
                            @if($post->image_caption)
                            <p class="text-sm text-slate-500 mt-3 italic border-l-4 border-rose-600 py-1 bg-slate-50">
                                {{ $post->image_caption }}
                            </p>
                            @endif
                        </div>

                        @php $adPostTop = ad_slot('post_top'); @endphp
                        @if($adPostTop && $adPostTop->image)
                        <div class="my-6 w-full flex justify-center">
                            <a href="{{ $adPostTop->link ?? '#' }}" class="w-[80%] max-w-[1000px] flex justify-center shrink-0" target="_blank" rel="noopener">
                                <div class="img-placeholder w-full h-[90px] overflow-hidden flex items-center justify-center">
                                    <img src="{{ storage_image_url($adPostTop->image) }}"
                                        alt="{{ $adPostTop->caption ?? 'Advertisement' }}"
                                        class="max-w-full max-h-full w-auto h-full object-contain shadow-sm"
                                        onload="this.parentElement.classList.remove('img-placeholder')">
                                </div>
                            </a>
                        </div>
                        @endif

                        <!-- নিউজ ডেসক্রিপশন (WYSIWYG HTML সহ) -->
                        <div class="prose prose-lg max-w-none text-title text-xl font-medium space-y-6 pt-4 px-0 lg:px-[125px] text-justify leading-[1.8]">
                            {!! $post->description !!}
                        </div>
                    </div>

                    <!-- দ্বিতীয় কলাম (৩ ভাগ) -->
                    <div class="flex flex-col gap-10 w-full">

                        @php
                            $adSidebar1 = ad_slot('post_sidebar_1');
                            $adSidebar2 = ad_slot('post_sidebar_2');
                        @endphp
                        @if(($adSidebar1 && $adSidebar1->image) || ($adSidebar2 && $adSidebar2->image))
                        <div class="w-full max-w-[280px] space-y-4">
                            @if($adSidebar1 && $adSidebar1->image)
                            <div class="bg-slate-50 overflow-hidden border border-slate-100 shadow-sm">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest p-2 block bg-white/50 text-center">বিজ্ঞাপন</span>
                                <a href="{{ $adSidebar1->link ?? '#' }}" class="block hover:opacity-95 transition-opacity" target="_blank" rel="noopener">
                                    <div class="img-placeholder w-full aspect-[4/3] overflow-hidden">
                                        <img src="{{ storage_image_url($adSidebar1->image) }}" alt="{{ $adSidebar1->caption ?? 'বিজ্ঞাপন' }}" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                </a>
                            </div>
                            @endif
                            @if($adSidebar2 && $adSidebar2->image)
                            <div class="bg-slate-50 overflow-hidden border border-slate-100 shadow-sm">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest p-2 block bg-white/50 text-center">বিজ্ঞাপন</span>
                                <a href="{{ $adSidebar2->link ?? '#' }}" class="block hover:opacity-95 transition-opacity" target="_blank" rel="noopener">
                                    <div class="img-placeholder w-full aspect-[4/3] overflow-hidden">
                                        <img src="{{ storage_image_url($adSidebar2->image) }}" alt="{{ $adSidebar2->caption ?? 'বিজ্ঞাপন' }}" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')">
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- এ সম্পর্কিত আরও পড়ুন (সাইডবার) -->
                        @if($related->isNotEmpty())
                        <div class="hidden lg:flex flex-col gap-6 pt-5">
                            <div class="flex items-center gap-3 border-b border-slate-100 pb-2">
                                <div class="w-1.5 h-6 bg-rose-600"></div>
                                <h3 class="text-xl font-bold serif text-title">এ সম্পর্কিত আরও পড়ুন</h3>
                            </div>

                            @foreach($related->take(2) as $rel)
                            @php
                            $primaryCategory = $rel->categories->first();
                            $parentCategory = optional($primaryCategory)->parent;
                            $categorySlug = $parentCategory ? $parentCategory->slug : optional($primaryCategory)->slug;
                            $subCategorySlug = $parentCategory ? $primaryCategory->slug : null;
                            @endphp
                            <a
                                href="{{ $subCategorySlug
                                ? route('news.show.sub', [$categorySlug, $subCategorySlug, $rel->slug])
                                : route('news.show', [$categorySlug, $rel->slug]) }}"
                                class="group cursor-pointer flex flex-col gap-2">
                                <div class="img-placeholder aspect-[16/9] overflow-hidden">
                                    <img src="{{ storage_image_url($rel->image) ?: 'https://loremflickr.com/600/400/law?lock='.$rel->id }}"
                                        alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                        onload="this.parentElement.classList.remove('img-placeholder')">
                                </div>
                                <h4 class="text-base font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors">
                                    {{ \Illuminate\Support\Str::limit($rel->title, 80) }}
                                </h4>
                            </a>
                            @endforeach
                        </div>
                        @endif

                    </div>

                </section>

                <!-- এ সম্পর্কিত আরও পড়ুন (নিচে পরের ৪টা) -->
                @if($related->skip(2)->take(4)->isNotEmpty())
                <div class="mt-12 md:mt-[100px] pt-8 md:pt-[60px] ">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-2 h-8 bg-rose-600"></div>
                        <h3 class="text-xl md:text-3xl font-bold serif text-title">এ সম্পর্কিত আরও পড়ুন</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($related->skip(2)->take(4) as $rel)
                        @php
                        $primaryCategory = $rel->categories->first();
                        $parentCategory = optional($primaryCategory)->parent;
                        $categorySlug = $parentCategory ? $parentCategory->slug : optional($primaryCategory)->slug;
                        $subCategorySlug = $parentCategory ? $primaryCategory->slug : null;
                        @endphp
                        <a
                            href="{{ $subCategorySlug
                            ? route('news.show.sub', [$categorySlug, $subCategorySlug, $rel->slug])
                            : route('news.show', [$categorySlug, $rel->slug]) }}"
                            class="group cursor-pointer flex flex-row md:flex-col gap-2 md:gap-3 pb-3 border-b border-gray-100 md:border-0 md:pb-0 last:border-0 last:pb-0">
                            <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-[3/2] shrink-0 overflow-hidden relative shadow-sm border border-gray-100">
                                <img src="{{ storage_image_url($rel->image) ?: 'https://loremflickr.com/600/400/news?lock='.$rel->id }}"
                                    alt="{{ $rel->title }}"
                                    class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                    onload="this.parentElement.classList.remove('img-placeholder')">
                            </div>
                            <h4 class="text-base md:text-lg font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors flex-1">
                                {{ \Illuminate\Support\Str::limit($rel->title, 90) }}
                            </h4>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
</x-layout>