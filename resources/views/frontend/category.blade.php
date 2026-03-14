<x-layout>
    <x-slot:title>{{ $category->name }} - দ্য ডেইলি নিউজ</x-slot>

        <div class="py-4 md:py-10 min-h-screen">
            <div class="container">
                @php \Carbon\Carbon::setLocale('bn'); @endphp

                <!-- Category Header -->
                <div class="mb-4 md:mb-10 text-left">
                    <h1 class="text-4xl md:text-3xl font-semibold serif text-title mb-3">{{ $category->name }}</h1>

                    {{-- Subcategories row (parent + child দুটো পেজেই দেখাতে চাই --}}
                    @if(isset($subCategorySource) && $subCategorySource->subCategories && $subCategorySource->subCategories->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($subCategorySource->subCategories as $child)
                                @php
                                    $isActive = $category->id === $child->id;
                                    $parentSlugForChild = $subCategorySource->slug;
                                @endphp
                                <a href="{{ route('category.show.child', [$parentSlugForChild, $child->slug]) }}"
                                   class="px-3 py-1 text-xs md:text-sm font-semibold border {{ $isActive ? 'border-rose-500 text-rose-600' : 'border-slate-200 text-slate-700 hover:text-rose-600 hover:border-rose-500' }} bg-white">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="flex items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6">
                        <!-- Home Icon -->
                        <a href="/" class="text-slate-500 hover:text-rose-600 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </a>

                        {{-- Breadcrumb: Category > Subcategory --}}
                        @if($category->parent)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <a href="{{ route('category.show', $category->parent->slug) }}" class="text-black hover:text-rose-600 transition-colors">
                                {{ $category->parent->name }}
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <span class="text-black font-bold">{{ $category->name }}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                                <path d="m9 18 6-6-6-6"/>
                            </svg>
                            <span class="text-black font-bold">{{ $category->name }}</span>
                        @endif
                    </div>

                    <div class="w-full border-b border-slate-300 relative mb-4 md:mb-8">
                        <div class="absolute -bottom-[1px] left-0 w-40 h-[2px] bg-rose-600"></div>
                    </div>
                </div>

                <style>
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

                <section class="national-grid">
                    <!-- প্রথম কলাম: সরু -->
                    <div class="p-0 md:p-4">
                        {{-- কন্টেন্ট আপাতত খালি --}}
                    </div>

                    <!-- মাঝের কলাম: সংবাদ তালিকা -->
                    <div class="bg-white p-0 md:p-4 flex flex-col gap-3 md:gap-5">

                        @forelse($posts as $post)
                        @php
                            $primaryCategory = $post->categories->first();
                            $parentCategory  = optional($primaryCategory)->parent;
                            $categorySlug    = $parentCategory ? $parentCategory->slug : optional($primaryCategory)->slug;
                            $subCategorySlug = $parentCategory ? $primaryCategory->slug : null;
                        @endphp
                        <article class="flex flex-col md:flex-row gap-2 md:gap-4 last:pb-0">
                            {{-- ছবি --}}
                            <a
                                href="{{ $subCategorySlug
                                    ? route('news.show.sub', [$categorySlug, $subCategorySlug, $post->slug])
                                    : route('news.show', [$categorySlug, $post->slug]) }}"
                                class="w-full md:w-auto flex-shrink-0"
                            >
                                <div class="img-placeholder w-full md:w-[305px] h-[200px] md:h-[170px] overflow-hidden">
                                    <img src="{{ $post->image ? asset('storage/'.$post->image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600' }}"
                                         alt="{{ $post->title }}"
                                         class="w-full h-full object-cover"
                                         onload="this.parentElement.classList.remove('img-placeholder')">
                                </div>
                            </a>
                            {{-- টাইটেল + বিবরণ --}}
                            <div class="flex flex-col justify-start gap-2 pt-1 flex-1">
                                <a
                                    href="{{ $subCategorySlug
                                        ? route('news.show.sub', [$categorySlug, $subCategorySlug, $post->slug])
                                        : route('news.show', [$categorySlug, $post->slug]) }}"
                                >
                                    <h3 class="text-xl md:text-base font-bold serif text-title leading-snug hover:text-rose-600 transition-colors">
                                        {{ $post->title }}
                                    </h3>
                                </a>
                                @if($post->sub_title)
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    {{ $post->sub_title }}
                                </p>
                                @elseif($post->description)
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    {{ Str::limit(strip_tags($post->description), 160) }}
                                </p>
                                @endif
                                <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-xs font-medium text-gray-500">
                                        {{ $post->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </article>
                        @empty
                        <p class="text-desc text-center py-10">এই category-তে কোনো সংবাদ পাওয়া যায়নি।</p>
                        @endforelse

                        {{-- Pagination --}}
                        @if($posts->hasPages())
                        <div class="mt-4">{{ $posts->links() }}</div>
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
                        <div class="block overflow-hidden  border border-slate-200 shadow-sm transition-all group">
                            <div class="relative h-[250px] w-full bg-gradient-to-br from-[#1e3a5f] to-[#0f172a] flex flex-col items-center justify-center p-8 text-center overflow-hidden">
                                <div class="absolute inset-0 opacity-10 pointer-events-none">
                                    <svg width="100%" height="100%"><pattern id="pattern-1" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1" fill="white"/></pattern><rect width="100%" height="100%" fill="url(#pattern-1)"/></svg>
                                </div>
                                <div class="w-16 h-16 bg-white/10  flex items-center justify-center mb-4 backdrop-blur-md border border-white/20">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <h4 class="text-white font-bold text-xl leading-tight mb-4 relative z-10">আপনার ব্যবসার প্রসারে<br>আমাদের সাথে নামুন</h4>
                                <a href="#" class="px-6 py-2.5 bg-rose-600 text-white text-sm font-bold  hover:bg-rose-700 transition-all hover:scale-105 shadow-xl relative z-10">বিজ্ঞাপন দিন →</a>
                            </div>
                        </div>

                        {{-- বিজ্ঞাপন ২: মাঝারি ব্যানার --}}
                        <div class="block overflow-hidden  border border-slate-200 shadow-sm transition-all group mt-4">
                            <div class="relative h-[180px] w-full bg-gradient-to-br from-[#7c3aed] to-[#4338ca] flex flex-col items-center justify-center p-6 text-center overflow-hidden">
                                <div class="absolute top-[-20%] right-[-10%] w-40 h-40 bg-white/10  blur-3xl"></div>
                                <h4 class="text-white font-bold text-lg leading-tight mb-2">স্পনসরড পোস্ট</h4>
                                <p class="text-indigo-100 text-xs mb-4">সবচেয়ে কম মূল্যে আপনার পণ্যটি প্রচার করুন</p>
                                <span class="px-4 py-1.5 bg-white/20 text-white text-[11px] font-bold  border border-white/30 backdrop-blur-sm">বিস্তারিত দেখুন</span>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </div>
</x-layout>
