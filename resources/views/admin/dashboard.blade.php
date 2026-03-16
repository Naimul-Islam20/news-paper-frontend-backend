@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('header_title', 'Dashboard')

@section('header_subtitle')
Welcome back, <span class="font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</span>. Here's what's happening today.
@endsection

@section('content')

<div class="max-w-7xl mx-auto space-y-3 md:space-y-8">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
        {{-- Today's Posts --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-xl p-4 sm:p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-950/30 rounded-full"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Today's Posts</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">{{ $todayPosts ?? 0 }}</h3>
                    @php
                    $yesterday = $yesterdayPosts ?? 0;
                    $today = $todayPosts ?? 0;
                    $todayStoriesSub = 'Published today';
                    if ($yesterday > 0 && $today != $yesterday) {
                    $pct = (int) round((($today - $yesterday) / $yesterday) * 100);
                    $todayStoriesSub = $pct >= 0 ? "+{$pct}% from yesterday" : "{$pct}% from yesterday";
                    } elseif ($yesterday > 0 || $today > 0) {
                    $todayStoriesSub = $today === $yesterday ? 'Same as yesterday' : 'Published today';
                    }
                    @endphp
                    <p class="text-xs {{ ($yesterday > 0 && $today > $yesterday) ? 'text-emerald-600' : (($yesterday > 0 && $today < $yesterday) ? 'text-amber-600' : 'text-slate-400') }} font-medium mt-1 flex items-center gap-1">
                        @if($yesterday > 0 && $today > $yesterday)
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        @endif
                        {{ $todayStoriesSub }}
                    </p>
                </div>
                <div class="p-3 bg-indigo-500 rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Articles --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-xl p-4 sm:p-6 shadow-sm border border-slate-200 dark:border-slate-800 transition-all hover:shadow-md group">
            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-blue-50 dark:bg-blue-950/30 rounded-full transition-transform group-hover:scale-110"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Articles</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">{{ $totalPublishedPosts ?? 0 }}</h3>
                    <p class="text-xs text-slate-400 font-medium mt-1">Across all categories</p>
                </div>
                <div class="p-3 bg-blue-500 rounded-2xl shadow-lg shadow-blue-200 dark:shadow-none">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Today's Visitors --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-xl p-4 sm:p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-emerald-50 dark:bg-emerald-950/30 rounded-full"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Today's Visitors</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">{{ $todayVisitors ?? 0 }}</h3>
                    @php
                    $yv = $yesterdayVisitors ?? 0;
                    $tv = $todayVisitors ?? 0;
                    $visitorsSub = 'Unique visitors today';
                    if ($yv > 0 && $tv != $yv) {
                    $pctV = (int) round((($tv - $yv) / $yv) * 100);
                    $visitorsSub = $pctV >= 0 ? "+{$pctV}% from yesterday" : "{$pctV}% from yesterday";
                    } elseif ($yv > 0 || $tv > 0) {
                    $visitorsSub = $tv === $yv ? 'Same as yesterday' : 'Unique visitors today';
                    }
                    @endphp
                    <p class="text-xs {{ ($yv > 0 && $tv > $yv) ? 'text-emerald-600' : (($yv > 0 && $tv < $yv) ? 'text-amber-600' : 'text-slate-400') }} font-medium mt-1 flex items-center gap-1">
                        @if($yv > 0 && $tv > $yv)
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        @endif
                        {{ $visitorsSub }}
                    </p>
                </div>
                <div class="p-3 bg-emerald-500 rounded-2xl shadow-xl shadow-emerald-200 dark:shadow-none">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending Review --}}
        <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-xl p-4 sm:p-6 shadow-sm border border-slate-200 dark:border-slate-800">
            <div class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-amber-50 dark:bg-amber-950/30 rounded-full"></div>
            <div class="relative flex items-start justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Pending Review</p>
                    <h3 class="text-3xl font-bold mt-2 text-slate-900 dark:text-white">{{ $draftPendingCount ?? 0 }}</h3>
                    <p class="text-xs text-amber-600 font-medium mt-1">Needs attention</p>
                </div>
                <div class="p-3 bg-amber-500 rounded-2xl shadow-lg shadow-amber-200 dark:shadow-none">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-8">
        {{-- Performance Chart Area --}}
        <div class="lg:col-span-2 space-y-3 md:space-y-8">
            {{-- Weekly Visitors --}}
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-2 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6 px-2 sm:px-0">
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Site Visitors (Weekly)</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Last 7 days unique visitors (daily)</p>
                    </div>
                </div>
                <div id="weekly-chart" class="min-h-[200px]"></div>
            </div>

            {{-- Monthly Visitors --}}
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-2 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6 px-2 sm:px-0">
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Site Visitors (Yearly)</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Month-by-month visitors for the last 12 months</p>
                    </div>
                </div>
                <div id="monthly-chart" class="min-h-[200px]"></div>
            </div>

        </div>

        {{-- Sidebar Widgets --}}
        <div class="space-y-3 md:space-y-8">
            {{-- Top Categories (Last 10 days) --}}
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-4 sm:p-8">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Top 5 viewed Categories</h3>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-4">Last 10 days by views</p>
                <div class="space-y-3">
                    @forelse($topCategories as $cat)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                {{ $cat->name }}
                            </p>
                            <p class="text-[11px] text-slate-400">
                                {{ number_format($cat->views_sum ?? 0) }} views · {{ $cat->posts_count }} posts
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-400">No data for the last 10 days.</p>
                    @endforelse
                </div>
            </div>

            {{-- Top Stories (Last 10 days) --}}
            <div class="bg-white dark:bg-slate-900 rounded-xl p-4 sm:p-8 text-slate-900 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-800">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-[0.16em] text-slate-900">Top 5 viewed Posts</h3>
                        <p class="text-xs text-slate-500">Last 10 days by views</p>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($topPosts as $post)
                    @php
                    $primaryCategory = $post->categories->first();
                    $parentCategory = $primaryCategory?->parent;
                    @endphp
                    <div class="flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-900 truncate">
                                {{ $post->title }}
                            </p>
                            <p class="text-[11px] text-slate-500">
                                {{ number_format($post->views ?? 0) }} views ·
                                @if($primaryCategory)
                                @if($parentCategory)
                                {{ $parentCategory->name }} / {{ $primaryCategory->name }} ·
                                @else
                                {{ $primaryCategory->name }} ·
                                @endif
                                @endif
                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans(null, true) }} ago
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-xs text-slate-500">No stories published in the last 10 days.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Newsroom Activity: latest posts across full width --}}
    <div class="mt-2 md:mt-8 bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-4 sm:p-8 pb-2 flex items-center justify-between">
            <div>
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Newsroom Activity</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Latest stories from the editorial team</p>
            </div>
            <a href="{{ route('admin.posts.index') ?? '#' }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                View All
            </a>
        </div>

        <div class="p-4 sm:p-6 pt-2">
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($topPosts as $post)
                <div class="py-3 sm:py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 group cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 rounded-2xl px-3 sm:px-4 transition-colors">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-11 h-11 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden shrink-0">
                            @if($post->image)
                            <img src="{{ storage_image_url($post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                            <span class="font-bold text-slate-500 text-xs">{{ optional($post->categories->first())->name[0] ?? 'N' }}</span>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors truncate">
                                {{ $post->title }}
                            </h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 truncate">
                                @if($post->reporter)
                                By {{ $post->reporter->name }} ·
                                @endif
                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans(null, true) }} ago
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 justify-between sm:justify-end">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400">
                            {{ optional($post->categories->first())->name ?? 'General' }}
                        </span>
                        <span class="text-[11px] text-slate-400 whitespace-nowrap">
                            {{ number_format($post->views ?? 0) }} views
                        </span>
                    </div>
                </div>
                @empty
                <p class="py-4 text-xs text-slate-500 text-center">No recent stories yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const themeColor = isDark ? '#94a3b8' : '#64748b'; // slate-400 / slate-500
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

        // Common settings
        const commonOptions = {
            chart: {
                height: 240,
                type: 'area',
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'inherit',
                background: 'transparent',
                sparkline: { enabled: false }
            },
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3,
                lineCap: 'round'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 0 }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    offsetX: -10, // সংখ্যাগুলোকে লাইনের কাছে রাখবে কিন্তু ভেতরে ঢুকবে না
                    style: { colors: themeColor, fontSize: '10px' },
                    formatter: (val) => {
                        if (val === 0) return '';
                        if (val >= 1000000) return (val / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
                        if (val >= 1000) return (val / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
                        return val;
                    }
                }
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                x: { show: true },
                style: { fontSize: '12px' }
            }
        };

        // Weekly Chart
        const weeklyData = @json($weeklyVisitors);
        const weeklyOptions = {
            ...commonOptions,
            series: [{
                name: 'Visitors',
                data: weeklyData.map(item => item.value)
            }],
            colors: ['#6366f1'], // indigo-500
            xaxis: {
                categories: weeklyData.map(item => item.label),
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: themeColor, fontSize: '10px' }
                }
            },
            markers: {
                size: 4,
                colors: ['#6366f1'],
                strokeColors: isDark ? '#0f172a' : '#fff',
                strokeWidth: 2,
                hover: { size: 6 }
            }
        };

        // Monthly Chart
        const monthlyData = @json($monthlyVisitors);
        const monthlyOptions = {
            ...commonOptions,
            series: [{
                name: 'Visitors',
                data: monthlyData.map(item => item.value)
            }],
            colors: ['#0ea5e9'], // sky-500
            xaxis: {
                categories: monthlyData.map(item => {
                    return window.innerWidth < 640 ? item.label.substring(0, 3) : item.label;
                }),
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: themeColor, fontSize: '10px' }
                }
            },
            markers: {
                size: 4,
                colors: ['#0ea5e9'],
                strokeColors: isDark ? '#0f172a' : '#fff',
                strokeWidth: 2,
                hover: { size: 6 }
            }
        };

        new ApexCharts(document.querySelector("#weekly-chart"), weeklyOptions).render();
        new ApexCharts(document.querySelector("#monthly-chart"), monthlyOptions).render();
    });
</script>
@endpush