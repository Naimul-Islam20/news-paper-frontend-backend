@extends('admin.layout')

@section('title', 'Subscribe Management')
@section('header_title', 'Subscribe Management')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto space-y-8">
        
        {{-- Section 1: Send Subscription Email Form --}}
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-6">
                <div class="pb-6 border-b border-slate-100 dark:border-slate-800 mb-8">
                    <h3 class="text-lg font-medium text-slate-900 dark:text-white">Send Email to Subscribers</h3>
                </div>

                <form action="#" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Name --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Name</label>
                            <input type="text" name="name" placeholder="Enter name..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Email</label>
                            <input type="email" name="email" placeholder="Enter email..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>

                        {{-- Subject --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Subject</label>
                            <input type="text" name="subject" placeholder="Enter subject..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>

                        {{-- Link --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Link</label>
                            <input type="url" name="link" placeholder="https://example.com" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                    </div>

                    {{-- Message --}}
                    <div class="mb-8">
                        <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Message</label>
                        <textarea name="message" rows="4" placeholder="Write your message here..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 resize-none h-[120px] text-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Section 2: Subscriber List --}}
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-sm font-medium text-slate-900 dark:text-white">Subscriber List</h3>
                <div class="relative w-full max-w-xs">
                    <input type="text" placeholder="Search subscribers..." class="w-full pl-9 pr-4 py-1.5 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-xs text-sm">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-900/50">
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-16 text-center border-r border-slate-200 dark:border-slate-700">ID</th>
                            <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700">Email Address</th>
                            <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 border-r border-slate-200 dark:border-slate-700 text-center">Date</th>
                            <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-center w-32">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        {{-- Dummy Row 1 --}}
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700">
                            <td class="py-3.5 px-4 text-center text-sm text-slate-500 border-r border-slate-200 dark:border-slate-700">1</td>
                            <td class="py-3.5 px-4 border-r border-slate-200 dark:border-slate-700">
                                <div class="text-sm font-normal text-slate-900 dark:text-white">user@example.com</div>
                            </td>
                            <td class="py-3.5 px-4 text-center border-r border-slate-200 dark:border-slate-700">
                                <div class="text-xs text-slate-600 dark:text-slate-400">Mar 11, 2024</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">10:45 AM</div>
                            </td>
                        </tr>
                        {{-- Dummy Row 2 --}}
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700">
                            <td class="py-3.5 px-4 text-center text-sm text-slate-500 border-r border-slate-200 dark:border-slate-700">2</td>
                            <td class="py-3.5 px-4 border-r border-slate-200 dark:border-slate-700">
                                <div class="text-sm font-normal text-slate-900 dark:text-white">subscriber@gmail.com</div>
                            </td>
                            <td class="py-3.5 px-4 text-center border-r border-slate-200 dark:border-slate-700">
                                <div class="text-xs text-slate-600 dark:text-slate-400">Feb 28, 2024</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">02:15 PM</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Placeholder --}}
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <p class="text-xs text-slate-500">Showing 1 to 2 of 150 subscribers</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-slate-200 dark:border-slate-800 rounded text-xs text-slate-500 hover:bg-slate-50">Previous</button>
                    <button class="px-3 py-1 border border-slate-200 dark:border-slate-800 rounded text-xs text-slate-500 hover:bg-slate-50">Next</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
