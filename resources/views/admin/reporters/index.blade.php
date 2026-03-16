@extends('admin.layout')

@section('title', 'Reporter')
@section('header_title', 'Reporter')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-6 sm:mb-8">
            <form method="GET" action="{{ route('admin.reporters.index') }}" class="relative w-full min-w-0 max-w-full sm:max-w-sm flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search reporter (SL, name, email, desk)..."
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <a href="{{ route('admin.reporters.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-sm text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Reporter
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider w-16 text-center">SL</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider w-20">Photo</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">Name</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">ডেস্ক/ধরন</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">User</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">Email</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">Phone</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">Created By</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider w-28">Status</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reporters as $reporter)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-1 px-2 text-center">
                            <span class="text-sm font-normal text-black dark:text-white">
                                {{ $reporters->firstItem() + $loop->index }}
                            </span>
                        </td>
                        <td class="py-1 px-2">
                            <div class="h-10 w-10 mx-auto rounded-full bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                                @if($reporter->image)
                                    <img src="{{ asset('storage/' . $reporter->image) }}" class="h-full w-full object-cover" alt="">
                                @else
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-1 px-2">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $reporter->name }}</div>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs text-black dark:text-white">{{ $reporter->desk ?? '—' }}</span>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs text-black dark:text-white">{{ $reporter->subEditor->name ?? '—' }}</span>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs text-black dark:text-white">{{ $reporter->email }}</span>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs text-black dark:text-white">{{ $reporter->phone ?? 'N/A' }}</span>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs font-normal text-black dark:text-white">{{ $reporter->creator->name ?? 'System' }}</span>
                        </td>
                        <td class="py-1 px-2">
                            @if($reporter->status == 'active')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                <span class="w-1 h-1 rounded-full bg-amber-500"></span>
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="py-1 px-2 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.reporters.edit', $reporter->id) }}" class="p-1 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.reporters.destroy', $reporter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this reporter?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-8 text-center text-slate-500 dark:text-slate-400">No reporters found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-6 flex items-center justify-between">
            <span class="text-xs text-black dark:text-white font-normal">
                Showing {{ $reporters->firstItem() ?? 0 }} to {{ $reporters->lastItem() ?? 0 }} of {{ $reporters->total() }} entries
            </span>
            <div class="flex items-center gap-2">
                {{ $reporters->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@endsection
