@extends('admin.layout')

@section('title', 'All Pages')
@section('header_title', 'All Pages')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800 mb-4">
            <div class="relative w-full max-w-sm flex items-center">
                <input type="text" placeholder="Search pages..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('admin.pages.create') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm shrink-0">
                Add New Page
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-lg text-sm text-emerald-700 dark:text-emerald-400">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-12 text-center">#</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Image</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Title</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Category</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Slug</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-28">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Date</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pages as $page)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center text-xs text-slate-500">{{ $page->id }}</td>
                        <td class="py-3 px-4">
                            <div class="h-10 w-14 rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-50 flex items-center justify-center">
                                @if($page->image)
                                    <img src="{{ Storage::url($page->image) }}" class="h-full w-full object-cover" alt="{{ $page->title }}">
                                @else
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors">{{ $page->title }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">
                                {{ optional($page->category)->name ?? 'None' }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-xs text-slate-400 font-mono">{{ $page->slug }}</span>
                        </td>
                        <td class="py-3 px-4">
                            @if($page->status === 'active')
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
                            <div class="text-xs font-normal text-slate-600 dark:text-slate-400">{{ $page->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400">{{ $page->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this page?')">
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
                        <td colspan="8" class="py-10 text-center text-slate-400 text-sm">No pages found. <a href="{{ route('admin.pages.create') }}" class="text-indigo-500 hover:underline">Create your first page.</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pages->hasPages())
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-2">
            {{ $pages->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection
