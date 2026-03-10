@extends('admin.layout')

@section('title', 'Create New Page')
@section('header_title', 'Create New Page')

@section('content')
<div class="py-1 w-full mx-auto">
    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Unified Form Container --}}
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                
                {{-- Left Column: Settings (Title, Image, Status) --}}
                <div class="lg:col-span-4 space-y-4">
                    
                    {{-- Title --}}
                    <div>
                        <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Page Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" placeholder="Enter page title..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                    </div>

                    {{-- Image --}}
                    <div>
                        <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Featured Image</label>
                        <div class="relative h-28 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1.5 group hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px]">
                            <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Upload Image</span>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-[11px] font-normal text-black uppercase tracking-widest mb-1.5 ml-1">Page Status</label>
                        <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-normal text-black">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>

                {{-- Right Column: Page Content --}}
                <div class="lg:col-span-8 lg:border-l lg:border-slate-100 dark:lg:border-slate-800 lg:pl-5">
                    <div class="h-full min-h-[300px]">
                        <div class="border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden bg-white shadow-inner h-full">
                            <textarea id="editor" name="content" placeholder="Start writing page content here..."></textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800 mt-4">
                <button type="button" class="px-5 py-2 text-sm font-normal text-black hover:text-slate-700 transition-all border border-slate-200 dark:border-slate-700 rounded-xl">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-sm">
                    Publish Page
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    function initCKEditor() {
        if (typeof CKEDITOR !== 'undefined' && document.getElementById('editor')) {
            CKEDITOR.replace('editor', {
                height: 300, // Matching the post page style
                width: '100%',
                removeButtons: 'PasteFromWord',
                versionCheck: false,
            });
        }
    }

    if (document.readyState === 'complete') {
        initCKEditor();
    } else {
        window.addEventListener('load', initCKEditor);
    }
</script>
@endpush
