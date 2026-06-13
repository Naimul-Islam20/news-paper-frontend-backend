@extends('admin.layout')

@section('title', 'Edit Advertisement')
@section('header_title', 'Edit Advertisement')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Header --}}
        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-lg border border-slate-200 dark:border-slate-800 p-6">
            <a href="{{ route('admin.advertisements.index') }}" class="inline-flex items-center gap-1 text-sm text-slate-500 hover:text-indigo-600 transition mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                সব স্লট
            </a>
            <h2 class="text-xl font-semibold text-slate-800 dark:text-white">{{ $advertisement->name }}</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                <span class="font-mono text-xs bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">{{ $advertisement->slug }}</span>
                @if($spec = $advertisement->mediaSpec())
                <span class="text-slate-400">· {{ $spec['ratio'] }} · {{ $spec['size'] }}</span>
                @endif
            </p>
            @php
            $frontSource = $advertisement->hasPausedLocalAd()
                ? 'Local (বন্ধ)'
                : ($advertisement->displayUsesLocalAd()
                    ? 'Local'
                    : ($advertisement->displayUsesGoogleAd() ? 'Google' : 'খালি'));
            $frontSourceClass = match (true) {
                $advertisement->hasPausedLocalAd() => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                $frontSource === 'Local' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                $frontSource === 'Google' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                default => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400',
            };
            @endphp
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">
                ফ্রন্টে এখন:
                <span class="inline-flex items-center px-2 py-0.5 rounded-full font-medium {{ $frontSourceClass }}">{{ $frontSource }}</span>
            </p>
        </div>

        @if(session('success'))
        <div class="px-4 py-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-sm">
            {{ session('success') }}
        </div>
        @endif

        @php
        $googleAdAuto = old('google_ad_auto', ($advertisement->google_ad_auto ?? true) ? '1' : '0') === '1';
        $isHomeVideoSlot = $advertisement->slug === 'home_video';
        $hasGoogleFallback = $advertisement->googleAdAutoEnabled() && filled($advertisement->google_ad_slot);
        $localMediaRequired = ! $hasGoogleFallback;
        $googleErrors = collect($errors->getMessages())->only(['google_ad_slot', 'google_ad_auto'])->flatten();
        $localErrors = collect($errors->getMessages())->except(['google_ad_slot', 'google_ad_auto', 'order'])->flatten();
        $localAdRunning = $advertisement->hasRunningLocalAd();
        $localAdPaused = $advertisement->hasPausedLocalAd();
        $localAdHasData = $advertisement->hasDisplayableMedia() || filled($advertisement->link) || $localAdPaused;
        @endphp

        {{-- ① Google Ad — আলাদা ফর্ম, আলাদা কার্ড --}}
        @if(! $isHomeVideoSlot)
        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-lg border-2 border-blue-200 dark:border-blue-900/60 overflow-hidden">
            <div class="px-6 py-4 bg-blue-50 dark:bg-blue-950/40 border-b border-blue-100 dark:border-blue-900/50">
                <h3 class="text-base font-semibold text-blue-900 dark:text-blue-100">Google Ad</h3>
                <p class="mt-0.5 text-sm text-blue-800/70 dark:text-blue-200/70">Auto ON + Slot ID থাকলে slot-এ Google ad চলবে (Local এর উপরে priority)</p>
            </div>
            <div class="p-6">
                @if($googleErrors->isNotEmpty())
                <div class="mb-4 px-4 py-2 rounded-lg bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($googleErrors as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="ad-google-form" action="{{ route('admin.advertisements.google-settings.update', $advertisement->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[14rem] max-w-md">
                            <label for="google_ad_slot" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Google Slot ID</label>
                            <input type="text" name="google_ad_slot" id="google_ad_slot" value="{{ old('google_ad_slot', $advertisement->google_ad_slot) }}" placeholder="2436228703" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm font-mono">
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">AdSense → Ads → By ad unit → Slot ID</p>
                        </div>
                        <div class="shrink-0 pb-1">
                            <input type="hidden" name="google_ad_auto" value="0">
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="google_ad_auto" id="google_ad_auto" value="1" class="sr-only" {{ $googleAdAuto ? 'checked' : '' }}>
                                <span id="google_ad_auto_track" aria-hidden="true" class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full px-0.5 transition-colors duration-200 {{ $googleAdAuto ? 'bg-blue-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                    <span id="google_ad_auto_knob" class="block h-5 w-5 shrink-0 rounded-full bg-white border border-slate-200 shadow-sm transition-transform duration-200 ease-in-out dark:border-slate-400" style="transform: translateX({{ $googleAdAuto ? '20px' : '0px' }});"></span>
                                </span>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Auto ON</span>
                            </label>
                        </div>
                    </div>

                    @if(! google_adsense_client())
                    <p class="text-xs text-amber-700 dark:text-amber-300">Client ID নেই — <a href="{{ route('admin.meta.index') }}" class="underline font-medium">SEO & Meta</a> থেকে Google AdSense Client ID যোগ করুন।</p>
                    @endif

                    <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800">
                        <button type="submit" class="px-5 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 transition">
                            Google Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        {{-- ② Local Ad — আলাদা ফর্ম, আলাদা কার্ড --}}
        <div class="bg-white dark:bg-slate-900 shadow-sm rounded-lg border-2 border-emerald-200 dark:border-emerald-900/50 overflow-hidden">
            <div class="px-6 py-4 bg-emerald-50 dark:bg-emerald-950/30 border-b border-emerald-100 dark:border-emerald-900/40">
                <h3 class="text-base font-semibold text-emerald-900 dark:text-emerald-100">Local Ad</h3>
                <p class="mt-0.5 text-sm text-emerald-800/70 dark:text-emerald-200/70">Priority — Local থাকলে সবসময় Local-ই দেখাবে
                    @if($hasGoogleFallback)
                    <span class="text-blue-600 dark:text-blue-400">· Google fallback সক্রিয়</span>
                    @endif
                </p>
            </div>
            <div class="p-6">
                @if($localErrors->isNotEmpty())
                <div class="mb-4 px-4 py-2 rounded-lg bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($localErrors as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($localAdRunning)
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3 p-4 rounded-lg border border-amber-200 dark:border-amber-900/50 bg-amber-50/80 dark:bg-amber-950/20">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-amber-900 dark:text-amber-100">Local ad চলছে</p>
                        <p class="mt-0.5 text-xs text-amber-800/80 dark:text-amber-200/70">বন্ধ করলে মিডিয়া ও টাইমার সংরক্ষিত থাকবে — Google fallback চালু হতে পারে।</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <form action="{{ route('admin.advertisements.local-ad.pause', $advertisement->id) }}" method="POST" onsubmit="return confirm('Local ad বন্ধ করবেন? ডেটা ও বাকি মেয়াদ সংরক্ষিত থাকবে।');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-medium rounded-md transition">
                                বন্ধ করুন
                            </button>
                        </form>
                        <form action="{{ route('admin.advertisements.local-ad.delete', $advertisement->id) }}" method="POST" onsubmit="return confirm('Local ad সম্পূর্ণ মুছে ফেলবেন? এটা ফিরিয়ে আনা যাবে না।');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($localAdPaused)
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3 p-4 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800/50">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Local ad বন্ধ আছে</p>
                        <p class="mt-0.5 text-xs text-slate-600 dark:text-slate-400">
                            মিডিয়া ও মেয়াদ সংরক্ষিত।
                            @if($advertisement->local_ad_paused_remaining_seconds)
                            বাকি: {{ intdiv((int) $advertisement->local_ad_paused_remaining_seconds, 86400) }} দিন {{ intdiv((int) $advertisement->local_ad_paused_remaining_seconds % 86400, 3600) }} ঘণ্টা
                            @elseif($advertisement->is_auto)
                            সীমাহীন মেয়াদ
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 shrink-0">
                        <form action="{{ route('admin.advertisements.local-ad.resume', $advertisement->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-md transition">
                                চালু করুন
                            </button>
                        </form>
                        <form action="{{ route('admin.advertisements.local-ad.delete', $advertisement->id) }}" method="POST" onsubmit="return confirm('Local ad সম্পূর্ণ মুছে ফেলবেন?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md transition">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @elseif($localAdHasData)
                <div class="mb-5 flex flex-wrap items-center justify-end gap-2 p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30">
                    <form action="{{ route('admin.advertisements.local-ad.delete', $advertisement->id) }}" method="POST" onsubmit="return confirm('Local ad সম্পূর্ণ মুছে ফেলবেন?');">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-medium rounded-md transition">
                            Delete
                        </button>
                    </form>
                </div>
                @endif

                <form id="ad-local-form" action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div id="ad-local-fields" class="space-y-6">
                    @php
                    $slotDurDaysRaw = 0;
                    $slotDurHoursRaw = 0;
                    if ($advertisement->isLocalAdPaused() && $advertisement->local_ad_paused_remaining_seconds) {
                        $totalH = max(1, (int) ceil((int) $advertisement->local_ad_paused_remaining_seconds / 3600));
                        $slotDurDaysRaw = intdiv($totalH, 24);
                        $slotDurHoursRaw = $totalH % 24;
                    } elseif ($advertisement->starts_at && $advertisement->ends_at) {
                    $totalH = max(1, (int) round($advertisement->starts_at->floatDiffInHours($advertisement->ends_at)));
                    $slotDurDaysRaw = intdiv($totalH, 24);
                    $slotDurHoursRaw = $totalH % 24;
                    }
                    $slotDurDays = (int) old('slot_duration_days', $slotDurDaysRaw);
                    $slotDurHours = (int) old('slot_duration_hours', $slotDurHoursRaw);
                    $slotAuto = old('slot_auto', $advertisement->is_auto ? '1' : '0') === '1';
                    @endphp
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                মেয়াদ
                                <span id="slot-duration-required" class="text-rose-600 dark:text-rose-400 font-normal {{ $slotAuto ? 'hidden' : '' }}">*</span>
                            </p>
                            <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                                <input type="hidden" name="slot_auto" value="0">
                                <input type="checkbox" name="slot_auto" id="slot_auto" value="1" class="sr-only" {{ $slotAuto ? 'checked' : '' }}>
                                <span id="slot_auto_track" aria-hidden="true" class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full px-0.5 transition-colors duration-200 {{ $slotAuto ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }}">
                                    <span id="slot_auto_knob" class="block h-5 w-5 shrink-0 rounded-full bg-white border border-slate-200 shadow-sm transition-transform duration-200 ease-in-out dark:border-slate-400" style="transform: translateX({{ $slotAuto ? '20px' : '0px' }});"></span>
                                </span>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">সীমাহীন</span>
                            </label>
                        </div>
                        <div id="slot-duration-fields" class="grid grid-cols-1 sm:grid-cols-2 gap-4 {{ $slotAuto ? 'opacity-50 pointer-events-none' : '' }}">
                            <div>
                                <label for="slot_duration_days" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">দিন</label>
                                <select name="slot_duration_days" id="slot_duration_days" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
                                    @for($d = 0; $d <= 365; $d++)
                                        <option value="{{ $d }}" @selected((int) old('slot_duration_days', $slotDurDays)===$d)>{{ $d }} দিন</option>
                                    @endfor
                                </select>
                                @error('slot_duration_days')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="slot_duration_hours" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ঘণ্টা</label>
                                <select name="slot_duration_hours" id="slot_duration_hours" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
                                    @for($h = 0; $h <= 23; $h++)
                                        <option value="{{ $h }}" @selected((int) old('slot_duration_hours', $slotDurHours)===$h)>{{ $h }} ঘণ্টা</option>
                                    @endfor
                                </select>
                                @error('slot_duration_hours')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if($slotFormDisplay ?? null)
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        ভিউ: <span class="font-semibold text-slate-800 dark:text-white tabular-nums">{{ number_format((int) ($advertisement->views_count ?? 0)) }}</span>
                        <span class="mx-2 text-slate-300">|</span>
                        ক্লিক: <span class="font-semibold text-slate-800 dark:text-white tabular-nums">{{ number_format((int) ($advertisement->clicks_count ?? 0)) }}</span>
                    </p>
                    @endif

                    @include('admin.advertisements.partials.media-fields', [
                    'display' => $slotFormDisplay,
                    'idPrefix' => '',
                    'mediaSpec' => $advertisement->mediaSpec(),
                    'linkRequired' => $localMediaRequired,
                    'mediaRequired' => $localMediaRequired,
                    ])
                    @foreach(['image', 'image_mobile', 'video', 'video_mobile', 'video_youtube_id', 'media_type', 'link', 'caption'] as $mediaField)
                    @error($mediaField)
                    <p class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                    @endforeach

                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                        <button type="submit" class="px-5 py-2 bg-emerald-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">Local Save</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ③ Queue — আলাদা কার্ড --}}
        <div id="queue-admin-root" class="bg-white dark:bg-slate-900 shadow-sm rounded-lg border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-base font-semibold text-slate-800 dark:text-white">কিউ (Rotation)</h3>
                <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">Local ad মেয়াদ শেষ হলে কিউ থেকে পরের ad চলবে</p>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap items-center justify-end gap-3 mb-4">
                    <button type="button" id="queue-open-create" class="px-3 py-1.5 bg-indigo-600 rounded-md text-sm font-medium text-white hover:bg-indigo-700 transition">
                        + কিউতে যোগ করুন
                    </button>
                </div>

                    @if(($queueItems ?? collect())->isNotEmpty())
                    <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-700">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800/80">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">#</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">প্রিভিউ</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">শিরোনাম</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300 hidden md:table-cell">মেয়াদ</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">ভিউ / ক্লিক</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">ক্রম</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody id="queue-items-tbody" class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                                @foreach(($queueItems ?? collect()) as $index => $item)
                                <tr data-queue-id="{{ $item->id }}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 {{ ($liveQueueItem ?? null) && (int) $liveQueueItem->id === (int) $item->id ? 'bg-emerald-50/50 dark:bg-emerald-950/20' : '' }}">
                                    <td class="px-3 py-2 text-slate-600 dark:text-slate-400 tabular-nums">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2">
                                        @if($item->video_youtube_id)
                                        <span class="inline-flex items-center justify-center px-2 h-10 rounded border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-[10px] font-mono text-slate-600 dark:text-slate-300">YT</span>
                                        @elseif($item->video)
                                        <span class="inline-flex items-center justify-center px-2 h-10 rounded border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-[10px] text-slate-600">MP4</span>
                                        @elseif($item->image)
                                        <img src="{{ storage_image_url($item->image) }}" alt="" class="h-10 w-16 object-contain rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800">
                                        @else
                                        <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-slate-800 dark:text-slate-200 max-w-[12rem]">
                                        <span class="truncate block">{{ $item->title ?: '—' }}</span>
                                        @if(($liveQueueItem ?? null) && (int) $liveQueueItem->id === (int) $item->id)
                                        <span class="inline-block mt-0.5 text-[10px] font-medium text-emerald-700 dark:text-emerald-300">● লাইভ</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-slate-500 dark:text-slate-400 text-xs hidden md:table-cell">
                                        @if($item->usesDurationRotation())
                                        <span class="tabular-nums">{{ (int) $item->duration_days }} দিন {{ (int) $item->duration_hours }} ঘণ্টা</span>
                                        @if($item->display_started_at)
                                        <span class="block text-[10px] text-slate-400 mt-0.5">চালু: {{ $item->display_started_at->format('d M, H:i') }}</span>
                                        @else
                                        <span class="block text-[10px] text-amber-600 dark:text-amber-400 mt-0.5">এখনো চালু হয়নি</span>
                                        @endif
                                        @elseif($item->starts_at || $item->ends_at)
                                        {{ optional($item->starts_at)->format('d M H:i') }} → {{ optional($item->ends_at)->format('d M H:i') }}
                                        @else
                                        <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-right tabular-nums text-slate-600 dark:text-slate-300">{{ number_format((int) $item->views_count) }} / {{ number_format((int) $item->clicks_count) }}</td>
                                    <td class="px-3 py-2 text-right whitespace-nowrap">
                                        <button type="button" class="queue-move px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40" data-dir="-1" title="উপরে" @if($loop->first) disabled @endif>↑</button>
                                        <button type="button" class="queue-move px-1.5 py-0.5 rounded border border-slate-200 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 disabled:opacity-40" data-dir="1" title="নিচে" @if($loop->last) disabled @endif>↓</button>
                                    </td>
                                    <td class="px-3 py-2 text-right whitespace-nowrap space-x-1">
                                        <button type="button" class="queue-open-edit px-2 py-1 text-xs font-medium rounded-md bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/50" data-item-id="{{ $item->id }}">সম্পাদনা</button>
                                        <form action="{{ route('admin.advertisements.queue-items.destroy', [$advertisement->id, $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('এই কিউ আইটেম মুছে ফেলবেন?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2 py-1 text-xs font-medium rounded-md bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 hover:bg-rose-100 dark:hover:bg-rose-900/50">মুছুন</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif

                    <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-white mb-4">পুরনো অ্যাড</h3>

                        @if(($expiredAds ?? collect())->isNotEmpty())
                        <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-700">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                                <thead class="bg-slate-50 dark:bg-slate-800/80">
                                    <tr>
                                        <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">প্রিভিউ</th>
                                        <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">শিরোনাম</th>
                                        <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300 hidden md:table-cell">চালু ছিল</th>
                                        <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300 hidden md:table-cell">শেষ হয়েছে</th>
                                        <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">ভিউ / ক্লিক</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                                    @foreach(($expiredAds ?? collect()) as $item)
                                    <tr class="opacity-80">
                                        <td class="px-3 py-2">
                                            @if($item->video_youtube_id)
                                            <span class="inline-flex items-center justify-center px-2 h-10 rounded border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-[10px] font-mono text-slate-600 dark:text-slate-300">YT</span>
                                            @elseif($item->video)
                                            <span class="inline-flex items-center justify-center px-2 h-10 rounded border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-[10px] text-slate-600">MP4</span>
                                            @elseif($item->image)
                                            <img src="{{ storage_image_url($item->image) }}" alt="" class="h-10 w-16 object-contain rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 grayscale">
                                            @else
                                            <span class="text-slate-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-slate-700 dark:text-slate-300 max-w-[14rem] truncate">{{ $item->title ?: '—' }}</td>
                                        <td class="px-3 py-2 text-slate-500 dark:text-slate-400 text-xs hidden md:table-cell tabular-nums">
                                            @if($item->display_started_at)
                                            {{ $item->display_started_at->format('d M Y, H:i') }}
                                            @elseif($item->starts_at)
                                            {{ $item->starts_at->format('d M Y, H:i') }}
                                            @else
                                            —
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 text-slate-500 dark:text-slate-400 text-xs hidden md:table-cell tabular-nums">
                                            {{ optional($item->expired_at)->format('d M Y, H:i') ?: '—' }}
                                        </td>
                                        <td class="px-3 py-2 text-right tabular-nums text-slate-600 dark:text-slate-300">{{ number_format((int) $item->views_count) }} / {{ number_format((int) $item->clicks_count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-sm text-slate-400 py-2">কোনো পুরনো অ্যাড নেই।</p>
                        @endif
                    </div>

                    <form id="queue-reorder-form" action="{{ route('admin.advertisements.queue-items.reorder', $advertisement->id) }}" method="POST" class="hidden">
                        @csrf
                        <div id="queue-reorder-order-inputs"></div>
                    </form>
            </div>
        </div>

        <x-admin.modal-scripts />

        <x-admin.fixed-modal modal-id="adQueueModal" container-id="adQueueModalContainer" max-width="max-w-2xl">
                    <x-slot name="header">
                        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 shrink-0">
                            <div>
                                <h3 id="queue-dialog-title" class="text-base font-semibold text-slate-900 dark:text-white">কিউ আইটেম</h3>
                            </div>
                            <button type="button" onclick="closeModal('adQueueModal', 'adQueueModalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all" aria-label="বন্ধ">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </x-slot>

                    <form id="queue-item-modal-form" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf
                        <input type="hidden" name="_method" id="queue_item_spoof_method" value="PUT" disabled>

                        <div>
                            <label for="q_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">শিরোনাম</label>
                            <input type="text" name="title" id="q_title" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="q_duration_days" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">দিন</label>
                                    <select name="duration_days" id="q_duration_days" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                                        @for($d = 0; $d <= 60; $d++)
                                            <option value="{{ $d }}">{{ $d }} দিন</option>
                                            @endfor
                                    </select>
                                </div>
                                <div>
                                    <label for="q_duration_hours" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">ঘণ্টা</label>
                                    <select name="duration_hours" id="q_duration_hours" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                                        @for($h = 0; $h <= 23; $h++)
                                            <option value="{{ $h }}">{{ $h }} ঘণ্টা</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>

                        @include('admin.advertisements.partials.media-fields', [
                        'display' => null,
                        'idPrefix' => 'q_',
                        'mediaSpec' => $advertisement->mediaSpec(),
                        ])

                        <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" onclick="closeModal('adQueueModal', 'adQueueModalContainer')" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">বাতিল</button>
                            <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">সংরক্ষণ</button>
                        </div>
                    </form>
                </x-admin.fixed-modal>

    </div>
</div>
@php
$queueItemUpdateUrls = $queueItems->mapWithKeys(fn ($i) => [
$i->id => route('admin.advertisements.queue-items.update', ['id' => $advertisement->id, 'itemId' => $i->id]),
]);
$queueItemsPayload = $queueItems->mapWithKeys(fn ($i) => [
$i->id => [
'id' => $i->id,
'title' => $i->title,
'link' => $i->link,
'caption' => $i->caption,
'video_youtube_id' => $i->video_youtube_id,
'media_type' => $i->resolvedMediaType(),
'duration_days' => (int) ($i->duration_days ?? 0),
'duration_hours' => (int) ($i->duration_hours ?? 0),
],
]);
@endphp
<script>
    window.__queueItemUpdateUrls = @json($queueItemUpdateUrls);
    window.__queueItemsPayload = @json($queueItemsPayload);
    window.__queueStoreUrl = @json(route('admin.advertisements.queue-items.store', $advertisement->id));
</script>
<script>
    (function() {
        var qForm = document.getElementById('queue-item-modal-form');
        var spoof = document.getElementById('queue_item_spoof_method');
        var queueRoot = document.getElementById('queue-admin-root');
        var tbody = document.getElementById('queue-items-tbody');
        var reorderForm = document.getElementById('queue-reorder-form');
        var reorderInputs = document.getElementById('queue-reorder-order-inputs');
        if (!qForm || !queueRoot) return;

        function el(id) {
            return document.getElementById(id);
        }

        function toggleMediaPanels(prefix) {
            var typeEl = el(prefix + 'media_type');
            if (!typeEl) return;
            var type = typeEl.value;
            ['image', 'video', 'youtube'].forEach(function(kind) {
                var panel = el(prefix + 'media-' + kind);
                if (panel) panel.classList.toggle('hidden', type !== kind);
            });
        }

        document.querySelectorAll('.ad-media-type-select').forEach(function(sel) {
            sel.addEventListener('change', function() {
                toggleMediaPanels(sel.getAttribute('data-prefix') || '');
            });
        });
        toggleMediaPanels('');
        toggleMediaPanels('q_');

        function clearQueueForm() {
            qForm.reset();
            if (spoof) {
                spoof.value = 'PUT';
                spoof.disabled = true;
            }
            var dd = el('q_duration_days');
            var dh = el('q_duration_hours');
            if (dd) dd.value = '1';
            if (dh) dh.value = '0';
            var mt = el('q_media_type');
            if (mt) mt.value = 'image';
            toggleMediaPanels('q_');
        }

        function openQueueCreate() {
            clearQueueForm();
            qForm.action = window.__queueStoreUrl;
            if (spoof) spoof.disabled = true;
            el('queue-dialog-title').textContent = 'নতুন কিউ আইটেম';
            openModal('adQueueModal', 'adQueueModalContainer');
        }

        function openQueueEdit(id) {
            var payload = window.__queueItemsPayload[id];
            if (!payload) return;
            clearQueueForm();
            qForm.action = window.__queueItemUpdateUrls[id];
            if (spoof) spoof.disabled = false;
            el('queue-dialog-title').textContent = 'কিউ সম্পাদনা';
            el('q_title').value = payload.title || '';
            el('q_link').value = payload.link || '';
            var dd = el('q_duration_days');
            var dh = el('q_duration_hours');
            if (dd) dd.value = String(payload.duration_days != null ? payload.duration_days : 1);
            if (dh) dh.value = String(payload.duration_hours != null ? payload.duration_hours : 0);
            var mt = el('q_media_type');
            if (mt) mt.value = payload.media_type || 'image';
            var cap = el('q_caption');
            if (cap) cap.value = payload.caption || '';
            var yt = el('q_video_youtube_id');
            if (yt) yt.value = payload.video_youtube_id || '';
            toggleMediaPanels('q_');
            openModal('adQueueModal', 'adQueueModalContainer');
        }

        function submitQueueReorder() {
            if (!reorderForm || !reorderInputs || !tbody) return;
            var rows = tbody.querySelectorAll('tr[data-queue-id]');
            var order = Array.prototype.map.call(rows, function(tr) {
                return parseInt(tr.getAttribute('data-queue-id'), 10);
            });
            if (!order.length) return;
            reorderInputs.innerHTML = '';
            order.forEach(function(id) {
                var inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'order[]';
                inp.value = String(id);
                reorderInputs.appendChild(inp);
            });
            reorderForm.submit();
        }

        var qoc = document.getElementById('queue-open-create');
        if (qoc) qoc.addEventListener('click', openQueueCreate);

        queueRoot.addEventListener('click', function(e) {
            var editBtn = e.target.closest('.queue-open-edit');
            if (editBtn) {
                openQueueEdit(parseInt(editBtn.getAttribute('data-item-id'), 10));
                return;
            }
            var mv = e.target.closest('.queue-move');
            if (!mv || mv.disabled) return;
            if (!tbody) return;
            var tr = mv.closest('tr[data-queue-id]');
            if (!tr || !tbody.contains(tr)) return;
            var dir = parseInt(mv.getAttribute('data-dir'), 10);
            var p = tr.parentNode;
            if (dir === -1 && tr.previousElementSibling) {
                p.insertBefore(tr, tr.previousElementSibling);
                submitQueueReorder();
            } else if (dir === 1 && tr.nextElementSibling) {
                var nx = tr.nextElementSibling;
                p.insertBefore(tr, nx.nextElementSibling);
                submitQueueReorder();
            }
        });
    })();

    (function() {
        var googleAutoCheckbox = document.getElementById('google_ad_auto');
        var googleAutoTrack = document.getElementById('google_ad_auto_track');
        var googleAutoKnob = document.getElementById('google_ad_auto_knob');
        if (!googleAutoCheckbox) return;

        function syncGoogleAdAutoUI() {
            var on = googleAutoCheckbox.checked;
            if (googleAutoTrack) {
                googleAutoTrack.classList.toggle('bg-blue-500', on);
                googleAutoTrack.classList.toggle('bg-slate-300', !on);
                googleAutoTrack.classList.toggle('dark:bg-slate-600', !on);
            }
            if (googleAutoKnob) {
                googleAutoKnob.style.transform = on ? 'translateX(20px)' : 'translateX(0px)';
            }
        }

        googleAutoCheckbox.addEventListener('change', syncGoogleAdAutoUI);
        syncGoogleAdAutoUI();
    })();

    (function() {
        var checkbox = document.getElementById('slot_auto');
        var track = document.getElementById('slot_auto_track');
        var knob = document.getElementById('slot_auto_knob');
        var fields = document.getElementById('slot-duration-fields');
        var required = document.getElementById('slot-duration-required');
        if (!checkbox) return;

        function syncSlotAutoUI() {
            var on = checkbox.checked;
            if (track) {
                track.classList.toggle('bg-emerald-500', on);
                track.classList.toggle('bg-slate-300', !on);
                track.classList.toggle('dark:bg-slate-600', !on);
            }
            if (knob) {
                knob.style.transform = on ? 'translateX(20px)' : 'translateX(0px)';
            }
            if (fields) {
                fields.classList.toggle('opacity-50', on);
                fields.classList.toggle('pointer-events-none', on);
            }
            if (required) required.classList.toggle('hidden', on);
        }

        checkbox.addEventListener('change', syncSlotAutoUI);
        syncSlotAutoUI();
    })();
</script>
@endsection