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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="m9 18 6-6-6-6"/></svg>
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
 
                        {{-- প্রধান নিউজ কার্ড (Featured Article) --}}
                        <article class="flex flex-col-reverse md:flex-row gap-3 pb-3 last:border-0 text-left border-b border-gray-100">
                            {{-- বাম: টাইটেল + বিবরণ --}}
                            <div class="flex flex-col justify-start gap-3 flex-1">
                                <a href="#">
                                    <h3 class="text-2xl md:text-3xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors">
                                        <span style="color: red !important;">{{ $categoryName }} /</span> ১৭ সংস্থা থেকে ৬৪ শতাংশ পর্যবেক্ষক নিয়োগ!
                                    </h3>
                                </a>
                                <p class="text-base font-semibold text-desc leading-relaxed line-clamp-4">
                                    দেশের উপকূলীয় এলাকাগুলোতে লোনা পানির প্রভাবে কৃষি জমি নষ্ট হচ্ছে। এবং সুপেয় পানির সংকট প্রকট থেকে প্রকটতর হচ্ছে। পরিবেশবাদীরা বলছেন, এখনই কার্যকর ব্যবস্থা না নিলে আগামী দশকে এই জনপদ বসবাসের অনুপযোগী হয়ে যেতে পারে। নতুন গবেষণায় দেখা গেছে সমুদ্রপৃষ্ঠের উচ্চতা বৃদ্ধির হার আশঙ্কাজনকভাবে বেড়েছে।
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-xs font-medium">
                                        {{ \Carbon\Carbon::parse('now')->subHours(2)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            {{-- ডান: ছোট ছবি (ফোর্সিং সাইজ) --}}
                            <div class="flex-shrink-0 group overflow-hidden">
                                <a href="#">
                                    <div class="img-placeholder"><img src="https://loremflickr.com/600/400/environment,sea?lock=11" 
                                         alt="বিশেষ সংবাদ"
                                         style="width: 625px; height: 355px;"
                                         class="object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </a>
                            </div>
                        </article>

                        {{-- ৩-কলামের নিচের নিউজ গ্রিড --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-0 pt-3">
                            {{-- গ্রিড আইটেম ১ --}}
                            <article class="flex flex-row-reverse md:flex-col gap-2 md:gap-3 pb-4 border-b border-gray-100 md:border-b-0 md:pb-0 md:pr-3 md:border-r md:border-slate-200">
                                <a href="#" class="group overflow-hidden shrink-0">
                                    <div class="img-placeholder w-36 h-24 md:w-full md:h-[180px]"><img src="https://loremflickr.com/400/250/politics?lock=21" 
                                         alt="নিউজ ১"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </a>
                                <div class="flex flex-col gap-1 flex-1">
                                    <a href="#">
                                        <h4 class="text-base md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                            রাজনীতির খবর: নতুন বছরে নতুন রাজনৈতিক মেরুকরণ
                                        </h4>
                                    </a>
                                    <p class="text-sm md:text-base font-medium text-desc leading-relaxed line-clamp-2 md:line-clamp-3">
                                        দেশের প্রধান রাজনৈতিক দলগুলোর মধ্যে সংলাপের সম্ভাবনা নিয়ে আলোচনা শুরু হয়েছে নতুন করে।
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-1 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="text-[10px] md:text-xs font-medium">{{ \Carbon\Carbon::parse('now')->subHours(3)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>

                            {{-- গ্রিড আইটেম ২ --}}
                            <article class="flex flex-row-reverse md:flex-col gap-2 md:gap-3 pb-4 border-b border-gray-100 md:border-b-0 md:pb-0 md:px-3 md:border-r md:border-slate-200">
                                <a href="#" class="group overflow-hidden shrink-0">
                                    <div class="img-placeholder w-36 h-24 md:w-full md:h-[180px]"><img src="https://loremflickr.com/400/250/sports?lock=22" 
                                         alt="নিউজ ২"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </a>
                                <div class="flex flex-col gap-1 flex-1">
                                    <a href="#">
                                        <h4 class="text-base md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                            ক্রীড়াঙ্গন: টি-টোয়েন্টি বিশ্বকাপের প্রস্তুতি জোরদার করছে বাংলাদেশ
                                        </h4>
                                    </a>
                                    <p class="text-sm md:text-base font-medium text-desc leading-relaxed line-clamp-2 md:line-clamp-3">
                                        টি-টোয়েন্টি বিশ্বকাপের আগে সিরিজগুলোতে ভালো ফলাফল করতে আত্মবিশ্বাসী টিম বাংলাদেশ।
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-1 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="text-[10px] md:text-xs font-medium">{{ \Carbon\Carbon::parse('now')->subHours(4)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>

                            {{-- গ্রিড আইটেম ৩ --}}
                            <article class="flex flex-row-reverse md:flex-col gap-2 md:gap-3 md:pl-3">
                                <a href="#" class="group overflow-hidden shrink-0">
                                    <div class="img-placeholder w-36 h-24 md:w-full md:h-[180px]"><img src="https://loremflickr.com/400/250/world?lock=23" 
                                         alt="নিউজ ৩"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </a>
                                <div class="flex flex-col gap-1 flex-1">
                                    <a href="#">
                                        <h4 class="text-base md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                            আন্তর্জাতিক সংবাদ: মধ্যপ্রাচ্যে শান্তি ফিরিয়ে আনার নতুন উদ্যোগ
                                        </h4>
                                    </a>
                                    <p class="text-sm md:text-base font-medium text-desc leading-relaxed line-clamp-2 md:line-clamp-3">
                                        বিশ্বনেতারা এখন মধ্যপ্রাচ্যের স্থিতিশীলতা নিশ্চিত করতে নতুন একটি আন্তর্জাতিক সম্মেলনের পরিকল্পনা করছেন।
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-1 text-slate-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span class="text-[10px] md:text-xs font-medium">{{ \Carbon\Carbon::parse('now')->subHours(5)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
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
                            <!-- Item 1 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">১.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        ডিজিটাল জনশুমারি: নতুন তথ্যে পাল্টে গেল জনসংখ্যা হিসাব
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1590602847861-f357a9332bbc?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">২.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        রেমিট্যান্স প্রবাহে জোয়ার: স্বস্তিতে অর্থনীতি ও নতুন সম্ভাবনা
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 3 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৩.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        সাভারে তৈরি পোশাক কারখানায় অগ্নিকাণ্ড, নিয়ন্ত্রণে ৫ ইউনিট
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 4 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৪.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        টাকা পাচার রোধে কড়াকড়ি, নজরদারিতে প্রভাবশালীরা
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1554224155-1696413565d3?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 5 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৫.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        সারাদেশে শৈত্যপ্রবাহের পূর্বাভাস, জেঁকে বসতে পারে শীত
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1477601263368-1823bb1643df?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 6 -->
                            <div class="group cursor-pointer flex items-start gap-3">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৬.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        বন্যায় ক্ষতিগ্রস্তদের পুনর্বাসনে সরকারের নতুন প্যাকেজ ঘোষণা
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                        </div>

                        <!-- পঠিত Panel (hidden by default) -->
                        <div id="sp-panel-popular" class="space-y-4 hidden">
                            <!-- Item 1 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">১.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        বিশ্ববিদ্যালয়গুলোতে ভর্তির নতুন নীতিমালা চূড়ান্ত হচ্ছে
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">২.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        পদ্মা সেতুতে রেকর্ড যানবাহন, একদিনে আয় ৬ কোটি টাকা
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 3 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৩.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        টি-টোয়েন্টিতে বাংলাদেশের ঐতিহাসিক জয়, দেশজুড়ে উৎসব
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1540747913346-19212a4b32a1?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 4 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৪.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        দেশে প্রথমবার সরকারি হাসপাতালে রোবোটিক সার্জারি সফল
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 5 -->
                            <div class="group cursor-pointer flex items-start gap-3 pb-4 border-b border-gray-100">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৫.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        চাঁদপুরে ইলিশ আহরণে নতুন রেকর্ড, কমছে দাম
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1559628233-100c798642fd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
                            <!-- Item 6 -->
                            <div class="group cursor-pointer flex items-start gap-3">
                                <span class="text-2xl font-bold text-gray-300 serif shrink-0 leading-none">৬.</span>
                                <div class="flex-1">
                                    <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                                        দেশীয় পণ্যের রপ্তানি বেড়েছে ১৮%, নতুন বাজার উন্মোচন
                                    </h4>
                                </div>
                                <div class="overflow-hidden shrink-0 border border-gray-100 shadow-sm " style="width:96px; height:72px; min-width:96px; min-height:72px;">
                                    <div class="img-placeholder w-full h-full"><img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                                </div>
                            </div>
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

                    <!-- মাঝের কলাম: সংবাদ তালিকা -->
                    @php 
                        \Carbon\Carbon::setLocale('bn'); 
                    @endphp

                    <div class="bg-white px-0 md:p-4 flex flex-col gap-0">
 
                        {{-- নিউজ কার্ড ১ --}}
                        <article class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 py-3 md:py-4 border-b border-gray-100 last:border-0">
                            {{-- ডান: ছবি --}}
                            <a href="#" class="flex-shrink-0">
                                <div class="img-placeholder w-36 h-24 md:w-[305px] md:h-[170px]"><img src="https://loremflickr.com/600/400/parliament,building?lock=1" 
                                     alt="জাতীয় সংসদ"
                                     class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                            </a>
                            {{-- বাম: টাইটেল --}}
                            <div class="flex flex-col justify-start gap-1 md:gap-2 pt-0 md:pt-1 md:px-0 flex-1">
                                <a href="#">
                                    <h3 class="text-lg md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                        জাতীয় সংসদে গুরুত্বপূর্ণ বিল পাস, নতুন আইন কার্যকর হচ্ছে শীঘ্রই
                                    </h3>
                                </a>
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    আজ জাতীয় সংসদে একটি ঐতিহাসিক বিল পাস হয়েছে যা দেশের নাগরিকদের জীবনে বড় পরিবর্তন আনবে বলে আশা করা হচ্ছে। এই আইনের মাধ্যমে ডিজিটাল সেবার পরিধি আরও বিস্তৃত হবে।
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-[10px] md:text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse('2026-03-06 07:00:00')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </article>

                        {{-- নিউজ কার্ড ২ --}}
                        <article class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 py-3 md:py-4 border-b border-gray-100 last:border-0">
                            <a href="#" class="flex-shrink-0">
                                <div class="img-placeholder w-36 h-24 md:w-[305px] md:h-[170px]"><img src="https://loremflickr.com/600/400/economy,money?lock=2" 
                                     alt="অর্থনীতি"
                                     class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                            </a>
                            <div class="flex flex-col justify-start gap-1 md:gap-2 pt-0 md:pt-1 md:px-0 flex-1">
                                <a href="#">
                                    <h3 class="text-lg md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                        দেশের অর্থনীতিতে নতুন গতি, রপ্তানি আয় বেড়েছে ১৫ শতাংশ
                                    </h3>
                                </a>
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    চলতি অর্থ বছরে দেশের রপ্তানি আয় উল্লেখযোগ্যভাবে বৃদ্ধি পেয়েছে। গার্মেন্টস সেক্টর এবং কৃষি পণ্যের রপ্তানি বৃদ্ধির কারণে এই সাফল্য এসেছে বলে মনে করছেন বিশেষজ্ঞরা।
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-[10px] md:text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse('2026-03-06 15:30:00')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </article>

                        {{-- নিউজ কার্ড ৩ --}}
                        <article class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 py-3 md:py-4 border-b border-gray-100 last:border-0">
                            <a href="#" class="flex-shrink-0">
                                <div class="img-placeholder w-36 h-24 md:w-[305px] md:h-[170px]"><img src="https://loremflickr.com/600/400/city,traffic?lock=3" 
                                     alt="যানজট"
                                     class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                            </a>
                            <div class="flex flex-col justify-start gap-1 md:gap-2 pt-0 md:pt-1 md:px-0 flex-1">
                                <a href="#">
                                    <h3 class="text-lg md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                        রাজধানীতে যানজট নিরসনে নতুন পরিকল্পনা গ্রহণ করেছে সরকার
                                    </h3>
                                </a>
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    ঢাকা মহানগরীর যানজট সমস্যা সমাধানে সরকার একটি বিস্তারিত মহাপরিকল্পনা গ্রহণ করেছে। নতুন ফ্লাইওভার এবং মেট্রোরেলের সংযোগ আরও বাড়ানোর প্রস্তাব দেওয়া হয়েছে।
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-[10px] md:text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse('2026-03-06 14:00:00')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </article>

                        {{-- নিউজ কার্ড ৪ --}}
                        <article class="flex flex-row-reverse md:flex-row-reverse gap-2 md:gap-4 pb-3 border-b border-gray-100 last:border-0 border-b-0">
                            <a href="#" class="flex-shrink-0">
                                <div class="img-placeholder w-36 h-24 md:w-[305px] md:h-[170px]"><img src="https://loremflickr.com/600/400/student,college?lock=4" 
                                     alt="শিক্ষা"
                                     class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" ></div>
                            </a>
                            <div class="flex flex-col justify-start gap-1 md:gap-2 pt-0 md:pt-1 md:px-0 flex-1">
                                <a href="#">
                                    <h3 class="text-lg md:text-xl font-bold serif text-title leading-snug hover:text-rose-600 transition-colors line-clamp-2">
                                        শিক্ষা খাতে বরাদ্দ বৃদ্ধি, নতুন বিশ্ববিদ্যালয় স্থাপনের ঘোষণা
                                    </h3>
                                </a>
                                <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                                    সরকার আগামী বাজেটে শিক্ষা খাতে বরাদ্দ বাড়ানোর পরিকল্পনা করেছে। গবেষণার কাজে সহায়তার জন্য প্রতিটি জেলায় আধুনিক ল্যাবরেটরি তৈরি করা হবে।
                                </p>
                                <div class="flex items-center gap-1.5 mt-auto text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span class="text-[10px] md:text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse('2026-03-05 23:00:00')->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </article>

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
                </section>
            </div>
        </div>
</x-layout>

