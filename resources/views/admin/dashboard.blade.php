@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('header_title', 'Dashboard')

@section('header_subtitle')
Welcome back, <span class="font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</span>. Here's what's happening today.
@endsection

@section('content')
<style>
    @media (max-width: 839px) {
        .month-label-short {
            display: inline;
        }

        .month-label-full {
            display: none;
        }
    }

    @media (min-width: 640px) {
        .month-label-short {
            display: none;
        }

        .month-label-full {
            display: inline;
        }
    }
</style>
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
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-4 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Site Visitors (Weekly)</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Last 7 days unique visitors (daily)</p>
                    </div>
                </div>
                @php
                $weeklyValues = collect($weeklyVisitors)->pluck('value');
                $weeklyMax = max(1, $weeklyValues->max() ?? 0);
                $weeklyCount = max(1, count($weeklyVisitors));
                // Y-axis scale labels: nice rounded steps (10, 50, 100, 500, 1000, ...)
                $weeklyBaseScales = [10, 50, 100, 500, 1000, 5000, 10000];
                $weeklyScaleMax = collect($weeklyBaseScales)->first(fn ($v) => $v >= $weeklyMax) ?? $weeklyMax;
                $weeklyScaleLabels = [
                $weeklyScaleMax,
                (int) round($weeklyScaleMax * 0.5),
                (int) round($weeklyScaleMax * 0.25),
                0,
                ];

                // Chart: line/dots end a bit above baseline so dots don't sit on the border
                $chartBottom = 44;
                $dotBottom = 43;
                $chartTop = 8;
                $chartHeight = $dotBottom - $chartTop;
                $chartLeft = 1;
                $chartRight = 98;
                $chartWidth = $chartRight - $chartLeft;

                $weeklyPoints = [];
                foreach ($weeklyVisitors as $i => $item) {
                $x = $chartLeft + ($i * ($chartWidth / max(1, $weeklyCount - 1)));
                $y = $dotBottom - (($item['value'] / max(1, $weeklyScaleMax)) * $chartHeight);
                $weeklyPoints[] = $x . ',' . $y;
                }
                @endphp
                <div class="h-44 flex gap-3 items-stretch">
                    {{-- Y axis: 0 at bottom, same height as SVG --}}
                    <div class="flex flex-col justify-between text-[10px] font-medium text-slate-400 py-0">
                        @foreach($weeklyScaleLabels as $label)
                        <span>{{ $label }}</span>
                        @endforeach
                    </div>
                    {{-- Line chart: baseline at SVG bottom (y=44) = 0 line --}}
                    <div class="flex-1 relative min-h-0">
                        <svg viewBox="0 0 100 44" class="w-full h-full block">
                            <defs>
                                <linearGradient id="weeklyGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#4f46e5" stop-opacity="0.55" />
                                    <stop offset="100%" stop-color="#4f46e5" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <line x1="0" y1="44" x2="100" y2="44" stroke="#e5e7eb" stroke-width="0.5" />
                            @if(count($weeklyPoints))
                            <polygon fill="url(#weeklyGradient)" opacity="0.7"
                                points="{{ $chartLeft . ',' . $dotBottom . ' ' . implode(' ', $weeklyPoints) . ' ' . $chartRight . ',' . $dotBottom }}" />
                            <polyline fill="none" stroke="#4f46e5" stroke-width="0.8"
                                stroke-linecap="round" stroke-linejoin="round"
                                points="{{ implode(' ', $weeklyPoints) }}" />
                            @foreach($weeklyVisitors as $i => $item)
                            @php
                            $x = $chartLeft + ($i * ($chartWidth / max(1, $weeklyCount - 1)));
                            $y = $dotBottom - (($item['value'] / max(1, $weeklyScaleMax)) * $chartHeight);
                            $textY = $y - 2.5;
                            @endphp
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="0.9" fill="#4f46e5" />
                            <text x="{{ $x }}" y="{{ $textY }}" text-anchor="middle" font-size="2.1" fill="#4b5563">{{ $item['value'] }}</text>
                            @endforeach
                            @endif
                        </svg>
                    </div>
                </div>
                {{-- Tarikh: dot er thik niche, slight left offset --}}
                <div class="flex gap-0 mt-1">
                    <div class="w-8 shrink-0"></div>
                    <div class="flex-1 relative min-h-[1.25rem] text-[10px] font-medium text-slate-400">
                        @foreach($weeklyVisitors as $i => $item)
                        @php $labelX = $chartLeft + ($i * ($chartWidth / max(1, $weeklyCount - 1))) - 0.5; @endphp
                        <span class="absolute -translate-x-1/2 whitespace-nowrap" style="left: {{ $labelX }}%;">{{ $item['label'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Monthly Visitors (last 12 months, same style as Weekly) --}}
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 p-4 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <div class="min-w-0">
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white">Site Visitors (Monthly)</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Last 12 months unique visitors (monthly)</p>
                    </div>
                </div>
                @php
                $monthlyValues = collect($monthlyVisitors)->pluck('value');
                $monthlyMax = max(1, $monthlyValues->max() ?? 0);
                $monthlyCount = max(1, count($monthlyVisitors));
                $monthlyBaseScales = [10, 50, 100, 500, 1000, 5000, 10000];
                $monthlyScaleMax = collect($monthlyBaseScales)->first(fn ($v) => $v >= $monthlyMax) ?? $monthlyMax;
                $monthlyScaleLabels = [
                $monthlyScaleMax,
                (int) round($monthlyScaleMax * 0.5),
                (int) round($monthlyScaleMax * 0.25),
                0,
                ];
                $mChartBottom = 44;
                $mDotBottom = 43;
                $mChartTop = 8;
                $mChartHeight = $mDotBottom - $mChartTop;
                $mChartLeft = 1;
                $mChartRight = 98;
                $mChartWidth = $mChartRight - $mChartLeft;
                $monthlyPoints = [];
                foreach ($monthlyVisitors as $i => $item) {
                $mx = $mChartLeft + ($i * ($mChartWidth / max(1, $monthlyCount - 1)));
                $my = $mDotBottom - (($item['value'] / max(1, $monthlyScaleMax)) * $mChartHeight);
                $monthlyPoints[] = $mx . ',' . $my;
                }
                @endphp
                <div class="h-44 flex gap-3 items-stretch">
                    <div class="flex flex-col justify-between text-[10px] font-medium text-slate-400 py-0">
                        @foreach($monthlyScaleLabels as $label)
                        <span>{{ $label }}</span>
                        @endforeach
                    </div>
                    <div class="flex-1 relative min-h-0">
                        <svg viewBox="0 0 100 44" class="w-full h-full block">
                            <defs>
                                <linearGradient id="monthlyGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#0ea5e9" stop-opacity="0.55" />
                                    <stop offset="100%" stop-color="#0ea5e9" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <line x1="0" y1="44" x2="100" y2="44" stroke="#e5e7eb" stroke-width="0.5" />
                            @if(count($monthlyPoints))
                            <polygon fill="url(#monthlyGradient)" opacity="0.7"
                                points="{{ $mChartLeft . ',' . $mDotBottom . ' ' . implode(' ', $monthlyPoints) . ' ' . $mChartRight . ',' . $mDotBottom }}" />
                            <polyline fill="none" stroke="#0ea5e9" stroke-width="0.8"
                                stroke-linecap="round" stroke-linejoin="round"
                                points="{{ implode(' ', $monthlyPoints) }}" />
                            @foreach($monthlyVisitors as $i => $item)
                            @php
                            $mx = $mChartLeft + ($i * ($mChartWidth / max(1, $monthlyCount - 1)));
                            $my = $mDotBottom - (($item['value'] / max(1, $monthlyScaleMax)) * $mChartHeight);
                            $mTextY = $my - 2.5;
                            @endphp
                            <circle cx="{{ $mx }}" cy="{{ $my }}" r="0.9" fill="#0ea5e9" />
                            <text x="{{ $mx }}" y="{{ $mTextY }}" text-anchor="middle" font-size="2.1" fill="#4b5563">{{ $item['value'] }}</text>
                            @endforeach
                            @endif
                        </svg>
                    </div>
                </div>
                <div class="flex gap-0 mt-1">
                    <div class="w-8 shrink-0"></div>
                    <div class="flex-1 relative min-h-[1.25rem] text-[10px] font-medium text-slate-400">
                        @php
                        $mobileMonthShort = [
                        'January' => 'Ja',
                        'February' => 'Fe',
                        'March' => 'Ma',
                        'April' => 'Ap',
                        'May' => 'Ma',
                        'June' => 'Ju',
                        'July' => 'Ju',
                        'August' => 'Au',
                        'September' => 'Se',
                        'October' => 'Oc',
                        'November' => 'No',
                        'December' => 'De',
                        ];
                        @endphp
                        @foreach($monthlyVisitors as $i => $item)
                        @php
                        $mLabelX = $mChartLeft + ($i * ($mChartWidth / max(1, $monthlyCount - 1))) - 1;
                        $label = $item['label'];
                        $short = $mobileMonthShort[$label] ?? \Illuminate\Support\Str::substr($label, 0, 2);
                        @endphp
                        <span class="absolute -translate-x-1/2 whitespace-nowrap" style="left: {{ $mLabelX }}%;">
                            <span class="month-label-short px-0.5">
                                {{ $short }}
                            </span>
                            <span class="month-label-full">
                                {{ $label }}
                            </span>
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar Widgets --}}
        <div class="space-y-3 md:space-y-8">
            {{-- Top Categories (Last 10 days) --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8">
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
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 text-slate-900 dark:text-slate-200 shadow-sm border border-slate-200 dark:border-slate-800">
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
    <div class="mt-8 bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-6 sm:p-8 pb-2 flex items-center justify-between">
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
                        <div class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-500 text-xs shrink-0">
                            {{ optional($post->categories->first())->name[0] ?? 'N' }}
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
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider 
                                    {{ $post->status === 'published' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : '' }}
                                    {{ $post->status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' : '' }}
                                    {{ $post->status === 'draft' ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' : '' }}">
                            @if($post->status === 'published')
                            Published
                            @elseif($post->status === 'pending')
                            Review
                            @elseif($post->status === 'draft')
                            Draft
                            @else
                            {{ ucfirst($post->status) }}
                            @endif
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