@extends('admin.layout')

@section('title', 'Add New Reporter')
@section('header_title', 'Add New Reporter')

@section('content')
<div class="py-1 w-full mx-auto">
    <form action="{{ route('admin.reporters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Unified Form Container --}}
        <div class="max-w-xl mx-auto bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
            <div class="space-y-4">
                
                {{-- Name --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Reporter Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter reporter name..." class="w-full px-4 py-2.5 rounded-xl border @error('name') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="reporer@example.com" class="w-full px-4 py-2.5 rounded-xl border @error('email') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                    @error('email')
                        <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Number --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+880 1xxx xxxxxx" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                </div>

                {{-- Address --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter full address..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                </div>

                {{-- Reporter Image --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Reporter Profile Photo</label>
                    <div class="relative h-28 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1.5 group hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px]">
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Upload Image</span>
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-[11px] font-normal text-black uppercase tracking-widest mb-1.5 ml-1">Account Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-black cursor-pointer">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800 mt-6">
                <a href="{{ route('admin.reporters.index') }}" class="px-5 py-2 text-sm font-normal text-black hover:text-slate-700 transition-all border border-slate-200 dark:border-slate-700 rounded-xl inline-block text-center text-black">Cancel</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-sm leading-none">
                    Save Reporter
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
