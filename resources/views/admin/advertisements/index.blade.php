@extends('admin.layout')

@section('title', 'Advertisement')
@section('header_title', 'Advertisement')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-8">
            <div class="relative w-full max-w-sm flex items-center">
                <input type="text" placeholder="Search advertisement..." class="w-full pl-10 pr-10 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <button type="button" class="absolute right-2 p-1 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            <a href="{{ route('admin.advertisements.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-sm text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Advertisement
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider w-24">Banner</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Location</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">URL</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider w-28">Status</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    {{-- Placeholder Row 1 --}}
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center">
                            <span class="text-sm font-medium text-slate-500">1</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="h-10 w-20 rounded-lg bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors font-medium">Summer Sale Banner</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 rounded text-[10px] font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-500/20">Sidebar</span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="#" class="text-xs text-indigo-500 hover:text-indigo-700 underline truncate max-w-[150px] inline-block">https://example.com/summer-sale</a>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.advertisements.edit') }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
