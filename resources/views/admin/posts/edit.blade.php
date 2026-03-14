@extends('admin.layout')

@section('title', 'Edit Post')
@section('header_title', 'Edit Post')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Left Column: Primary Content --}}
                    <div class="lg:col-span-8 space-y-6">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="post_title" value="{{ old('title', $post->title) }}" required placeholder="Enter post title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                            @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Sub Title --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Sub Title</label>
                            <input type="text" name="sub_title" value="{{ old('sub_title', $post->sub_title) }}" placeholder="Enter sub title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                            @error('sub_title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Category (single) --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Category</label>
                            <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 max-h-[300px] overflow-y-auto shadow-inner">
                                <div class="columns-1 md:columns-2 gap-x-12">
                                    @php $selectedCategoryId = $post->categories->pluck('id')->first(); @endphp
                                    @forelse($categories as $category)
                                        <div class="break-inside-avoid mb-2">
                                            <label class="flex items-center gap-2 cursor-pointer group py-1 px-2 rounded hover:bg-indigo-50 transition-all">
                                                <input
                                                    type="radio"
                                                    name="category_id"
                                                    value="{{ $category->id }}"
                                                    {{ old('category_id', $selectedCategoryId) == $category->id ? 'checked' : '' }}
                                                    class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                                >
                                                <span class="text-sm font-medium text-slate-900 dark:text-white group-hover:text-indigo-600 transition-all">{{ $category->name }}</span>
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400">No post-type categories found. Please add categories with type "Post" first.</p>
                                    @endforelse
                                </div>
                            </div>
                            @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Image & Caption --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Featured Image</label>
                                <div class="relative h-32 rounded-lg border border-slate-200 dark:border-slate-800 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-xs shadow-sm bg-white dark:bg-slate-900">
                                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMainImage(this)">
                                    @if($post->image)
                                        <img id="mainImagePreview" src="{{ Storage::url($post->image) }}" class="absolute inset-0 w-full h-full object-cover">
                                        <div id="mainImagePlaceholder" class="hidden flex flex-col items-center justify-center gap-1.5">
                                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span>Change Image</span>
                                        </div>
                                    @else
                                        <img id="mainImagePreview" class="absolute inset-0 w-full h-full object-cover hidden">
                                        <div id="mainImagePlaceholder" class="flex flex-col items-center justify-center gap-1.5">
                                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span>Choose Image</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Image Caption</label>
                                <div class="h-32">
                                    <textarea name="image_caption" placeholder="Enter image caption..." class="w-full h-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm italic resize-none bg-white dark:bg-slate-900">{{ old('image_caption', $post->image_caption) }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Post Content --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Description</label>
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm">
                                <textarea id="editor" name="description">{{ old('description', $post->description) }}</textarea>
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
                                    <option value="" disabled>-- Select Reporter --</option>
                                    @foreach($reporters as $reporter)
                                        <option value="{{ $reporter->id }}" {{ old('reporter_id', $post->reporter_id) == $reporter->id ? 'selected' : '' }}>{{ $reporter->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Hero Layer --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">Hero Layer</label>
                            <div class="relative">
                                <select name="hero_layer" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 text-sm outline-none font-normal text-slate-900 cursor-pointer">
                                    <option value="" {{ old('hero_layer', $post->hero_layer) ? '' : 'selected' }}>None (Not in hero)</option>
                                    <option value="1" {{ old('hero_layer', $post->hero_layer) == '1' ? 'selected' : '' }}>1st Layer</option>
                                    <option value="2" {{ old('hero_layer', $post->hero_layer) == '2' ? 'selected' : '' }}>2nd Layer</option>
                                    <option value="3" {{ old('hero_layer', $post->hero_layer) == '3' ? 'selected' : '' }}>3rd Layer</option>
                                    <option value="4" {{ old('hero_layer', $post->hero_layer) == '4' ? 'selected' : '' }}>4th Layer</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <p class="mt-2 text-[10px] text-slate-400 italic">* Select which hero layer this post will appear in, or choose None.</p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Status</label>
                            <select name="status" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 text-sm outline-none font-normal text-slate-900">
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status', $post->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">SEO Keywords</label>
                            <textarea name="seo_keywords" id="seo_keywords" placeholder="news, politics, world..." class="w-full h-20 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm resize-none bg-white dark:bg-slate-900">{{ old('seo_keywords', $post->seo_keywords) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100 dark:border-slate-800 mt-8">
                    <a href="{{ route('admin.posts.index') }}" class="px-6 py-2 border border-slate-200 dark:border-slate-800 text-slate-900 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 transition-all text-sm">
                        Cancel
                    </a>
                    <button type="submit" class="px-8 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">
                        Update Post
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
        let isSeoManuallyEdited = {{ old('seo_keywords', $post->seo_keywords) ? 'true' : 'false' }};

        // Auto-fill SEO Keywords from Title
        titleInput.addEventListener('input', function() {
            if (!isSeoManuallyEdited) {
                seoTextarea.value = titleInput.value;
            }
        });

        // Detect manual edits to SEO Keywords
        seoTextarea.addEventListener('input', function() {
            isSeoManuallyEdited = true;
            if (this.value === '') {
                isSeoManuallyEdited = false;
                seoTextarea.value = titleInput.value;
            }
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
