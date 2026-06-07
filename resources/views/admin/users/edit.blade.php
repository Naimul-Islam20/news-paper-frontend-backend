@extends('admin.layout')

@section('title', 'Edit User')
@section('header_title', 'Edit User')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-6">
                {{-- Form Header --}}
                <div class="pb-6 border-b border-slate-100 dark:border-slate-800 mb-10">
                    <h3 class="text-sm font-medium text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.25 2.25 0 113.182 3.182L12 10.364l-3 1 1-3 9.586-9.586z"></path></svg>
                        Edit User Information
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8 mb-12">
                    {{-- User Profile Image --}}
                    <div class="md:col-span-2 flex items-center gap-6 mb-4">
                        <div class="w-20 h-20 rounded-full bg-slate-50 border-2 border-dashed border-slate-200 flex flex-col items-center justify-center relative overflow-hidden group cursor-pointer hover:bg-slate-100 transition-all">
                            @if ($user->image)
                                <img src="{{ storage_image_url($user->image) }}" class="absolute inset-0 w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <span class="absolute bottom-0 inset-x-0 bg-black/50 text-[8px] text-white py-1 text-center font-bold translate-y-full group-hover:translate-y-0 transition-all uppercase">Change</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-slate-900 dark:text-white mb-1">Update Profile Picture</h4>
                            <p class="text-xs text-slate-500">JPG, PNG or WEBP. Max 2MB.</p>
                        </div>
                    </div>

                    {{-- Username --}}
                    <div>
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="E.g. John Doe" class="w-full px-4 py-2 rounded-lg border @error('name') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 text-sm">
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Email Address <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="E.g. john@example.com" class="w-full px-4 py-2 rounded-lg border @error('email') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 text-sm">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="E.g. +880123456789" class="w-full px-4 py-2 rounded-lg border @error('phone') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 text-sm">
                        @error('phone')
                            <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Change Password <small class="text-slate-500">(খালি রাখলে আগের পাসওয়ার্ড থাকবে)</small></label>
                        @if(! $user->password_plain)
                        <p class="mb-2 text-xs text-amber-600 dark:text-amber-400 ml-0.5">পুরনো ইউজার — একবার পাসওয়ার্ড সেভ করলে এখানে দেখা যাবে।</p>
                        @endif
                        <div class="relative">
                            <input
                                type="text"
                                name="password"
                                id="user-password"
                                value="{{ old('password', $user->password_plain ?? '') }}"
                                placeholder="{{ $user->password_plain ? '' : 'পাসওয়ার্ড সেট নেই — নতুন দিন' }}"
                                autocomplete="new-password"
                                class="w-full px-4 py-2 pr-11 rounded-lg border @error('password') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 text-sm"
                            >
                            <button
                                type="button"
                                id="toggle-user-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                                aria-label="Hide password"
                                title="Hide password"
                            >
                                <svg id="user-password-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg id="user-password-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858 3.05a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Assigned Role</label>
                        <div class="relative">
                            <select name="role" id="user-role" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 cursor-pointer text-sm">
                                @foreach($allowedRoles as $value => $label)
                                    <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        @error('role')
                            <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="flex flex-col gap-3">
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-0.5 ml-0.5">Active Status</label>
                        <div class="flex items-center gap-3 h-full">
                            @if($user->role === 'admin')
                                {{-- Admin সবসময় active --}}
                                <label class="relative inline-flex items-center opacity-60 cursor-not-allowed">
                                    <input type="checkbox" name="status" value="1" class="sr-only peer" checked disabled>
                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                            @else
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $user->status) ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-20 border-t border-slate-100 dark:border-slate-800 mt-12">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-2 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 transition-all text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">
                        Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    var input = document.getElementById('user-password');
    var btn = document.getElementById('toggle-user-password');
    var eyeOpen = document.getElementById('user-password-eye-open');
    var eyeClosed = document.getElementById('user-password-eye-closed');
    if (!input || !btn) return;

    btn.addEventListener('click', function () {
        var hide = input.type === 'text';
        input.type = hide ? 'password' : 'text';
        if (eyeOpen) eyeOpen.classList.toggle('hidden', hide);
        if (eyeClosed) eyeClosed.classList.toggle('hidden', !hide);
        btn.setAttribute('aria-label', hide ? 'Show password' : 'Hide password');
        btn.setAttribute('title', hide ? 'Show password' : 'Hide password');
    });
})();
</script>
@endsection
