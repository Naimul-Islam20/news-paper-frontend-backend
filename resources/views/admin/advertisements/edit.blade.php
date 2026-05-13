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
                        <h2 class="text-xl font-semibold text-slate-800 dark:text-white">অ্যাড স্লট সম্পাদনা</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $advertisement->name }} <span class="text-slate-400">({{ $advertisement->slug }})</span></p>
                    </div>
                    <button type="button" id="ad-form-clear" class="px-4 py-2 border border-amber-500 dark:border-amber-600 rounded-md text-sm font-medium text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 transition">Clear (মুছুন)</button>
                </div>

                <form id="ad-edit-form" action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @if($mergedQueueItem ?? null)
                    <div class="rounded-lg border border-emerald-200 dark:border-emerald-800/60 bg-emerald-50/80 dark:bg-emerald-950/30 px-4 py-3 text-sm text-emerald-900 dark:text-emerald-100 flex flex-wrap items-center justify-between gap-3">
                        <p class="leading-relaxed"><span class="font-semibold">ফ্রন্টে চলমান কিউ</span> উপরের ফর্মে দেখানো হচ্ছে (লিংক, ছবি, ক্যাপশন/ভিডিও)। নিচের তালিকায় শুধু <span class="font-medium">অপেক্ষমান</span> কিউ — চলমানটা সম্পাদনা করতে এখানে বা মডাল থেকে খুলুন।</p>
                        <button type="button" class="queue-open-edit shrink-0 px-3 py-1.5 text-xs font-medium rounded-md bg-emerald-600 text-white hover:bg-emerald-700" data-item-id="{{ $mergedQueueItem->id }}">চলমান কিউ সম্পাদনা</button>
                    </div>
                    @endif

                    {{-- Name / Location: read-only --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">স্লটের নাম (পরিবর্তনযোগ্য নয়)</label>
                            <div class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-md bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 text-sm">{{ $advertisement->name }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">লোকেশন (slug)</label>
                            <div class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 rounded-md bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 text-sm font-mono">{{ $advertisement->slug }}</div>
                        </div>
                    </div>

                    @php
                        $hasActiveSlotWindow = $advertisement->isWithinSlotScheduleWindow();
                        $slotDurDaysRaw = 0;
                        $slotDurHoursRaw = 0;
                        if ($advertisement->starts_at && $advertisement->ends_at) {
                            $totalH = max(1, (int) round($advertisement->starts_at->floatDiffInHours($advertisement->ends_at)));
                            $slotDurDaysRaw = intdiv($totalH, 24);
                            $slotDurHoursRaw = $totalH % 24;
                        }
                        $slotDurDays = (int) old('slot_duration_days', $slotDurDaysRaw);
                        $slotDurHours = (int) old('slot_duration_hours', $slotDurHoursRaw);
                        $noSlotSchedule = ! $advertisement->starts_at && ! $advertisement->ends_at;
                    @endphp
                    <div class="p-4 rounded-lg border border-indigo-100 dark:border-indigo-900/40 bg-indigo-50/50 dark:bg-indigo-950/20 space-y-4">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white">ফ্রন্টে দেখানোর সময়সূচি</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">কমপক্ষে <span class="font-semibold">১ ঘণ্টা</span> অথবা <span class="font-semibold">১ দিন</span> দিতে হবে; <span class="font-semibold">সংরক্ষণের সময়</span> থেকে মেয়াদ গণনা। দিন ও ঘণ্টা দুটোই শূন্য হলে সংরক্ষণ হবে না এবং ফ্রন্টে স্লট দেখাবে না। টাইমজোন: <span class="font-mono">{{ config('app.timezone') }}</span></p>
                        <p class="text-xs text-indigo-800 dark:text-indigo-200 rounded-md border border-indigo-200/80 dark:border-indigo-800/50 bg-indigo-50/70 dark:bg-indigo-950/30 px-3 py-2 leading-relaxed mt-2"><span class="font-semibold">নিয়ম:</span> উপরের ফর্মের বর্তমান উইন্ডো <strong>চলাকালীন</strong> ফ্রন্টে শুধু ওই ফর্মের ডেটাই দেখাবে। এই সময়ে কিউ ফ্রন্টে আসবে না এবং কিউর মেয়াদ/ক্যালেন্ডার <strong>গণনা বন্ধ</strong> থাকবে। উইন্ডো <strong>শেষ</strong> হলেই কিউ শুরু হবে ও মেয়াদ ঘড়ি চলবে; কোনো কিউ আইটেমের মেয়াদ শেষ হলে পরের কিউ স্বয়ংক্রিয়ভাবে ফ্রন্টে আসবে।</p>
                        @if($noSlotSchedule)
                        <p class="text-xs text-amber-900 dark:text-amber-100 rounded-md border border-amber-200 dark:border-amber-800/60 bg-amber-50 dark:bg-amber-950/40 px-3 py-2 leading-relaxed">
                            <span class="font-semibold">সতর্কতা:</span> এখনও মেয়াদ সেভ করা নেই — ফ্রন্টে এই স্লটের অ্যাড <strong>দেখাবে না</strong>। নিচে দিন বা ঘণ্টা সেট করে সংরক্ষণ করুন।
                        </p>
                        @endif
                        @if($advertisement->starts_at && $advertisement->ends_at)
                        <p class="text-xs text-slate-700 dark:text-slate-300 rounded-md border border-indigo-200/80 dark:border-indigo-800/50 bg-white/60 dark:bg-slate-900/40 px-3 py-2">
                            বর্তমান উইন্ডো: <span class="font-medium tabular-nums">{{ $advertisement->starts_at->format('d M Y, H:i') }}</span>
                            → <span class="font-medium tabular-nums">{{ $advertisement->ends_at->format('d M Y, H:i') }}</span>
                            @if($hasActiveSlotWindow)
                            <span class="text-emerald-600 dark:text-emerald-400">(সক্রিয়)</span>
                            @else
                            <span class="text-slate-500">(শেষ)</span>
                            @endif
                        </p>
                        @endif
                        <div class="p-3 rounded-lg border border-indigo-100 dark:border-indigo-900/40 bg-white/70 dark:bg-slate-900/30 space-y-3">
                            <p class="text-xs font-medium text-slate-700 dark:text-slate-300">মেয়াদ (দিন + ঘণ্টা) <span class="text-rose-600 dark:text-rose-400 font-normal">*</span></p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="slot_duration_days" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">দিন</label>
                                    <select name="slot_duration_days" id="slot_duration_days" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm dark:bg-slate-800 dark:text-white text-sm">
                                        @for($d = 0; $d <= 365; $d++)
                                            <option value="{{ $d }}" @selected((int) old('slot_duration_days', $slotDurDays) === $d)>{{ $d }} দিন</option>
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
                                            <option value="{{ $h }}" @selected((int) old('slot_duration_hours', $slotDurHours) === $h)>{{ $h }} ঘণ্টা</option>
                                        @endfor
                                    </select>
                                    @error('slot_duration_hours')
                                    <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/50">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-white mb-2">পরিসংখ্যান </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="rounded-md border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 px-4 py-3">
                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">ভিউ</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white tabular-nums">{{ number_format((int) ($advertisement->views_count ?? 0)) }}</p>
                            </div>
                            <div class="rounded-md border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/40 px-4 py-3">
                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wide">ক্লিক</p>
                                <p class="text-2xl font-bold text-slate-800 dark:text-white tabular-nums">{{ number_format((int) ($advertisement->clicks_count ?? 0)) }}</p>
                            </div>
                        </div>
                    </div>

                    @if($advertisement->slug === 'home_video')
                    {{-- ভিডিও স্লট: YouTube + ক্লিক করলে যাবে সেই URL --}}
                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 space-y-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400">হোমপেজে ভিডিও ভিউপোর্টে এলে অটো চালু হবে; ভিডিওতে ক্লিক করলে নিচের URL-এ যাবে।</p>
                        <div>
                            <label for="video_youtube_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">YouTube Video ID বা URL</label>
                            <input type="text" name="video_youtube_id" id="video_youtube_id" value="{{ old('video_youtube_id', ($adFormDisplay ?? $advertisement)->video_youtube_id ?? '') }}" placeholder="jNQXAC9IVRw অথবা https://youtube.com/watch?v=..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                            @error('video_youtube_id')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL (ক্লিক করলে যাবে) <span class="text-rose-600 dark:text-rose-400">*</span></label>
                            <input type="url" name="link" id="link" value="{{ old('link', ($adFormDisplay ?? $advertisement)->link) }}" placeholder="https://example.com/..." required class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                            @error('link')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @else
                    {{-- ইমেজ অ্যাড স্লট: Target URL, Caption, Image --}}
                    <div>
                        <label for="link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL (ক্লিক করলে যাবে) <span class="text-rose-600 dark:text-rose-400">*</span></label>
                        <input type="url" name="link" id="link" value="{{ old('link', ($adFormDisplay ?? $advertisement)->link) }}" placeholder="https://example.com/promo" required class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        @error('link')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="caption" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Caption (ঐচ্ছিক)</label>
                        <input type="text" name="caption" id="caption" value="{{ old('caption', ($adFormDisplay ?? $advertisement)->caption) }}" placeholder="সংক্ষিপ্ত টেক্সট" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        @error('caption')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ডেস্কটপ / সাধারণ ইমেজ <span class="text-rose-600 dark:text-rose-400">*</span></label>
                        <div class="flex items-center gap-4 flex-wrap">
                            @if(($adFormDisplay ?? $advertisement)->image)
                            <div class="w-32 h-20 rounded border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0">
                                <img src="{{ storage_image_url(($adFormDisplay ?? $advertisement)->image) }}" alt="Current" class="w-full h-full object-contain">
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-xs text-slate-500">নতুন ইমেজ আপলোড করলে বর্তমানটি প্রতিস্থাপিত হবে।</p>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remove_image" value="1" {{ old('remove_image') ? 'checked' : '' }} class="rounded border-slate-300 dark:border-slate-600 text-rose-600 focus:ring-rose-500">
                                    <span class="text-sm text-slate-700 dark:text-slate-300">বর্তমান ইমেজ মুছুন</span>
                                </label>
                            </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300">
                        </div>
                        @error('image')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image_mobile" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">মোবাইল ইমেজ <span class="text-slate-400 font-normal">(ঐচ্ছিক — না দিলে ডেস্কটপ ইমেজই দেখাবে)</span></label>
                        <div class="flex items-center gap-4 flex-wrap">
                            @if(($adFormDisplay ?? $advertisement)->image_mobile)
                            <div class="w-24 h-36 rounded border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0">
                                <img src="{{ storage_image_url(($adFormDisplay ?? $advertisement)->image_mobile) }}" alt="Mobile current" class="w-full h-full object-contain">
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-xs text-slate-500">ছোট স্ক্রিনে (৭৬৭px পর্যন্ত) শুধু এই ছবি ব্যবহার হবে।</p>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="remove_image_mobile" value="1" {{ old('remove_image_mobile') ? 'checked' : '' }} class="rounded border-slate-300 dark:border-slate-600 text-rose-600 focus:ring-rose-500">
                                    <span class="text-sm text-slate-700 dark:text-slate-300">মোবাইল ইমেজ মুছুন</span>
                                </label>
                            </div>
                            @endif
                            <input type="file" name="image_mobile" id="image_mobile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300">
                        </div>
                        @error('image_mobile')
                        <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Save Changes</button>
                    </div>
                </form>

                @php $isVideoSlot = $advertisement->slug === 'home_video'; @endphp
                <div id="queue-admin-root" class="mt-10 pt-8 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">অতিরিক্ত অ্যাড কিউ</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">ফ্রন্টে কী দেখাবে তা উপরের <span class="font-medium">অ্যাড স্লট সম্পাদনা</span> ফর্মের সময়সূচি অনুযায়ী: উইন্ডো চলাকালীন শুধু সেই ফর্মের অ্যাড; উইন্ডো শেষ হলে নিচের কিউ থেকে ক্রমে চলবে। <span class="font-medium">চলমান কিউ</span> উপরের ফর্মে মিলিয়ে দেখানো হয় — নিচের তালিকায় শুধু <span class="font-medium">অপেক্ষমান</span> কিউ।</p>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button" id="queue-open-create" class="px-4 py-2 bg-emerald-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                                আরেকটি অ্যাড যোগ করুন
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-slate-200 dark:border-slate-700">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800/80">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">#</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">প্রিভিউ</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300">শিরোনাম</th>
                                    <th class="px-3 py-2 text-left font-medium text-slate-600 dark:text-slate-300 hidden md:table-cell">মেয়াদ / চালু</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">ভিউ / ক্লিক</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">ক্রম</th>
                                    <th class="px-3 py-2 text-right font-medium text-slate-600 dark:text-slate-300">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody id="queue-items-tbody" class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                                @forelse(($queueItemsWaiting ?? $queueItems ?? collect()) as $index => $item)
                                <tr data-queue-id="{{ $item->id }}" class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                    <td class="px-3 py-2 text-slate-600 dark:text-slate-400 tabular-nums">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2">
                                        @if($isVideoSlot)
                                            @if($item->video_youtube_id)
                                            <span class="inline-flex items-center justify-center w-14 h-10 rounded border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-xs font-mono text-slate-600 dark:text-slate-300">{{ \Illuminate\Support\Str::limit($item->video_youtube_id, 8, '') }}</span>
                                            @else
                                            <span class="text-slate-400">—</span>
                                            @endif
                                        @else
                                            @if($item->image)
                                            <img src="{{ storage_image_url($item->image) }}" alt="" class="h-10 w-16 object-contain rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800">
                                            @else
                                            <span class="text-slate-400">—</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-slate-800 dark:text-slate-200 max-w-[12rem] truncate">{{ $item->title ?: '—' }}</td>
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
                                @empty
                                <tr>
                                    <td colspan="7" class="px-3 py-8 text-center text-slate-500 dark:text-slate-400 text-sm">
                                        @if($mergedQueueItem ?? null)
                                        অপেক্ষমান কিউ নেই। ফ্রন্টে চলমান কিউ উপরের ফর্মে; নতুন যোগ করতে <span class="font-medium">আরেকটি অ্যাড যোগ করুন</span> ব্যবহার করুন।
                                        @else
                                        কোনো কিউ আইটেম নেই। উপরের বাটনে ক্লিক করে যোগ করুন।
                                        @endif
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                <h3 id="queue-dialog-title" class="text-base font-semibold text-slate-900 dark:text-white">নতুন কিউ আইটেম</h3>
                                <p id="queue-dialog-subtitle" class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">অতিরিক্ত অ্যাড কিউতে নতুন আইটেম যোগ করুন।</p>
                            </div>
                            <button type="button" onclick="closeModal('adQueueModal', 'adQueueModalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all" aria-label="বন্ধ">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </x-slot>

                    <form id="queue-item-modal-form" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                        @csrf
                        <input type="hidden" name="_method" id="queue_item_spoof_method" value="PUT" disabled>

                        <div>
                            <label for="q_title" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">শিরোনাম <span class="text-slate-400 font-normal">(ঐচ্ছিক — তালিকায় চেনার জন্য)</span></label>
                            <input type="text" name="title" id="q_title" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                        </div>

                        <div class="p-4 rounded-xl border border-indigo-100 dark:border-indigo-900/40 bg-indigo-50/50 dark:bg-indigo-950/20 space-y-3">
                            <p class="text-xs font-medium text-slate-700 dark:text-slate-300 leading-relaxed">কতক্ষণ চলবে <span class="text-indigo-700 dark:text-indigo-300">(দিন + ঘণ্টা)</span> — মেয়াদ শেষে ক্রমে পরের অ্যাড একই জায়গায় চলে আসবে। গণনা <span class="font-semibold">প্রথম দেখানোর সময়</span> থেকে শুরু।</p>
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
                        </div>

                        @if($isVideoSlot)
                        <div class="space-y-4">
                            <div>
                                <label for="q_video_youtube_id" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">YouTube Video ID বা URL</label>
                                <input type="text" name="video_youtube_id" id="q_video_youtube_id" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                            </div>
                            <div>
                                <label for="q_link" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Target URL (ক্লিক করলে যাবে) <span class="text-rose-600 dark:text-rose-400">*</span></label>
                                <input type="url" name="link" id="q_link" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                            </div>
                        </div>
                        @else
                        <div>
                            <label for="q_link" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Target URL (ক্লিক করলে যাবে) <span class="text-rose-600 dark:text-rose-400">*</span></label>
                            <input type="url" name="link" id="q_link" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label for="q_caption" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Caption</label>
                            <input type="text" name="caption" id="q_caption" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 outline-none text-slate-900 dark:text-white">
                        </div>
                        <div id="q_image-edit-wrap" class="hidden space-y-2">
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="remove_image" value="1" id="q_remove_image" class="rounded border-slate-300 text-rose-600">
                                <span class="text-slate-700 dark:text-slate-300">ডেস্কটপ ইমেজ মুছুন</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                <input type="checkbox" name="remove_image_mobile" value="1" id="q_remove_image_mobile" class="rounded border-slate-300 text-rose-600">
                                <span class="text-slate-700 dark:text-slate-300">মোবাইল ইমেজ মুছুন</span>
                            </label>
                        </div>
                        <div>
                            <label for="q_image" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5"><span id="q_image_label">ডেস্কটপ ইমেজ</span></label>
                            <input type="file" name="image" id="q_image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300">
                        </div>
                        <div>
                            <label for="q_image_mobile" class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">মোবাইল ইমেজ <span class="text-slate-400 font-normal">(ঐচ্ছিক)</span></label>
                            <input type="file" name="image_mobile" id="q_image_mobile" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300">
                        </div>
                        @endif

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
            'duration_days' => (int) ($i->duration_days ?? 0),
            'duration_hours' => (int) ($i->duration_hours ?? 0),
        ],
    ]);
