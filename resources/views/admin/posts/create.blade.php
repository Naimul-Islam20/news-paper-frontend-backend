@extends('admin.layout')

@section('title', 'Create New Post')
@section('header_title', 'Create New Post')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Left Column: Primary Content --}}
                    <div class="lg:col-span-8 space-y-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="post_title" value="{{ old('title') }}" required placeholder="Enter post title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                            @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Sub Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Sub Title</label>
                            <input type="text" name="sub_title" value="{{ old('sub_title') }}" placeholder="Enter sub title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                            @error('sub_title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Categories --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Categories</label>
                            <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 max-h-[300px] overflow-y-auto shadow-inner">
                                <div class="columns-1 md:columns-2 gap-x-12">
                                    @forelse($categories as $category)
                                        <div class="break-inside-avoid mb-4">
                                            <label class="flex items-center gap-2 cursor-pointer group py-0.5">
                                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 transition-all">{{ $category->name }}</span>
                                            </label>

                                            @if($category->subCategories->count() > 0)
                                                <div class="ml-6 space-y-1 mt-1 border-l-2 border-slate-200 pl-3">
                                                    @foreach($category->subCategories as $sub)
                                                        <label class="flex items-center gap-2 cursor-pointer group py-0.5">
                                                            <input type="checkbox" name="categories[]" value="{{ $sub->id }}" class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-500 focus:ring-indigo-400">
                                                            <span class="text-xs font-normal text-slate-600 dark:text-slate-400 group-hover:text-indigo-500 transition-all">{{ $sub->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400">No categories found.</p>
                                    @endforelse
                                </div>
                            </div>
                            @error('categories') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Image & Caption --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Featured Image</label>
                                <div class="relative h-32 rounded-lg border border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-xs shadow-sm bg-white dark:bg-slate-900">
                                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMainImage(this)">
                                    <img id="mainImagePreview" class="absolute inset-0 w-full h-full object-cover hidden">
                                    <div id="mainImagePlaceholder" class="flex flex-col items-center justify-center gap-1.5">
                                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>Choose Image</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Image Caption</label>
                                <div class="h-32">
                                    <textarea name="image_caption" placeholder="Enter image caption..." class="w-full h-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm italic resize-none bg-white dark:bg-slate-900">{{ old('image_caption') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Post Content --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Description</label>
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm">
                                <textarea id="editor" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Settings --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Reporter --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Reporter</label>
                            <div class="relative">
                                <select name="reporter_id" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 cursor-pointer text-sm">
                                    <option value="" disabled selected>-- Select Reporter --</option>
                                    @foreach($reporters as $reporter)
                                        <option value="{{ $reporter->id }}" {{ old('reporter_id') == $reporter->id ? 'selected' : '' }}>{{ $reporter->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Division & District (Commented Out) --}}
                        {{-- <div class="grid grid-cols-2 gap-4">...</div> --}}

                        {{-- Main Section Layers --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">Main Section</label>
                            <div class="rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach([
                                    ['value' => '1', 'label' => '1st Layer'],
                                    ['value' => '2', 'label' => '2nd Layer'],
                                    ['value' => '3', 'label' => '3rd Layer'],
                                    ['value' => '4', 'label' => '4th Layer']
                                ] as $layer)
                                <div class="flex items-center justify-between px-4 py-3">
                                    <span class="text-xs font-medium text-slate-600">{{ $layer['label'] }}</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="main_section_layer" value="{{ $layer['value'] }}" {{ old('main_section_layer') == $layer['value'] ? 'checked' : '' }} class="sr-only peer layer-checkbox">
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <p class="mt-2 text-[10px] text-slate-400 italic">* You can select only one layer or none.</p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Status</label>
                            <select name="status" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 text-sm outline-none font-normal text-slate-900">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">SEO Keywords</label>
                            <textarea name="seo_keywords" id="seo_keywords" placeholder="news, politics, world..." class="w-full h-20 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm resize-none bg-white dark:bg-slate-900">{{ old('seo_keywords') }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800 mt-8">
                    <a href="{{ route('admin.posts.index') }}" class="px-6 py-2 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 transition-all text-sm">
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
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('post_title');
        const seoTextarea = document.getElementById('seo_keywords');
        let isSeoManuallyEdited = false;

        // Auto-fill SEO Keywords from Title as long as user hasn't edited SEO box
        titleInput.addEventListener('input', function() {
            if (!isSeoManuallyEdited) {
                seoTextarea.value = titleInput.value;
            }
        });

        // Detect manual edits to SEO Keywords
        seoTextarea.addEventListener('input', function() {
            isSeoManuallyEdited = true;
            // If user clears the box, reset sync capability
            if (this.value === '') {
                isSeoManuallyEdited = false;
                seoTextarea.value = titleInput.value;
            }
        });

        // Handle Mutually Exclusive Layers
        const checkboxes = document.querySelectorAll('.layer-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(c => {
                        if (c !== this) c.checked = false;
                    });
                }
            });
        });
    });

    function previewMainImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('mainImagePreview');
                const placeholder = document.getElementById('mainImagePlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function initCKEditor() {
        if (typeof CKEDITOR !== 'undefined' && document.getElementById('editor')) {
            CKEDITOR.replace('editor', {
                height: 400,
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
