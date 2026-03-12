@extends('admin.layout')

@section('title', 'Edit Page')
@section('header_title', 'Edit Page')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    {{-- Left Column: Settings --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Page Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" required value="{{ old('title', $page->title) }}" placeholder="Enter page title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 text-sm">
                            @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Page Category <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="category_id" required class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 cursor-pointer text-sm">
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $page->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Image --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Featured Image</label>
                            <div class="relative rounded-lg border border-slate-200 dark:border-slate-800 overflow-hidden">
                                @if($page->image)
                                    <div class="relative">
                                        <img id="imagePreview" src="{{ Storage::url($page->image) }}" class="w-full h-32 object-cover" alt="Current Image">
                                        <div class="absolute inset-0 bg-black/30 opacity-0 hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white text-xs">Click to change</span>
                                        </div>
                                    </div>
                                @else
                                    <div id="imagePlaceholder" class="h-28 flex flex-col items-center justify-center gap-1.5 text-slate-400 text-xs">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>Choose Image</span>
                                    </div>
                                @endif
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Page Status</label>
                            <div class="relative">
                                <select name="status" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 dark:text-white dark:bg-slate-950 cursor-pointer text-sm">
                                    <option value="active" {{ old('status', $page->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $page->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Page Content --}}
                    <div class="lg:col-span-8 flex flex-col">
                        <label class="block text-sm font-normal text-slate-900 dark:text-white mb-2 ml-0.5">Page Content</label>
                        <div class="flex-1 min-h-[400px]">
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm h-full">
                                <textarea id="editor" name="content" placeholder="Start writing page content here...">{{ old('content', $page->content) }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-800 mt-12">
                    <a href="{{ route('admin.pages.index') }}" class="px-6 py-2 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">
                        Update Page
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
                height: 300,
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

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('imagePreview');
                if (!preview) {
                    const placeholder = document.getElementById('imagePlaceholder');
                    if (placeholder) placeholder.innerHTML = `<img id="imagePreview" src="${e.target.result}" class="w-full h-32 object-cover">`;
                } else {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
