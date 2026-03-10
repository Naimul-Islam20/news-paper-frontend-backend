@extends('admin.layout')

@section('title', 'Visitors Statistics')
@section('header_title', 'Visitors Statistics')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
        
        {{-- Date Filter Form --}}
        <form action="#" method="GET" class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Date From</label>
                    <input type="date" name="date_from" value="2026-03-10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Date To</label>
                    <input type="date" name="date_to" value="2026-03-10" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white">
                </div>
                <div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all shadow-sm text-sm shrink-0 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter Data
                    </button>
                </div>
            </div>
        </form>

        {{-- Stats Summary --}}
        <div class="p-4 bg-indigo-50 dark:bg-indigo-500/10 rounded-t-2xl border border-indigo-100 dark:border-indigo-500/20 flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Showing Data:</span>
                <span class="text-base font-bold text-indigo-900 dark:text-indigo-200 ml-2">Mar 2026</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">Total Visitors:</span>
                <span class="text-lg font-bold text-indigo-900 dark:text-indigo-200">311</span>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="overflow-x-auto border-x border-b border-slate-200 dark:border-slate-800 rounded-b-2xl">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Visitors Countries</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Total Unique Visitors</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @php
                        $data = [
                            ['date' => '10-03-2026', 'visitors' => 33],
                            ['date' => '09-03-2026', 'visitors' => 31],
                            ['date' => '08-03-2026', 'visitors' => 14],
                            ['date' => '07-03-2026', 'visitors' => 17],
                            ['date' => '06-03-2026', 'visitors' => 25],
                            ['date' => '05-03-2026', 'visitors' => 14],
                            ['date' => '04-03-2026', 'visitors' => 14],
                            ['date' => '03-03-2026', 'visitors' => 35],
                            ['date' => '02-03-2026', 'visitors' => 26],
                            ['date' => '01-03-2026', 'visitors' => 102],
                        ];
                    @endphp

                    @foreach($data as $row)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-sm font-medium text-slate-700 dark:text-slate-300">
                            {{ $row['date'] }}
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-1">
                                {{-- Placeholder for country icons/tags --}}
                                <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-[10px] text-slate-500 rounded border border-slate-200 dark:border-slate-700 uppercase">Multiple</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            {{ $row['visitors'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
