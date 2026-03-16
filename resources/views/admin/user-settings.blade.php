@extends('admin.layout')

@section('title', 'User Settings')

@section('header_title', 'Account Settings')

@section('header_subtitle', 'Update your personal information and profile image.')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6 sm:space-y-8">
        @if (session('status'))
            <div class="rounded-3xl bg-emerald-500/10 border border-emerald-500/20 px-4 sm:px-6 py-4 text-sm text-emerald-700 dark:text-emerald-400 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-3xl bg-rose-500/10 border border-rose-500/20 px-4 sm:px-6 py-4 text-sm text-rose-700 dark:text-rose-400 shadow-sm">
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

        <form method="POST" action="{{ route('admin.user-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
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
                    {{-- Profile Image (centered, click to add/edit, delete option) --}}
                    <div class="flex flex-col items-center justify-center pb-8 border-b border-slate-100 dark:border-slate-800">
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" class="hidden">
                        <div
                            role="button"
                            tabindex="0"
                            onclick="document.getElementById('image').click()"
                            onkeydown="if(event.key==='Enter') document.getElementById('image').click()"
                            class="relative w-28 h-28 rounded-2xl overflow-hidden border-2 border-slate-200 dark:border-slate-700 shadow-sm cursor-pointer group focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                        >
                            @if($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Profile" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-slate-900/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="w-12 h-12 rounded-full bg-white/90 dark:bg-slate-800/90 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7v2a2 2 0 01-2 2H7a2 2 0 01-2-2V7"></path></svg>
                                    </span>
                                </div>
                            @else
                                <div class="w-full h-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                    <span class="w-14 h-14 rounded-full bg-slate-300 dark:bg-slate-600 flex items-center justify-center group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20 transition-colors">
                                        <svg class="w-7 h-7 text-slate-500 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </span>
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400 text-center">
                            @if($user->image)
                                Click to change · JPG, PNG or GIF, max 2MB
                            @else
                                Click to add profile image
                            @endif
                        </p>
                        @if($user->image)
                            <label class="mt-2 flex items-center gap-2 text-xs text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 cursor-pointer">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                <span>Remove profile image</span>
                            </label>
                        @endif
                    </div>

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