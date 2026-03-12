@extends('admin.layout')

@section('title', 'All Users')
@section('header_title', 'All Users')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-8">
            <div class="relative w-full max-w-sm flex items-center">
                <input type="text" placeholder="Search user..." class="w-full pl-10 pr-10 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add User
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-16 text-center">ID</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">User Details</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Role</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-28">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-32">Joined Date</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($users as $user)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4 text-center">
                            <span class="text-sm font-normal text-black dark:text-white">{{ $user->id }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400 overflow-hidden shrink-0">
                                    @if($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" class="w-full h-full object-cover" alt="">
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-normal text-black dark:text-white">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if($user->role == 'admin')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-normal bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">Admin</span>
                            @elseif($user->role == 'senior editor')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-normal bg-violet-50 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400 border border-violet-100 dark:border-violet-500/20">Senior Editor</span>
                            @elseif($user->role == 'sub editor')
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-normal bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400 border border-sky-100 dark:border-sky-500/20">Sub Editor</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-normal bg-slate-50 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400 border border-slate-100 dark:border-slate-500/20">{{ ucfirst($user->role) }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($user->status)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-xs text-black dark:text-white font-normal">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 dark:text-slate-400">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-6 flex items-center justify-between">
            <span class="text-xs text-black dark:text-white font-normal">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </span>
            <div class="flex items-center gap-2">
                {{ $users->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

@endsection
