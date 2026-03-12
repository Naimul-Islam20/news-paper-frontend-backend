@extends('admin.layout')

@section('title', 'Create New Page')
@section('header_title', 'Create New Page')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Left Column: Settings --}}
                    <div class="lg:col-span-4 space-y-6">
                        
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Page Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required placeholder="Enter page title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Page Category <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="category_id" required class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 cursor-pointer text-sm bg-white">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Image --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Featured Image</label>
                            <div class="relative h-28 rounded-lg border border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-xs shadow-sm">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Choose Image</span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Page Status</label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 cursor-pointer text-sm">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Page Content --}}
                    <div class="lg:col-span-8 flex flex-col">
                        <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Page Content</label>
                        <div class="flex-1 min-h-[400px]">
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm h-full">
                                <textarea id="editor" name="content" placeholder="Start writing page content here..."></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-800 mt-12">
                    <a href="#" class="px-6 py-2 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 transition-all text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">
                        Confirm & Publish
                    </button>
                </div>
            </div>
        </form>
    </div>
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
