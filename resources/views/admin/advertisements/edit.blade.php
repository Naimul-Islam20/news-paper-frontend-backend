@extends('admin.layout')

@section('title', 'Edit Advertisement')
@section('header_title', 'Edit Advertisement')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-lg border border-slate-200 dark:border-slate-800">
            <div class="p-6">
                <div class="mb-6 border-b border-slate-200 dark:border-slate-800 pb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-white">{{ $advertisement->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            {{ $advertisement->slug }}
                            @if($spec = $advertisement->mediaSpec())
                            <span class="text-slate-400">· {{ $spec['ratio'] }} · {{ $spec['size'] }}</span>
                            @endif
                        </p>
                    </div>
                    <button type="button" id="ad-form-clear" class="px-3 py-1.5 border border-slate-300 dark:border-slate-600 rounded-md text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition shrink-0">Clear</button>
                </div>

                @if($errors->has('ad_source') || $errors->has('google_ad_slot'))
                <div class="mb-4 px-4 py-2 rounded-lg bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800 text-sm">
                    {{ $errors->first('ad_source') ?: $errors->first('google_ad_slot') }}
                </div>
                @endif

                <form id="ad-edit-form" action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php
                    $isGoogleSource = old('ad_source', $advertisement->ad_source ?? 'local') === 'google';
                    $isHomeVideoSlot = $advertisement->slug === 'home_video';
                    @endphp

                    @if(! $isHomeVideoSlot)
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">সোর্স</span>
                        <div class="inline-flex rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden bg-white dark:bg-slate-900">
                            <label class="inline-flex items-center px-4 py-2 text-sm font-medium cursor-pointer {{ ! $isGoogleSource ? 'bg-indigo-600 text-white' : 'text-slate-600 dark:text-slate-300' }}">
                                <input type="radio" name="ad_source" value="local" class="sr-only ad-source-radio" {{ ! $isGoogleSource ? 'checked' : '' }}>
                                Local
                            </label>
                            <label class="inline-flex items-center px-4 py-2 text-sm font-medium cursor-pointer border-l border-slate-200 dark:border-slate-700 {{ $isGoogleSource ? 'bg-blue-600 text-white' : 'text-slate-600 dark:text-slate-300' }}">
                                <input type="radio" name="ad_source" value="google" class="sr-only ad-source-radio" {{ $isGoogleSource ? 'checked' : '' }}>
                                Google
                            </label>
                        </div>
                    </div>
                    <div id="ad-google-fields" class="{{ $isGoogleSource ? '' : 'hidden' }}">
                        <label for="google_ad_slot" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Google Slot ID <span class="text-rose-600">*</span></label>
                        <input type="text" name="google_ad_slot" id="google_ad_slot" value="{{ old('google_ad_slot', $advertisement->google_ad_slot) }}" placeholder="1234567890" class="w-full max-w-sm px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm font-mono">
                        @if(! google_adsense_client())
                        <p class="mt-1 text-xs text-amber-700 dark:text-amber-300">Client ID নেই — <a href="{{ route('admin.meta.index') }}" class="underline">SEO & Meta</a></p>
                        @endif
                    </div>
                    @else
                    <input type="hidden" name="ad_source" value="local">
                    @endif

                    <div id="ad-local-fields" class="space-y-6 {{ $isGoogleSource && ! $isHomeVideoSlot ? 'hidden' : '' }}">

                    @php
                    $slotDurDaysRaw = 0;
                    $slotDurHoursRaw = 0;
                    if ($advertisement->starts_at && $advertisement->ends_at) {
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
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Auto</span>
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
                    ])
                    @foreach(['image', 'image_mobile', 'video', 'video_mobile', 'video_youtube_id', 'media_type', 'link', 'caption'] as $mediaField)
                    @error($mediaField)
                    <p class="text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                    @enderror
                    @endforeach

                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Save Changes</button>
                    </div>
                </form>

                <div id="queue-admin-root" class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 {{ $isGoogleSource && ! $isHomeVideoSlot ? 'hidden' : '' }}">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-white">কিউ</h3>
                        <button type="button" id="queue-open-create" class="px-3 py-1.5 bg-emerald-600 rounded-md text-sm font-medium text-white hover:bg-emerald-700 transition">
                            + যোগ করুন
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
        var localFields = document.getElementById('ad-local-fields');
        var googleFields = document.getElementById('ad-google-fields');
        var queueRoot = document.getElementById('queue-admin-root');
        var sourceRadios = document.querySelectorAll('.ad-source-radio');

        function syncAdSourceUI() {
            var selected = document.querySelector('.ad-source-radio:checked');
            var isGoogle = selected && selected.value === 'google';
            if (localFields) localFields.classList.toggle('hidden', isGoogle);
            if (googleFields) googleFields.classList.toggle('hidden', !isGoogle);
            if (queueRoot) queueRoot.classList.toggle('hidden', isGoogle);
            sourceRadios.forEach(function(radio) {
                var label = radio.closest('label');
                if (!label) return;
                var active = radio.checked;
                var google = radio.value === 'google';
                label.classList.remove('bg-indigo-600', 'text-white', 'bg-blue-600', 'text-slate-600', 'dark:text-slate-300');
                if (active) {
                    label.classList.add(google ? 'bg-blue-600' : 'bg-indigo-600', 'text-white');
                } else {
                    label.classList.add('text-slate-600', 'dark:text-slate-300');
                }
            });
        }

        sourceRadios.forEach(function(radio) {
            radio.addEventListener('change', syncAdSourceUI);
        });
        syncAdSourceUI();
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

    var adClearBtn = document.getElementById('ad-form-clear');
    if (adClearBtn) adClearBtn.addEventListener('click', function() {
        var form = document.getElementById('ad-edit-form');
        if (!form) return;
        form.querySelectorAll('input[type="text"], input[type="url"]').forEach(function(inp) {
            if (inp.name && inp.name !== '_token' && inp.name !== '_method') inp.value = '';
        });
        var sd = form.querySelector('#slot_duration_days');
        var sh = form.querySelector('#slot_duration_hours');
        if (sd) sd.value = '1';
        if (sh) sh.value = '0';
        var slotAuto = form.querySelector('#slot_auto');
        if (slotAuto) {
            slotAuto.checked = false;
            slotAuto.dispatchEvent(new Event('change'));
        }
        form.querySelectorAll('input[type="file"]').forEach(function(inp) {
            inp.value = '';
        });
        var dtw = document.getElementById('ad-desktop-thumb-wrap');
        var mtw = document.getElementById('ad-mobile-thumb-wrap');
        if (dtw) dtw.classList.add('hidden');
        if (mtw) mtw.classList.add('hidden');
        var removeImage = form.querySelector('input[name="remove_image"]');
        if (removeImage) removeImage.checked = true;
        var removeImageMob = form.querySelector('input[name="remove_image_mobile"]');
        if (removeImageMob) removeImageMob.checked = true;
        form.querySelectorAll('input[type="checkbox"]').forEach(function(inp) {
            if (['remove_image', 'remove_image_mobile'].indexOf(inp.name) === -1) inp.checked = false;
        });
    });
</script>
@endsection