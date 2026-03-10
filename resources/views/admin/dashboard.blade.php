@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('header_title', 'Dashboard')

@section('header_subtitle')
    Welcome back, <span class="font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</span>. Here's what's happening today.
@endsection

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">
        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Today's Stories --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 transition-all hover:shadow-md group">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-950/30 rounded-full transition-transform group-hover:scale-110"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Today's Stories</p>
                        <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">12</h3>
                        <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            +20% from yesterday
                        </p>
                    </div>
                    <div class="p-3 bg-indigo-500 rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Total Articles --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 transition-all hover:shadow-md group">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-blue-50 dark:bg-blue-950/30 rounded-full transition-transform group-hover:scale-110"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Articles</p>
                        <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">1,284</h3>
                        <p class="text-xs text-slate-400 font-medium mt-1">Across all categories</p>
                    </div>
                    <div class="p-3 bg-blue-500 rounded-2xl shadow-lg shadow-blue-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Live Readers --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 transition-all hover:shadow-md group">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-950/30 rounded-full transition-transform group-hover:scale-110"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Live Readers</p>
                        <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">452</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                            <p class="text-xs text-emerald-600 font-medium tracking-wide">Currently active</p>
                        </div>
                    </div>
                    <div class="p-3 bg-emerald-500 rounded-2xl shadow-lg shadow-emerald-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Pending Review --}}
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 transition-all hover:shadow-md group">
                <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-amber-50 dark:bg-amber-950/30 rounded-full transition-transform group-hover:scale-110"></div>
                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Pending Review</p>
                        <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">7</h3>
                        <p class="text-xs text-amber-600 font-medium mt-1">Needs attention</p>
                    </div>
                    <div class="p-3 bg-amber-500 rounded-2xl shadow-lg shadow-amber-200 dark:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Performance Chart Area --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Engagement Overview</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Weekly readership statistics and trends</p>
                        </div>
                        <select class="bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 px-4 py-2 focus:ring-2 focus:ring-indigo-500">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                        </select>
                    </div>
                    
                    <div class="aspect-[16/6] relative flex items-end justify-between gap-2 px-2">
                        {{-- Mock Chart Bars --}}
                        @php $bars = [40, 70, 45, 90, 65, 80, 50]; @endphp
                        @foreach($bars as $index => $height)
                            <div class="flex-1 group relative">
                                <div class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 bg-slate-900 dark:bg-slate-700 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ $height * 123 }} views
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-t-xl overflow-hidden min-h-[4px]">
                                    <div class="w-full bg-indigo-500/80 group-hover:bg-indigo-500 transition-all rounded-t-xl" style="height: {{ $height }}%"></div>
                                </div>
                                <p class="text-[10px] font-bold text-slate-400 text-center mt-3 uppercase tracking-tighter">Day {{ $index + 1 }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Articles Table --}}
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <div class="p-8 pb-0 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Newsroom Activity</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Recent updates from the editorial team</p>
                        </div>
                        <button class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">View All</button>
                    </div>
                    
                    <div class="p-4 mt-4">
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @php
                                $mockNews = [
                                    ['title' => 'Global Climate Summit Reaches Landmark Agreement', 'author' => 'Sarah Johnson', 'category' => 'Politics', 'status' => 'Published', 'time' => '24m ago'],
                                    ['title' => 'Tech Giants Unveil Next-Gen AI Integration', 'author' => 'Mark Chen', 'category' => 'Technology', 'status' => 'Review', 'time' => '1h ago'],
                                    ['title' => 'Champions League: Underdogs Secure Finals Spot', 'author' => 'David Miller', 'category' => 'Sports', 'status' => 'Published', 'time' => '3h ago'],
                                    ['title' => 'Culinary Trends: The Rise of Plant-Based Fine Dining', 'author' => 'Elena Rodriguez', 'category' => 'Lifestyle', 'status' => 'Draft', 'time' => '5h ago'],
                                ];
                            @endphp

                            @foreach($mockNews as $news)
                                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-2xl px-4 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-500 text-xs">
                                            {{ substr($news['category'], 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $news['title'] }}</h4>
                                            <p class="text-xs text-slate-500 mt-0.5">By {{ $news['author'] }} · {{ $news['time'] }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                                            {{ $news['status'] === 'Published' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : '' }}
                                            {{ $news['status'] === 'Review' ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' : '' }}
                                            {{ $news['status'] === 'Draft' ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' : '' }}">
                                            {{ $news['status'] }}
                                        </span>
                                        <svg class="w-5 h-5 text-slate-300 dark:text-slate-600 group-hover:text-slate-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Widgets --}}
            <div class="space-y-8">
                {{-- Quick Actions --}}
                <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-200 dark:shadow-none bg-gradient-to-br from-indigo-600 to-indigo-800 relative overflow-hidden">
                    <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-indigo-500 opacity-20 transform -rotate-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <div class="relative">
                        <h3 class="text-xl font-bold mb-4">Start New Story</h3>
                        <p class="text-indigo-100/80 text-sm mb-6 leading-relaxed">Ready to break the next big news? Use our advanced editor to create impactful content.</p>
                        <button class="w-full bg-white text-indigo-600 py-3 rounded-2xl text-sm font-bold shadow-soft hover:bg-slate-50 transition-all flex items-center justify-center gap-2 group">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            Compose Article
                        </button>
                    </div>
                </div>

                {{-- Trending Topics --}}
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Trending Topics</h3>
                    <div class="space-y-4">
                        @php
                            $trends = [
                                ['name' => '#ClimateChange', 'count' => '42 articles'],
                                ['name' => '#TechInnovation', 'count' => '28 articles'],
                                ['name' => '#WorldCup2026', 'count' => '15 articles'],
                                ['name' => '#StreetFood', 'count' => '12 articles'],
                            ];
                        @endphp
                        @foreach($trends as $trend)
                            <div class="flex items-center justify-between group cursor-pointer">
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 transition-colors">{{ $trend['name'] }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold">{{ $trend['count'] }}</p>
                                </div>
                                <div class="w-8 h-8 rounded-xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all transform scale-90 group-hover:scale-100">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Editorial Note / Tips --}}
                <div class="bg-slate-900 dark:bg-slate-800/50 rounded-3xl p-8 text-slate-200 shadow-xl border border-slate-800">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div>
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Pro Tip</h3>
                    </div>
                    <p class="text-sm text-slate-300 italic leading-relaxed">
                        "Visual storytelling increases reader engagement by 40%. Always include high-resolution cover images for your featured articles."
                    </p>
                    <div class="mt-6 flex items-center gap-3 border-t border-slate-800 pt-6">
                        <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-[10px] font-bold">EA</div>
                        <div>
                            <p class="text-xs font-bold text-white">Editorial Assistant</p>
                            <p class="text-[10px] text-slate-500">Automated insight</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection