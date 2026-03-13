<x-layout>
    <x-slot:title>
        দ্য ডেইলি নিউজ | প্রিমিয়াম নিউজপেপার টেমপ্লেট
    </x-slot>

    <!-- Top Advertisement Section -->
    <div class="py-4 md:py-8 flex justify-center bg-transparent px-4">
        <div class="container flex justify-center overflow-hidden">
            <a href="#" class="w-full flex justify-center">
                <div class="img-placeholder w-full max-w-[1000px]">
                    <img src="/top-banner.gif" 
                         alt="Advertisement" 
                         class="w-full h-auto shadow-sm object-contain" 
                         onload="this.parentElement.classList.remove('img-placeholder')">
                </div>
            </a>
        </div>
    </div>

    <div class="container">
    <!-- Hero Section -->
    <section class="flex flex-col lg:grid lg:grid-cols-[2.7fr_6.3fr_3fr] gap-6 lg:gap-3 mb-8 border-b border-custom pb-8">
        <!-- Left Column: Top Stories (Order 2 on mobile, Order 1 on Desktop) -->
        <div class="lg:border-r border-custom lg:pr-3 text-left order-2 lg:order-1">
            <a href="/news-details" class="block group mb-5 last:mb-0 cursor-pointer text-left">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden"><img src="https://images.unsplash.com/photo-1512428559083-a401c4c34a1b?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h4 class="text-xl lg:text-2xl font-semibold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                    বিশ্ববাজারে তেলের দাম দ্বিগুণেরও বেশি বৃদ্ধির শঙ্কা
                </h4>
                <p class="text-sm lg:text-md text-desc font-medium leading-relaxed line-clamp-3 mt-1 text-left">
                    ইরানের বিরুদ্ধে যুক্তরাষ্ট্র ও ইসরায়েলের চলমান সামরিক অভিযানের জেরে বৈশ্বিক জ্বালানি সরবরাহ ব্যবস্থা মারাত্মকভাবে ব্যাহত হওয়ার আশঙ্কা দেখা দিয়েছে।
                </p>
            </a>
            
            <a href="/news-details" class="block group mb-5 last:mb-0 cursor-pointer border-t border-custom pt-5 text-left">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden"><img src="https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                    শেয়ার বাজারে বড় উত্থান: বিনিয়োগকারীদের মুখে হাসি
                </h4>
                <p class="text-sm text-desc font-medium leading-relaxed line-clamp-3 mt-1 text-left">
                    সপ্তাহের শেষ দিনে দেশের প্রধান পুঁজিবাজারে সূচকের বড় উল্লম্ফন দেখা দিয়েছে। লেনদেন ছাড়িয়েছে হাজার কোটি টাকা।
                </p>
            </a>

            <a href="/news-details" class="block group mb-5 last:mb-0 cursor-pointer border-t border-custom pt-5 text-left">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden"><img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                    বাংলাদেশে যাত্রা শুরু করল নতুন স্মার্ট সিটি প্রকল্প
                </h4>
                <p class="text-sm text-desc font-medium leading-relaxed line-clamp-3 mt-1 text-left">
                    রাজধানীর উপকণ্ঠে অত্যাধুনিক প্রযুক্তিনির্ভর স্মার্ট সিটি গড়ে তোলার কাজ শুরু হয়েছে। এতে থাকবে টেকসই জ্বালানি ও অটোমেশন ব্যবস্থা।
                </p>
            </a>

            <a href="/news-details" class="block group mb-5 last:mb-0 cursor-pointer border-t border-custom pt-5 text-left">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden"><img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                    শেয়ার বাজারে বড় উত্থান: বিনিয়োগকারীদের মুখে হাসি
                </h4>
                <p class="text-sm text-desc font-medium leading-relaxed line-clamp-3 mt-1 text-left">
                    সপ্তাহের শেষ দিনে দেশের প্রধান পুঁজিবাজারে সূচকের বড় উল্লম্ফন দেখা দিয়েছে। লেনদেন ছাড়িয়েছে হাজার কোটি টাকা।
                </p>
            </a>
            
            <a href="/news-details" class="block group mb-5 last:mb-0 cursor-pointer border-t border-custom pt-5 text-left">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 lg:hidden"><img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors mt-1 text-left text-title">
                    মহামারীর পরে বিশ্বের অর্থনীতি পুনর্গঠনে নতুন চ্যালেঞ্জ
                </h4>
                <p class="text-sm text-desc font-medium leading-relaxed line-clamp-3 mt-1 text-left">
                    বৈশ্বিক মন্দার আশঙ্কায় বড় দেশগুলো তাদের নীতিমালায় পরিবর্তন আনছে। এর প্রভাব পড়ছে বাংলাদেশের মতো উন্নয়নশীল দেশগুলোর রপ্তানি খাতে।
                </p>
            </a>
        </div>

        <!-- Center: Featured News (Order 1 on mobile, Order 2 on Desktop) -->
        <div class="order-1 lg:order-2 px-0 lg:px-2">
            <a href="/news-details" class="block group cursor-pointer">
                <div class="img-placeholder relative overflow-hidden aspect-[16/9] mb-4"><img src="https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=2070&auto=format&fit=crop" alt="Featured News" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <div class="text-center">
                    <h2 class="text-xl md:text-2xl font-semibold serif leading-tight text-center text-title group-hover:text-rose-600 transition-colors">
                        ইরানে ঢুকেছে হাজার হাজার কুর্দি যোদ্ধা, সরকার পতনে স্থল অভিযান শুরু
                    </h2>
                    <p class="text-desc leading-relaxed mt-1 mb-4 text-center line-clamp-2 font-medium px-6 md:px-0 max-w-[340px] md:max-w-none mx-auto">
                      ইরানের বিরুদ্ধে ইসরায়েল ও যুক্তরাষ্ট্রের যুদ্ধ বৃহস্পতিবার পর্যন্ত ষষ্ঠ দিনে গড়েছে। এরইমধ্যে মধ্যপ্রাচ্যে নতুন উত্তেজনা ছড়িয়ে পড়েছে...
                    </p>
                </div>
            </a>

            <!-- Sub-featured grid (1 column mobile, 2 columns desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4 pt-4 border-t border-custom">
                <a href="/news-details" class="block group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-video mb-3"><img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-base md:text-lg font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left">
                        লেবানন সীমান্তে তুমুল লড়াই, নিহত ১০ ইসরায়েলি সৈন্য
                    </h3>
                </a>
                <a href="/news-details" class="block group cursor-pointer mt-4 md:mt-0">
                    <div class="img-placeholder overflow-hidden aspect-video mb-3"><img src="https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-base md:text-lg font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left">
                        বাইডেনের কড়া হুঁশিয়ারি, মধ্যপ্রাচ্যে আরও সেনা মোতায়েন
                    </h3>
                </a>
            </div>

            <a href="/news-details" class="block group cursor-pointer mt-5 pt-5 border-t border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 md:hidden"><img src="https://images.unsplash.com/photo-1512753360435-0da6135807b4?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg md:text-xl font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left mb-2">
                    জাতিসংঘের সাধারণ অধিবেশনে ফের ফিলিস্তিন ইস্যু: বিশ্বনেতাদের উদ্বেগ ও নতুন প্রস্তাব
                </h3>
                <p class="text-desc text-sm leading-relaxed text-left line-clamp-2">
                    মধ্যপ্রাচ্যের বর্তমান অস্থিতিশীল পরিস্থিতি নিরসনে জাতিসংঘের পক্ষ থেকে একটি জরুরি পদক্ষেপের ঘোষণা দেওয়া হয়েছে। বিশ্বনেতারা মনে করছেন, এখনই কার্যকর কোনো ব্যবস্থা না নিলে পরিস্থিতি নিয়ন্ত্রণের বাইরে চলে যেতে পারে...
                </p>
            </a>

            <!-- More Full Width Items -->
            <a href="/news-details" class="block group cursor-pointer mt-5 pt-5 border-t border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 md:hidden"><img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg md:text-xl font-bold serif leading-snug text-title group-hover:text-rose-600 transition-colors text-left mb-2">
                    অ্যামাজনের গহীনে নতুন সভ্যতার সন্ধান: প্রত্নতাত্ত্বিকদের চমকপ্রদ আবিষ্কার
                </h3>
                <p class="text-desc text-sm leading-relaxed text-left line-clamp-2">
                    অ্যামাজন রেইনফরেস্টের গহীন জঙ্গলে লিডার প্রযুক্তির মাধ্যমে প্রাচীন এক শহরের ধ্বংসাবশেষ খুঁজে পাওয়া গেছে। বিজ্ঞানীরা ধারণা করছেন, এটি কয়েক হাজার বছর আগের কোনো উন্নত সভ্যতার অংশ ছিল যা এতদিন লোকচক্ষুর অন্তরালে ছিল...
                </p>
            </a>

           
        </div>

        <!-- Right: Trending / Newsletter / Ads (Order 3 on Mobile) -->
        <div class="md:border-l border-custom px-4 md:pl-3 md:px-0 text-left order-3 lg:order-3">
            <!-- Advertisement Section -->
            <div class="mb-4">
                <div class="space-y-4">
                    <!-- Ad 1 -->
                    <div class="img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/5] max-w-[280px] md:max-w-none mx-auto"><img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" onload="this.parentElement.classList.remove('img-placeholder')" >
                        <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-white/90 backdrop-blur-sm text-black text-[10px] font-bold px-3 py-1  uppercase">Shop Now</span>
                        </div>
                    </div>
                    
                    <!-- Ad 2 (Square/Horizontal) -->
                    <div class="img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-video max-w-[280px] md:max-w-none mx-auto"><img src="https://images.unsplash.com/photo-1491933382434-500287f9b54b?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" onload="this.parentElement.classList.remove('img-placeholder')" >
                        <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="bg-white/90 backdrop-blur-sm text-black text-[10px] font-bold px-3 py-1  uppercase">Learn More</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Opinion Section (Directly under Ads) -->
            <div class="mt-4">
                <div class="space-y-4">
                    <!-- Columnist 1 -->
                    <div class="group cursor-pointer">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" >
                            </div>
                            <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                পুলিশ ব্যবস্থার বর্তমান বাস্তবতা ও ভবিষ্যৎ পথরেখা
                            </h4>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1">
                            <svg class="w-3.5 h-3.5 text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-[12px] text-desc font-bold text-left ml-0 leading-none">ড. মো. রুহুল আমিন সরকার</span>
                        </div>
                    </div>

                    <!-- Columnist 2 -->
                    <div class="group cursor-pointer pt-4 border-t border-custom">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" >
                            </div>
                            <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                উচ্চশিক্ষার মানোন্নয়ন ও আগামীর চ্যালেঞ্জ
                            </h4>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1">
                            <svg class="w-3.5 h-3.5 text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-[12px] text-desc font-bold text-left ml-0 leading-none">অধ্যাপক ড. এম শাহিনুর রহমান</span>
                        </div>
                    </div>

                    <!-- Columnist 3 -->
                    <div class="group cursor-pointer pt-4 border-t border-custom">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="img-placeholder w-15 h-15  overflow-hidden shrink-0"><img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=100&h=100&auto=format&fit=crop" alt="Author" class="w-full h-full object-cover" onload="this.parentElement.classList.remove('img-placeholder')" >
                            </div>
                            <h4 class="text-lg font-bold text-title leading-snug group-hover:text-rose-600 transition-colors text-left">
                                নারীর ক্ষমতায়ন ও সামাজিক বিবর্তন
                            </h4>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1">
                            <svg class="w-3.5 h-3.5 text-desc" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-[12px] text-desc font-bold text-left ml-0 leading-none">ড. নীলুফার পারভীন</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Section: Politics (রাজনীতি) -->
    <section class="mt-8 lg:mt-12">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                রাজনীতি
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-0 lg:-mx-3">
            <!-- Politics Item 1 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm"><img src="https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?q=80&w=2070&auto=format&fit=crop" alt="Politics" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                    নির্বাচনী রোডম্যাপ ঘোষণা করল নির্বাচন কমিশন
                </h3>
                <p class="text-desc text-sm font-semibold  leading-relaxed text-left line-clamp-2">
                    আগামী সংসদ নির্বাচনকে সামনে রেখে নতুন রোডম্যাপ প্রকাশ করা হয়েছে। সকল দলের অংশগ্রহণ নিশ্চিত করতে নেওয়া হচ্ছে বিশেষ উদ্যোগ...
                </p>
            </div>

            <!-- Politics Item 2 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm"><img src="https://images.unsplash.com/photo-1541872703-74c5e443d1f9?q=80&w=2070&auto=format&fit=crop" alt="Politics" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                    সরকারের নতুন উন্নয়ন প্রকল্পের অনুমোদন
                </h3>
                <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2">
                    অর্থনৈতিক সমৃদ্ধি ত্বরান্বিত করতে আরও ১০টি মেগা প্রকল্পের চূড়ান্ত অনুমোদন দিয়েছে মন্ত্রিপরিষদ। এটি বাস্তবায়ন হলে কর্মসংস্থান বাড়বে...
                </p>
            </div>

            <!-- Politics Item 3 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm"><img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop" alt="Politics" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                    বিরোধী দলের নেতাদের সাথে বৈঠকের আহ্বান
                </h3>
                <p class="text-desc text-sm font-semibold  leading-relaxed text-left line-clamp-2">
                    রাজনৈতিক অস্থিতিশীলতা কাটাতে এবং সংলাপে বসার জন্য সরকারি দলের পক্ষ থেকে আনুষ্ঠানিকভাবে চিঠি দেওয়া হয়েছে। আলোচনার অপেক্ষায় দেশ...
                </p>
            </div>

            <!-- Politics Item 4 -->
            <div class="group cursor-pointer lg:px-3">
                <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm"><img src="https://images.unsplash.com/photo-1577416416829-d4414004386a?q=80&w=1974&auto=format&fit=crop" alt="Politics" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                    নতুন রাজনৈতিক জোট গঠন, শুরু হচ্ছে আন্দোলন
                </h3>
                <p class="text-desc text-sm  font-semibold leading-relaxed text-left line-clamp-2">
                    অধিকার আদায়ের লক্ষ্যে সমমনা ৪টি রাজনৈতিক দল মিলে নতুন জোট গঠন করেছে। আগামী সপ্তাহ থেকে দেশব্যাপী বিক্ষোভ মিছিলের ঘোষণা...
                </p>
            </div>
        </div>
    <!-- Section: National (জাতীয়) -->
    <section class="mt-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                জাতীয়
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[5.5fr_3fr_3.5fr] gap-3">
            <!-- Left Column (Wide) -->
            <div class="space-y-6">
                <div class="group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-[16/10] mb-2 relative shadow-sm"><img src="https://images.unsplash.com/photo-1588196749597-9ff075ee6b5b?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-1.5">
                        মেট্রোরেলের নতুন রুট উদ্বোধন: বদলে যাচ্ছে রাজধানীর যাতায়াত দৃশ্যপট
                    </h3>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left">
                        প্রধানমন্ত্রী আজ সকালে মেট্রোরেলের নতুন বর্ধিত অংশের উদ্বোধন করেছেন। এর ফলে মতিঝিল থেকে উত্তরা পর্যন্ত যেতে সময় লাগবে মাত্র ৩০ মিনিট। আধুনিক এই যাতায়াত ব্যবস্থা রাজধানীর যানজট নিরসনে বিশাল ভূমিকা রাখবে বলে আশা করা হচ্ছে...
                    </p>
                </div>
            </div>

            <!-- Middle Column (Narrow) -->
            <div class="space-y-6">
                <!-- Item 1 -->
                <div class="group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1589923188900-85dae523342b?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        উপকূলীয় অঞ্চলে লোনা পানি বাড়ছে, হুমকির মুখে কৃষি
                    </h3>
                </div>
                
                <!-- Item 2 -->
                <div class="pt-3 border-t border-custom group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1504198453319-5ce911baf2ef?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        সারাদেশে ডেঙ্গু পরিস্থিতির অবনতি, হাসপাতালে বাড়ছে ভিড়
                    </h3>
                </div>
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
                <!-- সর্বশেষ Panel -->
                <div id="panel-latest" class="space-y-4">
                <!-- Item 1 -->
                <div class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">১.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            ডিজিটাল জনশুমারি: নতুন তথ্যে পাল্টে গেল জনসংখ্যা হিসাব
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1590602847861-f357a9332bbc?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">২.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            রেমিট্যান্স প্রবাহে জোয়ার: স্বস্তিতে অর্থনীতি ও নতুন সম্ভাবনা
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৩.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            সাভারে তৈরি পোশাক কারখানায় অগ্নিকাণ্ড, নিয়ন্ত্রণে ৫ ইউনিট
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1582139329536-e7284fece509?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৪.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            টাকা পাচার রোধে কড়াকড়ি, নজরদারিতে প্রভাবশালীরা
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1554224155-1696413565d3?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="group cursor-pointer flex items-start gap-4 pb-4 border-b border-custom last:border-0 last:pb-0">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৫.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            সারাদেশে শৈত্যপ্রবাহের পূর্বাভাস, জেঁকে বসতে পারে শীত
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1477601263368-1823bb1643df?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="group cursor-pointer flex items-start gap-4">
                    <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৬.</span>
                    <div class="flex-1">
                        <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            বন্যায় ক্ষতিগ্রস্তদের পুনর্বাসনে সরকারের নতুন প্যাকেজ ঘোষণা
                        </h4>
                    </div>
                    <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1547683905-f686c993aae5?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                </div>
                </div>

                <!-- পঠিত Panel (hidden by default) -->
                <div id="panel-popular" class="space-y-4 hidden">
                    <div class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">১.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                বিশ্ববিদ্যালয়গুলোতে ভর্তির নতুন নীতিমালা চূড়ান্ত হচ্ছে
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                    <div class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">২.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                পদ্মা সেতুতে রেকর্ড যানবাহন, একদিনে আয় ৬ কোটি টাকা
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                    <div class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৩.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                টি-টোয়েন্টিতে বাংলাদেশের ঐতিহাসিক জয়, দেশজুড়ে উৎসব
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1540747913346-19212a4b32a1?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                    <div class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৪.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                দেশে প্রথমবার সরকারি হাসপাতালে রোবোটিক সার্জারি সফল
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                    <div class="group cursor-pointer flex items-start gap-3 pb-3 border-b border-custom">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৫.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                চাঁদপুরে ইলিশ আহরণে নতুন রেকর্ড, কমছে দাম
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1559628233-100c798642fd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                    <div class="group cursor-pointer flex items-start gap-3">
                        <span class="text-3xl font-bold text-gray-300 serif shrink-0 leading-none">৬.</span>
                        <div class="flex-1">
                            <h4 class="text-base font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                দেশীয় পণ্যের রপ্তানি বেড়েছে ১৮%, নতুন বাজার উন্মোচন
                            </h4>
                        </div>
                        <div class="img-placeholder w-20 h-14 overflow-hidden shrink-0 shadow-sm"><img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Capital (রাজধানী) -->
    <section class="mt-5 lg:mt-20 border-b border-custom pb-6">
        <div class="flex items-center justify-between mb-5 md:pt-8 pt-5 border-t border-custom">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                রাজধানী
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-0 lg:-mx-3">
            <!-- Capital Item 1 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1596422846543-75c6fc183f27?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-2 mb-1.5">
                    রাজধানীর জলাবদ্ধতা নিরসনে নতুন ড্রেনেজ মাস্টারপ্ল্যান
                </h3>
                <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2">
                    বর্ষা মৌসুমে ঢাকার পানি নিষ্কাশন ব্যবস্থা উন্নত করতে উত্তর ও দক্ষিণ সিটি কর্পোরেশন যৌথভাবে নতুন প্রকল্পের কাজ শুরু করেছে...
                </p>
            </div>

            <!-- Capital Item 2 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1555620201-dcae47bb0bc6?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-2 mb-1.5">
                    বায়ু দূষণে আবারও শীর্ষে ঢাকা, স্বাস্থ্য ঝুঁকির সতর্কতা
                </h3>
                <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2">
                    আজ সকালে ঢাকার বাতাসের মান অত্যন্ত অস্বাস্থ্যকর পর্যায়ে পোঁছেছে। শিশুদের ও প্রবীণদের ঘরের বাইরে বের হওয়ার ক্ষেত্রে সতর্কতা দেওয়া হয়েছে...
                </p>
            </div>

            <!-- Capital Item 3 -->
            <div class="group cursor-pointer lg:px-3 lg:border-r border-custom">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1570126618953-d437176e8c79?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-2 mb-1.5">
                    হাতিরঝিলে নতুন বিনোদন কেন্দ্র গড়ে তোলার পরিকল্পনা
                </h3>
                <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2">
                    পর্যটকদের আকর্ষণ বাড়াতে হাতিরঝিল লেক ঘিরে আধুনিক আলোকসজ্জা ও সাংস্কৃতিক মঞ্চ তৈরির কাজ শুরু হতে যাচ্ছে আগামী মাস থেকে...
                </p>
            </div>

            <!-- Capital Item 4 -->
            <div class="group cursor-pointer lg:px-3">
                <div class="img-placeholder overflow-hidden aspect-video mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1621245104033-68d277761034?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                </div>
                <h3 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-2 mb-1.5">
                    পুরান ঢাকার ঐতিহ্য রক্ষায় শুরু হচ্ছে সংস্কার কাজ
                </h3>
                <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2">
                    ঐতিহাসিক ভবন ও এলাকাগুলোর প্রাচীন স্থাপত্য ঠিক রেখে সংস্কারের উদ্যোগ নিয়েছে রাজউক ও সিটি কর্পোরেশন...
                </p>
            </div>
        </div>
    </section>

    <!-- Section: Sports (খেলা) -->
    <section class="mt-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                খেলা
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 space-y-3 md:space-y-0 lg:gap-0 lg:-mx-3">
            <!-- Sports Left Column -->
            <div class="lg:px-3 lg:border-r border-custom space-y-4">
                <!-- Large Featured Item -->
                <div class="group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-video mb-2 relative shadow-sm"><img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title mb-1">
                       উত্তর কোরিয়াকে রুখতে প্রস্তুত লাল-সবুজের মেয়েরা, বাটলার বললেন-‘আই হ্যাভ আ প্ল্যান’
                    </h3>
                    <p class="text-desc text-base font-semibold leading-relaxed text-left line-clamp-2">
                        অসাধারণ দলীয় নৈপুণ্যে শক্তিশালী প্রতিপক্ষকে হারিয়ে পয়েন্ট টেবিলে এগিয়ে গেল লাল-সবুজের প্রতিনিধিরা...
                    </p>
                </div>

                <!-- Secondary Item (Middle Column Style) -->
                <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1518063319789-7217e6706b04?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-semibold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            টেনিস: অস্ট্রেলিয়ান ওপেনের ফাইনালে মুখোমুখি নোভাক ও রাফা
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        বছরের প্রথম গ্র্যান্ড স্ল্যাম জয়ের লড়াইয়ে কাল কোর্টে নামবেন দুই কিংবদন্তি খেলোয়াড়...
                    </p>
                </div>
            </div>

            <!-- Sports Middle Column (3 Items) -->
            <div class="lg:px-3 lg:border-r border-custom space-y-2">
                <!-- Item 2.1 -->
                <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1540747913346-19e3ad643662?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            আইপিএল নিলামে ইতিহাস গড়লেন বাংলাদেশের তরুণ পেসার
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        সব রেকর্ড ভেঙে রেকর্ড মূল্যে কেকেআরে জায়গা করে নিলেন টাইগারদের এই নতুন পেস সেনসেশন...
                    </p>
                </div>

                <!-- Item 2.2 -->
                <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            পিএসজি ছেড়ে মায়ামিতেই থাকছেন মেসি, নিশ্চিত করল ক্লাব
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        নতুন মৌসুমেও যুক্তরাষ্ট্রের ক্লাবেই দেখা যাবে আর্জেন্টাইন খুদে জাদুকরকে, সব জল্পনার অবসান...
                    </p>
                </div>

                <!-- Item 2.3 -->
                <div class="group cursor-pointer last:border-0 last:pb-0">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1517649763962-0c623066013b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mt-0.5">
                            ওলিম্পিক গেমসের প্রস্তুতিতে মুখরিত প্যারিস, নিরাপত্তা জোরদার
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        আগামী বছরের বিশ্ব ইভেন্টকে সামনে রেখে নিরাপত্তার চাদরে ঢাকা হচ্ছে পুরো ফ্রান্সের রাজধানী...
                    </p>
                </div>
            </div>

            <!-- Sports Right Column (4 Horizontal Items) -->
            <div class="lg:px-3 space-y-3">
                <!-- Right Item 1 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1575361204480-aadea25e6e68?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            বিপিএলের নতুন সূচি ঘোষণা, উদ্বোধনী ম্যাচে মুখোমুখি ঢাকা-কুমিল্লা
                        </h4>
                    </div>
                </div>
                <!-- Right Item 2 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1522778119026-d647f0596c20?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            সাফ চ্যাম্পিয়নশিপ: সেমিফাইনালের লক্ষ্যে কাল মাঠে নামবে সাবিনারা
                        </h4>
                    </div>
                </div>
                <!-- Right Item 3 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1560272564-c83b66b1ad12?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            প্রিমিয়ার লিগ: আর্সেনালকে হারিয়ে শীর্ষে ফিরল ম্যানচেস্টার সিটি
                        </h4>
                    </div>
                </div>
                <!-- Right Item 4 -->
                <div class="group cursor-pointer last:border-0 last:pb-0">
                    <div class="flex gap-2 lg:gap-4">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-20 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            চ্যাম্পিয়ন্স লিগ: শেষ মুহূর্তের গোলে নাটকীয় জয় রিয়ালের
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Countrywide (সারাদেশ) -->
    <section class="mt-10 border-t border-custom pt-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                সারাদেশ
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-y-8 lg:gap-0 lg:-mx-3">
            <!-- Main Content Area (9 Columns) -->
            <div class="lg:col-span-9 lg:px-3">
                <!-- Top Row: 6 + 3 -->
                <div class="grid grid-cols-1 lg:grid-cols-9 lg:-mx-3">
                    <!-- Featured (6 Columns) -->
                    <div class="lg:col-span-6 lg:px-3 lg:border-r border-custom mb-6 lg:mb-0">
                        <div class="group cursor-pointer">
                            <div class="img-placeholder overflow-hidden aspect-video mb-4 relative shadow-sm"><img src="https://images.unsplash.com/photo-1585647347384-2593bc35786b?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                            </div>
                            <h3 class="text-3xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-4">
                                সিলেটে চাবাগানগুলোয় হাসি ফুটেছে শ্রমিকদের মুখে, উৎপাদন ছাড়িয়েছে লক্ষ্যমাত্রা
                            </h3>
                            <p class="text-desc text-lg font-semibold leading-relaxed text-left line-clamp-3 hidden md:block">
                                আবহাওয়া অনুকূলে থাকায় এবার চায়ের বাম্পার ফলন হয়েছে। চা বোর্ডের তথ্য অনুযায়ী, গত বছরের তুলনায় এবারের উৎপাদন ১৫ শতাংশ বেশি। বাগানগুলোর আধুনিকায়ন এবং শ্রমিকদের জীবনমান উন্নয়নে নেওয়া হয়েছে নতুন নতুন পদক্ষেপ...
                            </p>
                        </div>
                    </div>

                    <!-- Middle Column: Vertical Items (3 Columns) -->
                    <div class="lg:col-span-3 lg:px-3 space-y-2">
                        <!-- Middle Item 1 -->
                        <div class="group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                            <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1594391484110-305898089201?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                </div>
                                <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    বরগুনায় ইলিশের অভাব ঘুচছে, বাজারে প্রচুর সরবরাহ
                                </h4>
                            </div>
                        </div>
                        <!-- Middle Item 2 -->
                        <div class="group cursor-pointer">
                            <div class="flex flex-row lg:block gap-2 lg:gap-0">
                                <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1508962914676-134849a727f0?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                </div>
                                <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    রাজশাহীর আম যাচ্ছে ইউরোপে, গর্বিত স্থানীয় আমচাষিরা
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: 3 equal columns -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-3 lg:gap-6 mt-4 pt-4 border-t border-custom">
                    <!-- Bottom Item 1 -->
                    <div class="">
                        <div class="group cursor-pointer pb-3 border-b border-custom md:border-b-0 md:pb-0">
                            <div class="flex flex-row md:block gap-2 md:gap-0">
                                <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2"><img src="https://images.unsplash.com/photo-1566378246598-5b11a0ff7f6c?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                </div>
                                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    পটুয়াখালীতে নতুন বিমানবন্দর নির্মাণের কাজ এগিয়ে চলছে দ্রুতগতিতে
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- Bottom Item 2 -->
                    <div class="">
                        <div class="group cursor-pointer pb-3 border-b border-custom md:border-b-0 md:pb-0">
                            <div class="flex flex-row md:block gap-2 md:gap-0">
                                <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2"><img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                </div>
                                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    চট্টগ্রামে পাহাড় রক্ষা অভিযানে অবৈধ স্থাপনা উচ্ছেদ, জেল-জরিমানা
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- Bottom Item 3 -->
                    <div class="">
                        <div class="group cursor-pointer">
                            <div class="flex flex-row md:block gap-2 md:gap-0">
                                <div class="img-placeholder w-36 h-24 md:w-full md:h-auto md:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 md:mb-2"><img src="https://images.unsplash.com/photo-1596401057633-5310bad1d5f6?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                </div>
                                <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                                    বগুড়ার দই এখন সারাবিশ্বে সমাদৃত, রপ্তানি বাড়ছে পাল্লা দিয়ে
                                </h4>
                            </div>
                        </div>
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
                            <select class="w-full border-custom  text-sm focus:ring-rose-500 focus:border-rose-500 py-2.5 bg-white">
                                <option>বিভাগ নির্বাচন করুন</option>
                                <option>ঢাকা</option>
                                <option>চট্টগ্রাম</option>
                                <option>রাজশাহী</option>
                                <option>খুলনা</option>
                                <option>বরিশাল</option>
                                <option>সিলেট</option>
                                <option>রংপুর</option>
                                <option>ময়মনসিংহ</option>
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
                        <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3  transition-colors mt-4 shadow-md flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            খুঁজুন
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: World News (বিশ্ব সংবাদ) -->
    <section class="mt-12 border-t border-custom pt-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                বিশ্ব সংবাদ
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-[5.6fr_2.5fr_3.9fr] gap-y-10 lg:gap-0 lg:-mx-3">
            <!-- World News: Featured (5.25 Columns) -->
            <div class="lg:px-3 lg:border-r border-custom">
                <div class="group cursor-pointer">
                    <div class="img-placeholder overflow-hidden aspect-video mb-2 relative shadow-sm"><img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?q=80&w=2066&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                        জলবায়ু সম্মেলনে ঐতিহাসিক চুক্তি: কার্বন নিঃসরণ হ্রাসে একমত ২০টি দেশ
                    </h3>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-3">
                        বিশ্বের প্রভাবশালী দেশগুলো পরিবেশ রক্ষায় এক নতুন দিগন্তের উন্মোচন করেছে। এবারের সম্মেলনে প্যারিস জলবায়ু চুক্তির লক্ষ্যমাত্রা অর্জনে আরও কঠোর পদক্ষেপ নেওয়ার প্রতিশ্রুতি দিয়েছে উন্নত রাষ্ট্রগুলো...
                    </p>
                </div>
            </div>

            <!-- World News: Middle (2.5 Columns) -->
            <div class="lg:px-3 lg:border-r border-custom space-y-3">
                <!-- Middle Item 1 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 last:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1577017040065-650ee4d43339?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug lg:leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5 lg:mt-0">
                            মধ্যপ্রাচ্যে নতুন শান্তি আলোচনার উদ্যোগ নিলো জাতিসংঘ
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        দীর্ঘদিনের সংঘাত নিরসনে এবং মানবিক সহায়তা নিশ্চিতে নতুন করে কূটনৈতিক তৎপরতা শুরু হয়েছে মধ্যপ্রাচ্যে...
                    </p>
                </div>
                <!-- Middle Item 2 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 last:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug lg:leading-snug group-hover:text-rose-600 transition-colors text-left text-title mt-0.5 lg:mt-0">
                            কৃত্রিম বুদ্ধিমত্তা নিয়ন্ত্রণে ইউরোপীয় ইউনিয়নে নতুন আইন পাস
                        </h4>
                    </div>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-2 hidden md:block mt-1">
                        প্রযুক্তির অপব্যবহার রোধে এবং জননিরাপত্তা নিশ্চিত করতে বিশে প্রথমবারের মতো এআই নিয়ন্ত্রণ আইন চালু করল ইইউ...
                    </p>
                </div>
            </div>

            <!-- World News: Right (3.9 Columns) -->
            <div class="lg:px-3 space-y-3">
                <!-- Right Item 1 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2">
                        <div class="img-placeholder w-36 h-24 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1451187534959-425632749c8d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            চাঁদে বসতি স্থাপনের লক্ষ্যে নাসার নতুন অভিযান শুরু
                        </h4>
                    </div>
                </div>
                <!-- Right Item 2 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2">
                        <div class="img-placeholder w-36 h-24 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1621245104033-68d277761034?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            বৈশ্বিক মন্দা কাটিয়ে প্রবৃদ্ধির পথে ফিরছে এশিয়ার অর্থনীতি
                        </h4>
                    </div>
                </div>
                <!-- Right Item 3 -->
                <div class="group cursor-pointer pb-4 border-b border-custom last:border-0 lg:pb-3">
                    <div class="flex gap-2">
                        <div class="img-placeholder w-36 h-24 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                             পরিবেশ রক্ষায় কৃত্রিম বন তৈরিতে জাপানের সাফল্য
                        </h4>
                    </div>
                </div>
                <!-- Right Item 4 -->
                <div class="group cursor-pointer last:border-0 last:pb-0">
                    <div class="flex gap-2">
                        <div class="img-placeholder w-36 h-24 shrink-0 overflow-hidden shadow-sm"><img src="https://images.unsplash.com/photo-1444653614773-995cb1ef9efa?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            ইউক্রেন ট্রাস্ট ফান্ডের জন্য ইউরোপীয় ইউনিয়নের বড় ঘোষণা
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Entertainment (বিনোদন) -->
    <section class="mt-12 border-t border-custom pt-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-semibold serif text-title relative inline-block">
                বিনোদন
                <span class="absolute -bottom-2 left-0 w-1/2 h-1 bg-rose-600"></span>
            </h2>
            <a href="#" class="text-rose-600 font-bold text-sm hover:underline">আরও খবর →</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-10 lg:gap-0 lg:-mx-3">
            <!-- Left Column: Horizontal Items -->
            <div class="lg:px-3 lg:border-r border-custom space-y-4">
                <!-- Item 1 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1493225255756-d9584f8606e9?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                      ইন্টারভিউ থেকে বিরত থাকতে চাই, বলি একটা লিখে আরেকটা: রবি চৌধুরী
                    </h4>
                </div>
                <!-- Item 2 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        কান চলচ্চিত্র উৎসবে প্রশংসিত বাংলাদেশী সিনেমা 'রেহানা'
                    </h4>
                </div>
                <!-- Item 3 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1598899464044-8c0f1d429a4a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        বলিউডে পা রাখছেন দক্ষিণ ভারতের জনপ্রিয় নায়িকা রশ্মিকা
                    </h4>
                </div>
                <!-- Item 4 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        ডিসেম্বরে নতুন সিনেমা নিয়ে আসছেন ঢাকাই সিনেমার কিং খান
                    </h4>
                </div>
            </div>

            <!-- Middle Column: Featured Vertical Item -->
            <div class="lg:px-3 lg:border-r  border-custom">
                <div class="group cursor-pointer">
                    <div class="img-placeholder overflow-hidden h-84 mb-3 relative shadow-sm"><img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h3 class="text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors text-left text-title mb-2">
                        অস্কারের দৌঁড়ে এগিয়ে যে সিনেমাগুলো, কার মুখে হাসি ফুটবে শেষ পর্যন্ত?
                    </h3>
                    <p class="text-desc text-sm font-semibold leading-relaxed text-left line-clamp-3">
                        আগামী মাসে অনুষ্ঠিত হতে যাওয়া অস্কার নিয়ে বিশ্বব্যাপী উত্তাপ বাড়ছে। সমালোচকদের মতে এবার হাড্ডাহাড্ডি লড়াই হবে হলিউডের সেরা দুই সিনেমার মধ্যে...
                    </p>
                </div>
            </div>

            <!-- Right Column: Horizontal Items -->
            <div class="lg:px-3 space-y-4">
                <!-- Item 1 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1511730991916-16629ec237b6?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        ছোট পর্দায় ফিরছেন মেহজাবীন, শুরু করেছেন নতুন নাটকের শুটিং
                    </h4>
                </div>
                <!-- Item 2 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1514525253361-b5508ef19d7d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        কনসার্টে গান গাইতে গাইতে মঞ্চেই কান্নায় ভেঙে পড়লেন আরজিৎ সিং
                    </h4>
                </div>
                <!-- Item 3 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        ডিসেম্বরে নতুন সিনেমা নিয়ে আসছেন ঢাকাই সিনেমার কিং খান
                    </h4>
                </div>
                <!-- Item 4 -->
                <div class="group cursor-pointer pb-3 border-b border-custom last:border-0 flex gap-2 lg:gap-4">
                    <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                    </div>
                    <h4 class="text-lg font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                        কান চলচ্চিত্র উৎসবে প্রশংসিত বাংলাদেশী সিনেমা 'রেহানা'
                    </h4>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Lifestyle, Tech, Different Eyes (লাইফস্টাইল, টেক, ভিন্নচোখে) -->
    <section class="mt-12 border-t border-custom pt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-10 lg:gap-0 lg:-mx-3">
            <!-- Column 1: Lifestyle (লাইফস্টাইল) -->
            <div class="lg:px-3 lg:border-r border-custom">
                <div class="mb-6">
                    <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">লাইফস্টাইল</h3>
                </div>
                
                <!-- Lifestyle: Featured -->
                <div class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            সুস্থ থাকতে প্রতিদিনের খাবারের তালিকায় রাখুন এই পাঁচটি খাবার
                        </h4>
                    </div>
                </div>

                <!-- Lifestyle: List -->
                <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            গৃহসজ্জায় ইনডোর প্ল্যান্টের ব্যবহার যেভাবে করবেন
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1445205170230-053b830c6050?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            শীতকালীন ফ্যাশনে নজরকাড়া কিছু টিপস
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            ভ্রমণে সাবধানতা: শীতকালে পাহাড়ে যাওয়ার আগে যা জানবেন
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Column 2: Tech (টেক) -->
            <div class="lg:px-3 lg:border-r border-custom">
                <div class="mb-6">
                    <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">টেক</h3>
                </div>
                
                <!-- Tech: Featured -->
                <div class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            ভবিষ্যৎ প্রযুক্তি: এআই যেভাবে আমাদের জীবন বদলে দিচ্ছে
                        </h4>
                    </div>
                </div>

                <!-- Tech: List -->
                <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            অ্যাপল আনছে তাদের পরবর্তী প্রজন্মের ভাঁজযোগ্য স্মার্টফোন
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            বাজেটের মধ্যে সেরা পাঁচটি ল্যাপটপের খোঁজ
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            সাশ্রীয়ী মূল্যে সেরা পাঁচটি স্মার্টওয়াচ এখন বাজারে
                        </h5>
                    </div>
                </div>
            </div>

            <!-- Column 3: Different Eyes (ভিন্নচোখে) -->
            <div class="lg:px-3">
                <div class="mb-6">
                    <h3 class="text-xl font-bold serif text-title border-b-2 pb-2 border-rose-600 inline-block">ভিন্নচোখে</h3>
                </div>
                
                <!-- Different Eyes: Featured -->
                <div class="group cursor-pointer mb-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-3"><img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            সবুজ পাহাড়ের কোলে ছোট্ট এক গ্রাম, যেখানে সময় থমকে আছে
                        </h4>
                    </div>
                </div>

                <!-- Different Eyes: List -->
                <div class="space-y-2 border-t border-custom pt-2 lg:border-t-0 lg:pt-0">
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            হারিয়ে যাওয়া লোককলা: যে শিল্প আজ প্রায় বিলুপ্তির পথে
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1433086566547-0230f2df24e4?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            সমুদ্রের অতল গহ্বরে লুকিয়ে থাকা অদ্ভুত কিছু প্রাণী
                        </h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-3 pb-2 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-40 lg:h-23 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=200&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors text-left text-title">
                            অজানাকে জানা: আমাজনের গহীন জঙ্গলে লুকানো রহস্য
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Tabbed Content (প্রজন্ম, ক্যাম্পাস, চাকরি) -->
    <section class="mt-12 border-t border-custom pt-8">
        <!-- Tabs Header -->
        <div class="flex items-center gap-8 border-b border-custom mb-8 overflow-x-auto whitespace-nowrap scrollbar-hide">
            <button onclick="switchTopicTab('projonmo')" id="tab-projonmo" class="text-xl font-bold serif pb-3 border-b-2 border-rose-600 text-rose-600 transition-all duration-300">প্রজন্ম</button>
            <button onclick="switchTopicTab('campus')" id="tab-campus" class="text-xl font-bold serif pb-3 border-b-2 border-transparent text-gray-500 hover:text-rose-600 transition-all duration-300">ক্যাম্পাস</button>
            <button onclick="switchTopicTab('chakri')" id="tab-chakri" class="text-xl font-bold serif pb-3 border-b-2 border-transparent text-gray-500 hover:text-rose-600 transition-all duration-300">চাকরি</button>
        </div>

        <!-- Tab Panels Container -->
        <div id="projonmo-panel" class="topic-panel">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <!-- Col 1: Big Vertical -->
                <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1529156069811-37f227566197?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">তরুণদের হাত ধরেই বদলে যাচ্ছে বাংলাদেশের স্টার্টআপ ইকোসিস্টেম</h4>
                    </div>
                </div>
                <!-- Col 2: Horizontal List -->
                <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">সামাজিক কাজে সম্পৃক্ততা: কেন এটি তরুণদের জন্য জরুরি</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">তরুণ প্রজন্মের দক্ষতা বৃদ্ধিতে নতুন উদ্যোগ</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1523240715639-99a808e9956b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ডিজিটাল যুগে তরুণদের মানসিক স্বাস্থ্য সচেতনতা</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ভবিষ্যৎ ক্যারিয়ার গড়ার প্রথম ধাপ: ইন্টার্নশিপের গুরুত্ব</h5>
                    </div>
                </div>

                <!-- Col 3: Horizontal List -->
                <div class="space-y-4">
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">নতুন প্রজন্মের ভাবনায় আগামীর সমৃদ্ধ বাংলাদেশ</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">উদ্যোক্তা হওয়ার স্বপ্নে বিভোর একদল সাহসী তরুণ</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">প্রযুক্তির উৎকর্ষতায় নতুন প্রজন্মের সৃজনশীলতা</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">কমিউনিটি সেবায় তরুণদের অংশগ্রহণ বাড়ছে</h5>
                    </div>
                </div>
            </div>
        </div>

        <div id="campus-panel" class="topic-panel hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <!-- Col 1: Big Vertical -->
                <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1541339907198-e08759dfc3f0?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">বিশ্ববিদ্যালয় র্যাঙ্কিংয়ে দেশের শীর্ষ প্রতিষ্ঠানের অভাবনীয় সাফল্য</h4>
                    </div>
                </div>
                <!-- Col 2: Horizontal List -->
                <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ক্যাম্পাসে বিতর্ক প্রতিযোগিতার আসর: সেরাদের লড়াই</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1523240715639-99a808e9956b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">বিশ্ববিদ্যালয় ভর্তি পরীক্ষার সর্বশেষ আপডেট</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ক্যাম্পাস প্রাঙ্গণে সাংস্কৃতিক উৎসবের আমেজ</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1525921429624-479b6a29d84c?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">গবেষণায় আগ্রহী হচ্ছেন বিশ্ববিদ্যালয় শিক্ষার্থীরা</h5>
                    </div>
                </div>

                <!-- Col 3: Horizontal List -->
                <div class="space-y-3">
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1491438590914-bc09fcaaf77a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">হল রাজনীতি থেকে দূরে থাকতে শিক্ষার্থীদের নতুন আহ্বান</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ক্যাম্পাস ক্যারিয়ার ফেয়ারে চাকরির হাতছানি</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1501503060800-50284814362a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">শিক্ষার্থীদের যাতায়াত দুর্ভোগ কমাতে নতুন বাস সার্ভিস</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">লাইব্রেরিতে পড়ার পরিবেশ উন্নত করার উদ্যোগ</h5>
                    </div>
                </div>
            </div>
        </div>

        <div id="chakri-panel" class="topic-panel hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <!-- Col 1: Big Vertical -->
                <div class="group cursor-pointer lg:border-r border-custom lg:pr-3 pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-86 shrink-0 overflow-hidden relative shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h4 class="text-2xl font-bold serif leading-snug group-hover:text-rose-600 transition-colors">চাকরিতে আবেদনের শেষ মুহূর্তের প্রস্তুতি যেভাবে নেবেন</h4>
                    </div>
                </div>
                <!-- Col 2: Horizontal List -->
                <div class="space-y-3 lg:border-r border-custom lg:pr-3">
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">বিসিএস ভাইভায় ভালো করার কিছু পরীক্ষিত কৌশল</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1486312338219-ce68d2c6f44d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ব্যাংক জবে আবেদনের জন্য প্রয়োজনীয় প্রস্তুতি</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-2 lg:gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-36 h-24 lg:w-32 lg:h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1521791136364-798a730bb3be?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">মাল্টিন্যাশনাল কোম্পানিতে ক্যারিয়ার গড়ার সুযোগ</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-32 h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1507679799987-c7377ec486b6?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">চাকরির বাজারে প্রতিযোগিতায় টিকে থাকার উপায়</h5>
                    </div>
                </div>

                <!-- Col 3: Horizontal List -->
                <div class="space-y-3">
                    <div class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-32 h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1507679799987-c7377ec486b6?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">ফ্রিল্যান্সিং ক্যারিয়ার: শুরু করবেন যেভাবে</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-32 h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">আইটি সেক্টরে ক্রমবর্ধমান চাকরির চাহিদা</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-32 h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">বিদেশে উচ্চশিক্ষার পর চাকরির সম্ভাবনা</h5>
                    </div>
                    <div class="group cursor-pointer flex gap-4 pb-3 border-b border-custom last:border-0 last:pb-0">
                        <div class="img-placeholder w-32 h-18 shrink-0 overflow-hidden relative shadow-sm"><img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                        </div>
                        <h5 class="text-base font-semibold serif leading-snug group-hover:text-rose-600 transition-colors">সরকারি চাকরিতে নতুন নিয়োগ বিজ্ঞপ্তি</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Video (ভিডিও) -->
    <section class="py-8 border-t border-custom mt-4">
        <div class="">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="text-2xl font-bold serif text-gray-900">ভিডিও</h2>
                <div class="h-1 flex-grow bg-rose-600"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Main Video: 7 Cols -->
                <div class="lg:col-span-7 group cursor-pointer pb-4 border-b border-custom lg:border-0 lg:pb-0">
                    <div class="flex flex-row lg:block gap-2 lg:gap-0">
                        <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0"><img src="https://images.unsplash.com/photo-1502481851512-e9e2529bbbf9?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')" >
                            <!-- Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-10 h-10 lg:w-16 lg:h-16 bg-rose-600 flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 lg:w-8 lg:h-8 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        </div>
                        <h3 class="text-xl lg:text-2xl font-bold serif leading-tight group-hover:text-rose-600 transition-colors line-clamp-2 lg:line-clamp-1 lg:mt-3">যৌথ বাহিনীর অভিযানে ট্যাংকের ভেতর থেকে বিএনপি নেতা মোল্লাসহ আটক ৭</h3>
                    </div>
                </div>

                <!-- Side Videos: 5 Cols -->
                <div class="lg:col-span-5">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-3 lg:gap-4">
                        <!-- Video 1 -->
                        <div class="group cursor-pointer flex gap-2 lg:block pb-3 border-b border-custom last:border-0 lg:border-0 lg:pb-0">
                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-10 h-10 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white border border-custom/20 group-hover:bg-rose-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-base lg:text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors line-clamp-2">প্রযুক্তির নতুন দিগন্ত: এআই বিপ্লব ও তার অভাবনীয় প্রভাব</h4>
                        </div>
                        <!-- Video 2 -->
                        <div class="group cursor-pointer flex gap-2 lg:block pb-3 border-b border-custom last:border-0 lg:border-0 lg:pb-0">
                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-10 h-10 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white border border-custom/20 group-hover:bg-rose-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-base lg:text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors line-clamp-2">সফল উদ্যোক্তার গল্প: শূন্য থেকে সাফল্যের শিখরে আরোহণের রহস্য</h4>
                        </div>
                        <!-- Video 3 -->
                        <div class="group cursor-pointer flex gap-2 lg:block pb-3 border-b border-custom last:border-0 lg:border-0 lg:pb-0">
                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-10 h-10 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white border border-custom/20 group-hover:bg-rose-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-base lg:text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors line-clamp-2">তারুণ্যের ভাবনা: আগামীর সমৃদ্ধ বাংলাদেশ ও নতুন সম্ভাবনা</h4>
                        </div>
                        <!-- Video 4 -->
                        <div class="group cursor-pointer flex gap-2 lg:block pb-3 border-b border-custom last:border-0 lg:border-0 lg:pb-0">
                            <div class="img-placeholder w-36 h-24 lg:w-full lg:h-auto lg:aspect-video shrink-0 relative overflow-hidden bg-black shadow-sm mb-0 lg:mb-2"><img src="https://images.unsplash.com/photo-1469474968028-56623f02e42e?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-10 h-10 bg-black/60 backdrop-blur-sm flex items-center justify-center text-white border border-custom/20 group-hover:bg-rose-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-base lg:text-lg font-semibold serif leading-snug group-hover:text-rose-600 transition-colors line-clamp-2">ভ্রমণ গাইড: সাজেক ভ্যালির মেঘের কাব্য ও পাহাড়ের হাতছানি</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Photo (ছবি) -->
    <section class="py-8 border-t border-custom mt-4">
        <div class="">
            <div class="flex items-center gap-3 mb-6">
                <h2 class="text-2xl font-bold serif text-gray-900">ছবি</h2>
                <div class="h-1 flex-grow bg-rose-600"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- First Column: 1 top, 2 bottom -->
                <div class="flex flex-col gap-4">
                    <!-- Top Image -->
                    <div class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[250px] md:h-[330px]"><img src="https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=2070&auto=format&fit=crop" alt="Photography" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')" >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4">
                            <p class="text-white font-serif text-base font-semibold leading-tight">শহরের ব্যস্ত জীবনের এক মুহূর্তের প্রতিচ্ছবি</p>
                        </div>
                    </div>
                    
                    <!-- Two Bottom Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[200px] md:h-[160px]"><img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=2070&auto=format&fit=crop" alt="Nature" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                             <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4">
                                <p class="text-white font-serif text-base font-semibold leading-tight">প্রকৃতির স্নিগ্ধ ছোঁয়ায় প্রশান্তির এক পলক</p>
                            </div>
                        </div>
                        <div class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[200px] md:h-[160px]"><img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=2070&auto=format&fit=crop" alt="Tech" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onload="this.parentElement.classList.remove('img-placeholder')" >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4">
                                <p class="text-white font-serif text-base font-semibold leading-tight">প্রযুক্তির জয়ধ্বনিতে মুখর আগামীর বিশ্ব</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Column: One big image -->
                <div class="img-placeholder group cursor-pointer relative overflow-hidden shadow-md h-[300px] md:h-[505px]"><img src="https://images.unsplash.com/photo-1444653614773-995cb1ef9efa?q=80&w=2070&auto=format&fit=crop" alt="Featured Photo" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onload="this.parentElement.classList.remove('img-placeholder')" >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
                        <span class="bg-rose-600 text-white text-xs font-bold px-2 py-1 w-max mb-3">ফিচারড ফটো</span>
                        <h3 class="text-white text-xl md:text-3xl font-bold serif leading-tight">বাংলাদেশের প্রাকৃতিক সৌন্দর্যে মোড়ানো এক অনন্য ক্যানভাস</h3>
                        <p class="text-gray-200 mt-2 text-sm line-clamp-2">প্রকৃতির অপার বিস্ময় আর সবুজের সমারোহে ঘেরা আমাদের এই মাতৃভূমিকে লেন্সের মাধ্যমে দেখার এক নতুন অভিজ্ঞতা।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </div>
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
</x-layout>
