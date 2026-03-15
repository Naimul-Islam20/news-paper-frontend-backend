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

                    @if($advertisement->slug === 'home_video')
                    {{-- ভিডিও স্লট: YouTube + ক্লিক করলে যাবে সেই URL --}}
                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 space-y-4">
                        <p class="text-sm text-slate-600 dark:text-slate-400">হোমপেজে ভিডিও ভিউপোর্টে এলে অটো চালু হবে; ভিডিওতে ক্লিক করলে নিচের URL-এ যাবে।</p>
                        <div>
                            <label for="video_youtube_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">YouTube Video ID বা URL</label>
                            <input type="text" name="video_youtube_id" id="video_youtube_id" value="{{ old('video_youtube_id', $advertisement->video_youtube_id ?? '') }}" placeholder="jNQXAC9IVRw অথবা https://youtube.com/watch?v=..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                            @error('video_youtube_id')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">ক্লিক করলে এই URL-এ যাবে</label>
                            <input type="url" name="link" id="link" value="{{ old('link', $advertisement->link) }}" placeholder="https://example.com/..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                            @error('link')
                                <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @else
                    {{-- ইমেজ অ্যাড স্লট: Target URL, Caption, Image --}}
                    <div>
                        <label for="link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL (ক্লিক করলে যাবে)</label>
                        <input type="url" name="link" id="link" value="{{ old('link', $advertisement->link) }}" placeholder="https://example.com/promo" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        @error('link')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="caption" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Caption (ঐচ্ছিক)</label>
                        <input type="text" name="caption" id="caption" value="{{ old('caption', $advertisement->caption) }}" placeholder="সংক্ষিপ্ত টেক্সট" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        @error('caption')
                            <p class="mt-1 text-xs text-rose-600 dark:text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ad Image</label>
                        <div class="flex items-center gap-4 flex-wrap">
                            @if($advertisement->image)
                                <div class="w-32 h-20 rounded border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-100 dark:bg-slate-800 shrink-0">
                                    <img src="{{ storage_image_url($advertisement->image) }}" alt="Current" class="w-full h-full object-contain">
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
                    @endif

                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('ad-form-clear').addEventListener('click', function() {
    var form = document.getElementById('ad-edit-form');
    if (!form) return;
    form.querySelectorAll('input[type="text"], input[type="url"]').forEach(function(inp) {
        if (inp.name && inp.name !== '_token' && inp.name !== '_method') inp.value = '';
    });
    form.querySelectorAll('input[type="file"]').forEach(function(inp) { inp.value = ''; });
    var removeImage = form.querySelector('input[name="remove_image"]');
    if (removeImage) removeImage.checked = true;
    form.querySelectorAll('input[type="checkbox"]').forEach(function(inp) {
        if (inp.name !== 'remove_image') inp.checked = false;
    });
});
</script>
@endsection
