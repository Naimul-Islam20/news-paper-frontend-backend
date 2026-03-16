@extends('admin.layout')

@section('title', 'All Videos')
@section('header_title', 'All Videos')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-4">
            <div class="relative w-full min-w-0 max-w-full sm:max-w-sm flex items-center">
                <input type="text" placeholder="Search videos..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('admin.videos.create') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Video
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-lg text-sm text-emerald-700 dark:text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-12 text-center">SL</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-20">Thumb</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Title</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Category</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">YouTube Link</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-24 text-center">Main?</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-28">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-28">Date</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($videos as $video)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center text-xs text-slate-500">
                            {{ $videos->firstItem() + $loop->index }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="h-10 w-16 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-50 flex items-center justify-center">
                                @if($video->image)
                                    <img src="{{ Storage::url($video->image) }}" class="h-full w-full object-cover" alt="Thumb">
                                @else
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4 max-w-[200px]">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors truncate">{{ $video->title }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">
                                {{ optional($video->category)->name ?? 'None' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ $video->youtube_link }}" target="_blank" class="text-xs text-indigo-500 hover:text-indigo-700 underline truncate max-w-[160px] inline-block">{{ $video->youtube_link }}</a>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($video->is_main_video === 'yes')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-violet-50 text-violet-700 border border-violet-100">Yes</span>
                            @else
                                <span class="text-xs text-slate-400">No</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($video->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-xs font-normal text-slate-600 dark:text-slate-400">{{ $video->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400">{{ $video->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.videos.edit', $video->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this video?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-10 text-center text-slate-400 text-sm">No videos found. <a href="{{ route('admin.videos.create') }}" class="text-indigo-500 hover:underline">Add your first video.</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($videos->hasPages())
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-2">
            {{ $videos->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
