@extends('admin.layout')

@section('title', 'Edit Reporter')
@section('header_title', 'Edit Reporter')

@section('content')
<div class="py-1 w-full mx-auto">
    <form action="{{ route('admin.reporters.update', $reporter->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Unified Form Container --}}
        <div class="max-w-xl mx-auto bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
            @if($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-sm">
                    <p class="font-medium mb-1">দয়া করে নিচের ভুলগুলো ঠিক করুন:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="space-y-4">

                {{-- Reporter ধরন (ডেস্ক) – অবশ্যই, পোস্টে রিপোর্টার ডেস্ক/ধরন অনুযায়ী দেখাবে --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Reporter ধরন / ডেস্ক <span class="text-rose-500">*</span></label>
                    <input type="text" name="desk" value="{{ old('desk', $reporter->desk) }}" required placeholder="যেমন: ডিজিটাল ডেস্ক, সম্পাদকীয়, ডিজিটাল রিপোর্ট" class="w-full px-4 py-2.5 rounded-xl border @error('desk') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                    @error('desk')
                        <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ইউজার – নাম ইমেইল ফোন এখান থেকে --}}
                <div>
                    <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">User</label>
                    <div class="relative">
                        <select name="sub_editor_id" class="w-full px-4 py-2.5 rounded-xl border @error('sub_editor_id') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-black cursor-pointer">
                            @forelse($subEditors as $se)
                                <option value="{{ $se->id }}" {{ old('sub_editor_id', $reporter->sub_editor_id) == $se->id ? 'selected' : '' }}>{{ $se->name }}</option>
                            @empty
                                <option value="" disabled>কোন ইউজার নেই</option>
                            @endforelse
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">নাম, ইমেইল, ফোন সিলেক্ট করা ইউজার থেকে নেওয়া হয়।</p>
                    @error('sub_editor_id')
                        <p class="mt-1 text-xs text-rose-500 font-normal ml-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-[11px] font-normal text-black uppercase tracking-widest mb-1.5 ml-1">Account Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-black cursor-pointer">
                            <option value="active" {{ old('status', $reporter->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $reporter->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
