@extends('admin.layout')

@section('title', 'Edit Gallery')
@section('header_title', 'Edit Gallery')

@section('content')
<div class="py-1 w-full mx-auto">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="max-w-4xl mx-auto space-y-6">
            {{-- Section 1: Gallery Info --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2 uppercase tracking-wider">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Gallery Information
                    </h3>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Gallery Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" value="Election Banner 2024" placeholder="Enter gallery title..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Category <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select name="category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                        <option value="politics" selected>Politics</option>
                                        <option value="sports">Sports</option>
                                        <option value="entertainment">Entertainment</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                        <option value="active" selected>Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Image List --}}
            <div id="image-list" class="space-y-4">
                {{-- Existing Image Item 1 --}}
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 relative group">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 p-1 bg-rose-500 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all" title="Remove Image">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                        <div class="md:col-span-4">
                            <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image <span class="text-rose-500">*</span></label>
                            
                            {{-- Current Image Preview --}}
                            <div class="relative h-32 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800 flex items-center justify-center overflow-hidden mb-2 group/preview">
                                {{-- Placeholder for actual image --}}
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <div class="absolute inset-0 bg-black/50 hidden group-hover/preview:flex items-center justify-center transition-all cursor-pointer">
                                    <span class="text-white text-xs font-bold uppercase tracking-wider">Change Image</span>
                                    <input type="file" name="images[]" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-8 flex flex-col justify-center">
                            <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image Description</label>
                            <textarea name="image_desc[]" rows="4" placeholder="Enter image description..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none h-[128px]">A banner showing the upcoming election events and campaigns.</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add More Button --}}
            <div class="flex justify-center">
                <button type="button" onclick="addImageRow()" class="flex items-center gap-2 px-6 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                    <svg class="w-4 h-4 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    Another Image & Desc
                </button>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 pb-12">
                <a href="{{ route('admin.galleries.index') }}" class="px-8 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-sm font-normal">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function addImageRow() {
        const container = document.getElementById('image-list');
        const newRow = document.createElement('div');
        newRow.className = "bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 relative group animate-in fade-in zoom-in duration-300";
        
        newRow.innerHTML = `
            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 p-1 bg-rose-500 text-white rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <div class="md:col-span-4">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image <span class="text-rose-500">*</span></label>
                    <div class="relative h-32 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1.5 group/box hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px]">
                        <input type="file" name="images[]" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Choose Image</span>
                    </div>
                </div>
                <div class="md:col-span-8 flex flex-col justify-center">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image Description</label>
                    <textarea name="image_desc[]" rows="4" placeholder="Enter image description..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none h-[128px]"></textarea>
                </div>
            </div>
        `;
        container.appendChild(newRow);
    }
</script>
@endsection
