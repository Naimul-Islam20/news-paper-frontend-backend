@extends('admin.layout')

@section('title', 'Advertisement')
@section('header_title', 'Advertisement')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        @if(session('success'))
            <div class="mb-4 px-4 py-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-sm">
                {{ session('success') }}
            </div>
        @endif
        <div class="flex flex-wrap items-center justify-between gap-3 pb-6 border-b border-slate-100 dark:border-slate-800 mb-6 sm:mb-8">
            <p class="text-sm text-slate-600 dark:text-slate-400 min-w-0">ফিক্সড অ্যাড স্লটগুলো এখানে তালিকাভুক্ত। নতুন অ্যাড যোগ করা যাবে না; শুধু প্রতিটি স্লটের ইমেজ/লিংক আপডেট করুন।</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider w-24">Banner</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Location (slug)</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">URL</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider text-right w-28">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($advertisements as $ad)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center">
                            <span class="text-sm font-medium text-slate-500">{{ $ad->id }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="h-10 w-20 rounded-lg bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                                @if($ad->image)
                                    <img src="{{ storage_image_url($ad->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-sm font-normal text-black dark:text-white font-medium">{{ $ad->name }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded text-[10px] font-mono">{{ $ad->slug }}</span>
                        </td>
                        <td class="py-3 px-4">
                            @if($ad->link)
                                <a href="{{ $ad->link }}" target="_blank" rel="noopener" class="text-xs text-indigo-500 hover:text-indigo-700 underline truncate max-w-[150px] inline-block">{{ $ad->link }}</a>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('admin.advertisements.edit', $ad->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 px-4 text-center text-slate-500 dark:text-slate-400 text-sm">কোনো অ্যাড স্লট নেই। সিডার চালান: <code class="bg-slate-100 dark:bg-slate-800 px-1 rounded">php artisan db:seed --class=AdvertisementSeeder</code></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
