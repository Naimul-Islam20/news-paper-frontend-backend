@extends('admin.layout')

@section('title', 'All Posts')
@section('header_title', 'All Posts')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        {{-- Header Actions --}}
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-6 sm:mb-8">
            <div class="relative w-full min-w-0 max-w-full sm:max-w-sm flex items-center">
                <input type="text" placeholder="Search posts..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('admin.posts.create') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Create New Post
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-lg text-sm text-emerald-700 dark:text-emerald-400 font-normal">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-16 text-center">SL</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Title</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-24 text-center">Image</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Categories</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-32">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-36">Date/Time</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Reporter</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($posts as $post)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center">
                            <span class="text-xs font-normal text-slate-500">
                                {{ $posts->firstItem() + $loop->index }}
                            </span>
                        </td>
                        <td class="py-3 px-4 min-w-[200px]">
                            <div class="text-sm font-normal text-slate-900 dark:text-slate-100 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $post->title }}
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="h-10 w-16 mx-auto rounded border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-50 flex items-center justify-center">
                                @if($post->image)
                                    <img src="{{ Storage::url($post->image) }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($post->categories as $cat)
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-normal text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        {{ $cat->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if($post->status == 'published')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                </span>
                            @elseif($post->status == 'draft')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-slate-50 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400 border border-slate-100 dark:border-slate-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-xs font-normal text-slate-600 dark:text-slate-400">{{ $post->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400">{{ $post->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-xs font-normal text-slate-600 dark:text-slate-300">{{ optional($post->reporter)->desk ?? optional($post->reporter)->name ?? 'N/A' }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')" class="inline">
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
                        <td colspan="8" class="py-12 text-center text-slate-400 text-sm">No posts found. <a href="{{ route('admin.posts.create') }}" class="text-indigo-500 hover:underline">Create your first post.</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-4">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
