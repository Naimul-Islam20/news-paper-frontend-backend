@extends('admin.layout')

@section('title', 'User Settings')

@section('header_title', 'Account Settings')

@section('header_subtitle', 'Update your personal information and security preferences.')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        @if (session('status'))
            <div class="rounded-3xl bg-emerald-500/10 border border-emerald-500/20 px-6 py-4 text-sm text-emerald-700 dark:text-emerald-400 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl bg-rose-500/10 border border-rose-500/20 px-6 py-4 text-sm text-rose-700 dark:text-rose-400 shadow-sm">
                <div class="flex items-center gap-3 mb-2 font-bold uppercase tracking-wider text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Please correct the following:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.user-settings.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Profile Section --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile Information
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 ml-9">
                        Update your public profile and contact information.
                    </p>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="name" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">
                                Full Name
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400"
                            >
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">
                                Email Address
                            </label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Security Section --}}
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Security & authentication
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 ml-9">
                        Update your password and manage session security.
                    </p>
                </div>

                <div class="p-8 space-y-8">
                    <div class="pb-8 border-b border-slate-100 dark:border-slate-800">
                        <label for="current_password" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1 mb-2">
                            Current Password
                        </label>
                        <input
                            id="current_password"
                            type="password"
                            name="current_password"
                            required
                            placeholder="Required to authorize changes"
                            class="w-full md:w-1/2 rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400"
                        >
                    </div>

                    <div class="grid gap-8 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="password" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">
                                New Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400"
                                autocomplete="new-password"
                            >
                            <p class="text-[10px] text-slate-400 ml-1">Leave blank to keep your current password.</p>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1">
                                Confirm New Password
                            </label>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="w-full rounded-2xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder-slate-400"
                                autocomplete="new-password"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button
                    type="submit"
                    class="flex items-center gap-3 px-8 py-4 rounded-2xl text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-100 dark:shadow-none transition-all transform hover:-translate-y-0.5 active:scale-95 group"
                >
                    <svg class="w-5 h-5 transition-transform group-hover:rotate-180 duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Update Account</span>
                </button>
            </div>
        </form>
    </div>
@endsection