@endphp
<script>
window.__queueItemUpdateUrls = @json($queueItemUpdateUrls);
window.__queueItemsPayload = @json($queueItemsPayload);
window.__queueStoreUrl = @json(route('admin.advertisements.queue-items.store', $advertisement->id));
window.__isVideoSlot = @json($isVideoSlot);
window.__mergedQueueId = @json(($mergedQueueItem ?? null) ? (int) $mergedQueueItem->id : null);
window.__mergedQueueLiveIndex = @json((int) ($mergedQueueIndex ?? -1));
window.__fullQueueCount = @json((int) ($queueItems ?? collect())->count());
</script>
<script>
    (function() {
        var qForm = document.getElementById('queue-item-modal-form');
        var spoof = document.getElementById('queue_item_spoof_method');
        var queueRoot = document.getElementById('queue-admin-root');
        var tbody = document.getElementById('queue-items-tbody');
        var reorderForm = document.getElementById('queue-reorder-form');
        var reorderInputs = document.getElementById('queue-reorder-order-inputs');
        if (!qForm || !tbody || !queueRoot) return;

        function el(id) { return document.getElementById(id); }

        function clearQueueForm() {
            qForm.reset();
            if (spoof) {
                spoof.value = 'PUT';
                spoof.disabled = true;
            }
            var editWrap = el('q_image-edit-wrap');
            if (editWrap) editWrap.classList.add('hidden');
            var imgLab = el('q_image_label');
            if (imgLab) imgLab.textContent = 'ডেস্কটপ ইমেজ (বাধ্যতামূলক)';
            var dd = el('q_duration_days');
            var dh = el('q_duration_hours');
            if (dd) dd.value = '1';
            if (dh) dh.value = '0';
        }

        function openQueueCreate() {
            clearQueueForm();
            qForm.action = window.__queueStoreUrl;
            if (spoof) spoof.disabled = true;
            el('queue-dialog-title').textContent = 'নতুন কিউ আইটেম';
            var sub = el('queue-dialog-subtitle');
            if (sub) sub.textContent = 'অতিরিক্ত অ্যাড কিউতে নতুন আইটেম যোগ করুন।';
            openModal('adQueueModal', 'adQueueModalContainer');
        }

        function openQueueEdit(id) {
            var payload = window.__queueItemsPayload[id];
            if (!payload) return;
            clearQueueForm();
            qForm.action = window.__queueItemUpdateUrls[id];
            if (spoof) spoof.disabled = false;
            el('queue-dialog-title').textContent = 'কিউ আইটেম সম্পাদনা';
            var subEd = el('queue-dialog-subtitle');
            if (subEd) subEd.textContent = 'এই কিউ আইটেমের তথ্য আপডেট করুন।';
            el('q_title').value = payload.title || '';
            el('q_link').value = payload.link || '';
            var dd = el('q_duration_days');
            var dh = el('q_duration_hours');
            if (dd) dd.value = String(payload.duration_days != null ? payload.duration_days : 1);
            if (dh) dh.value = String(payload.duration_hours != null ? payload.duration_hours : 0);
            if (window.__isVideoSlot) {
                el('q_video_youtube_id').value = payload.video_youtube_id || '';
            } else {
                var cap = el('q_caption');
                if (cap) cap.value = payload.caption || '';
                var editWrap = el('q_image-edit-wrap');
                if (editWrap) editWrap.classList.remove('hidden');
                var imgLab = el('q_image_label');
                if (imgLab) imgLab.textContent = 'ডেস্কটপ ইমেজ (পরিবর্তনে নতুন ফাইল)';
            }
            openModal('adQueueModal', 'adQueueModalContainer');
        }

        function submitQueueReorder() {
            if (!reorderForm || !reorderInputs) return;
            var rows = tbody.querySelectorAll('tr[data-queue-id]');
            var visibleIds = Array.prototype.map.call(rows, function(tr) {
                return parseInt(tr.getAttribute('data-queue-id'), 10);
            });
            var mergedId = window.__mergedQueueId;
            var mergedIdx = typeof window.__mergedQueueLiveIndex === 'number' ? window.__mergedQueueLiveIndex : -1;
            var fullCount = typeof window.__fullQueueCount === 'number' ? window.__fullQueueCount : 0;
            var order;
            if (mergedId != null && mergedId > 0 && mergedIdx >= 0 && fullCount > 0 && visibleIds.length === fullCount - 1) {
                order = [];
                var wi = 0;
                for (var i = 0; i < fullCount; i++) {
                    if (i === mergedIdx) {
                        order[i] = mergedId;
                    } else {
                        order[i] = visibleIds[wi++];
                    }
                }
            } else {
                order = visibleIds;
            }
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

        document.getElementById('queue-open-create').addEventListener('click', openQueueCreate);

        queueRoot.addEventListener('click', function(e) {
            var editBtn = e.target.closest('.queue-open-edit');
            if (editBtn) {
                openQueueEdit(parseInt(editBtn.getAttribute('data-item-id'), 10));
                return;
            }
            var mv = e.target.closest('.queue-move');
            if (!mv || mv.disabled) return;
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

    document.getElementById('ad-form-clear').addEventListener('click', function() {
        var form = document.getElementById('ad-edit-form');
        if (!form) return;
        form.querySelectorAll('input[type="text"], input[type="url"]').forEach(function(inp) {
            if (inp.name && inp.name !== '_token' && inp.name !== '_method') inp.value = '';
        });
        form.querySelectorAll('#slot_duration_days, #slot_duration_hours').forEach(function(sel) {
            sel.value = '0';
        });
        form.querySelectorAll('input[type="file"]').forEach(function(inp) {
            inp.value = '';
        });
        var removeImage = form.querySelector('input[name="remove_image"]');
        if (removeImage) removeImage.checked = true;
        form.querySelectorAll('input[type="checkbox"]').forEach(function(inp) {
            if (['remove_image', 'remove_image_mobile'].indexOf(inp.name) === -1) inp.checked = false;
        });
    });
</script>
@endsection