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

                        {{-- Sub Title Points --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Sub Title Points</label>
                            @php
                                $oldPoints = old('sub_title_points');
                                if (is_null($oldPoints)) {
                                    $decoded = json_decode($post->sub_title ?? '', true);
                                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                        $oldPoints = $decoded;
                                    } elseif(!empty($post->sub_title)) {
                                        $oldPoints = [$post->sub_title];
                                    } else {
                                        $oldPoints = [''];
                                    }
                                }
                                if (!is_array($oldPoints) || empty($oldPoints)) {
                                    $oldPoints = [''];
                                }
                            @endphp
                            <div id="sub-title-points-wrapper" class="space-y-2">
                                @foreach($oldPoints as $idx => $value)
                                    <div class="flex items-center gap-2 sub-title-point-row">
                                        <input
                                            type="text"
                                            name="sub_title_points[]"
                                            value="{{ $value }}"
                                            placeholder="Sub title point {{ $idx + 1 }}"
                                            class="flex-1 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm"
                                        >
                                        <button
                                            type="button"
                                            class="remove-sub-title-point inline-flex items-center justify-center w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-600 hover:border-rose-300 text-sm"
                                            title="Remove point"
                                        >&times;</button>
                                    </div>
                                @endforeach
                            </div>
                            <button
                                type="button"
                                id="add-sub-title-point"
                                class="mt-2 inline-flex items-center px-3 py-1.5 rounded-lg border border-dashed border-slate-300 text-xs font-normal text-slate-700 hover:border-indigo-400 hover:text-indigo-600 transition-all"
                            >
                                + Add point
                            </button>
                            @error('sub_title_points') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            @error('sub_title_points.*') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Category (multiple allowed) --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Category <span class="text-rose-500">*</span></label>
                            <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 max-h-[300px] overflow-y-auto shadow-inner">
                                <div class="columns-1 md:columns-2 gap-x-12">
                                    @php $selectedCategoryIds = $post->categories->pluck('id')->toArray(); @endphp
                                    @forelse($categories as $category)
                                        <div class="break-inside-avoid mb-2">
                                            <label class="flex items-center gap-2 cursor-pointer group py-1 px-2 rounded hover:bg-emerald-50 transition-all">
                                                <input
                                                    type="checkbox"
                                                    name="category_ids[]"
                                                    value="{{ $category->id }}"
                                                    {{ in_array($category->id, old('category_ids', $selectedCategoryIds)) ? 'checked' : '' }}
                                                    class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                                >
                                                <span class="text-sm font-medium text-slate-900 dark:text-white group-hover:text-emerald-700 transition-all">{{ $category->name }}</span>
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-xs text-slate-400">No post-type categories found.</p>
                                    @endforelse
                                </div>
                            </div>
                            @error('category_ids') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>



                        {{-- Image & Caption --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Featured Image <span class="text-rose-500">*</span></label>
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
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Description <span class="text-rose-500">*</span></label>
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm">
                                <textarea id="editor" name="description">{{ old('description', $post->description) }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Right Column: Settings --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Reporter --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Reporter <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <select name="reporter_id" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 cursor-pointer text-sm">
                                    <option value="" disabled>-- Reporter ধরন / ডেস্ক নির্বাচন করুন --</option>
                                    @foreach($reporters as $reporter)
                                        <option value="{{ $reporter->id }}" {{ old('reporter_id', $post->reporter_id) == $reporter->id ? 'selected' : '' }}>{{ $reporter->desk ?: $reporter->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Hero Layer – 4 টা চেকবক্স, যেকোনো একটা সিলেক্ট করলে বাকি ৩টা সিলেক্ট করা যাবে না --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">Hero Layer</label>
                            <input type="hidden" name="hero_layer" id="hero_layer_value" value="{{ old('hero_layer', $post->hero_layer) }}">
                            <div class="flex flex-wrap items-center gap-6">
                                @foreach([1 => '1st Layer', 2 => '2nd Layer', 3 => '3rd Layer', 4 => '4th Layer'] as $num => $label)
                                    <div class="flex items-center gap-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="hero-layer-checkbox sr-only peer" data-value="{{ $num }}" {{ old('hero_layer', $post->hero_layer) == (string)$num ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                        </label>
                                        <span class="text-sm font-normal text-slate-900">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-2 text-[10px] text-slate-400 italic">* যেকোনো একটা সিলেক্ট করুন; একটা সিলেক্ট করলে বাকিগুলো অটো বন্ধ হয়ে যাবে।</p>
                        </div>

                        {{-- বিশেষ সংবাদ – সিলেক্ট করলে এই পোস্ট বিশেষ সংবাদ পেজে দেখাবে, নতুন ডাটা প্রথমে --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">বিশেষ সংবাদ</label>
                            <div class="flex items-center gap-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_special_news" value="1" class="sr-only peer" {{ old('is_special_news', $post->is_special_news) ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                </label>
                                <span class="text-sm font-normal text-slate-900">সিলেক্ট করলে এই পোস্ট বিশেষ সংবাদ পেজে দেখাবে (নতুন প্রথমে)</span>
                            </div>
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

                        {{-- Topics (Tags) moved to Sidebar --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Topics / Tags</label>
                            <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 shadow-inner">
                                <div id="topics-interface" class="space-y-4">
                                    {{-- Selected Topics Container --}}
                                    <div id="selected-topics-area" class="flex flex-wrap gap-2 min-h-[40px] p-2 bg-white dark:bg-slate-900 rounded-lg border border-dashed border-slate-300 dark:border-slate-700 font-medium">
                                        <p id="no-topics-selected" class="text-xs text-slate-400 italic py-1 font-normal">No topics selected</p>
                                    </div>

                                    {{-- Search & Create Container --}}
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <div class="relative flex-grow">
                                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                                </span>
                                                <input 
                                                    type="text" 
                                                    id="topic-search-input" 
                                                    placeholder="Search topics..." 
                                                    class="w-full pl-9 pr-4 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 outline-none bg-white dark:bg-slate-900 transition-all font-medium"
                                                >
                                            </div>
                                            <button type="button" onclick="openQuickTopicModal('quickTopicModal', 'quickModalContainer')" class="shrink-0 p-1.5 text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition-all" title="Quick Add Topic">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- QUICK ADD TOPIC MODAL (Identical to Topic Index) --}}
                                    <div id="quickTopicModal" class="fixed inset-0 z-[9999] hidden text-left">
                                        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" id="quickTopicModalBackdrop"></div>
                                        <div class="fixed inset-0 flex items-center justify-center p-4 pointer-events-none">
                                            <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300 pointer-events-auto" id="quickModalContainer">
                                                <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                                                    <div>
                                                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">Add New Topic</h3>
                                                        <p class="text-xs text-slate-500 mt-0.5">Create and automatically select a new topic.</p>
                                                    </div>
                                                    <button type="button" id="quickTopicModalCloseX" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                                <div class="p-5 space-y-4">
                                                    <div>
                                                        <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Topic Name <span class="text-rose-500">*</span></label>
                                                        <input type="text" id="quick-topic-name" placeholder="e.g. আইন আদালত" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Slug</label>
                                                        <input type="text" id="quick-topic-slug" placeholder="auto-generated from name" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-xs focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-500 dark:text-slate-400">
                                                    </div>
                                                    <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                                                        <button type="button" id="quickTopicModalCancel" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                                                        <button type="button" id="confirm-quick-add" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Save Topic</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php 
                                        $permanentTopics = $topics->where('can_delete', false);
                                        $otherTopics = $topics->where('can_delete', true);
                                    @endphp

                                    <div id="topics-selector-container" class="max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                                        {{-- Permanent Topics (Divisions) --}}
                                        <div class="mb-4">
                                            <p class="text-[10px] uppercase tracking-widest text-slate-400 mb-2 font-bold">বিভাগসমূহ</p>
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach($permanentTopics as $topic)
                                                    <div 
                                                        class="topic-chip available cursor-pointer px-2.5 py-1 text-xs font-normal bg-rose-50 text-rose-700 border border-rose-100 rounded-full hover:bg-rose-100 transition-all"
                                                        data-id="{{ $topic->id }}"
                                                        data-name="{{ $topic->name }}"
                                                        data-slug="{{ $topic->slug }}"
                                                        data-permanent="true"
                                                    >
                                                        {{ $topic->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- Other Topics --}}
                                        <div>
                                            <p class="text-[10px] uppercase tracking-widest text-slate-400 mb-2 font-bold">অন্যান্য</p>
                                            <div id="other-topics-list" class="flex flex-wrap gap-1.5 font-medium">
                                                @foreach($otherTopics as $idx => $topic)
                                                    <div 
                                                        class="topic-chip available {{ $idx >= 40 ? 'hidden' : '' }} cursor-pointer px-2.5 py-1 text-xs font-normal bg-slate-100 text-slate-700 border border-slate-200 rounded-full hover:bg-slate-200 transition-all"
                                                        data-id="{{ $topic->id }}"
                                                        data-name="{{ $topic->name }}"
                                                        data-slug="{{ $topic->slug }}"
                                                        data-permanent="false"
                                                    >
                                                        {{ $topic->name }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            {{-- Loading Sentinel for Infinite Scroll --}}
                                            @if($otherTopics->count() > 40)
                                                <div id="topics-loader-sentinel" class="h-10 flex items-center justify-center mt-2">
                                                    <div class="flex items-center gap-2 text-slate-400 text-[10px] font-medium">
                                                        <svg class="animate-spin h-3.5 w-3.5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        <span>Loading more...</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Hidden Inputs Container --}}
                                    <div id="hidden-topic-inputs"></div>
                                </div>
                            </div>
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

        initSubTitlePoints();
        initTopicsSelection();
    });

    function initTopicsSelection() {
        const area = document.getElementById('selected-topics-area');
        const hiddenContainer = document.getElementById('hidden-topic-inputs');
        const placeholder = document.getElementById('no-topics-selected');
        const showMoreBtn = document.getElementById('show-more-topics');
        const searchInput = document.getElementById('topic-search-input');
        const allChips = document.querySelectorAll('.topic-chip.available');
        
        const selectedIds = new Set();

        // Search logic
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                
                if (query === '') {
                    // Reset to initial state
                    allChips.forEach((chip, idx) => {
                        // Only show first 40 of 'other' topics + all permanent
                        const isPermanent = chip.dataset.permanent === 'true';
                        const otherIdx = Array.from(document.querySelectorAll('#other-topics-list .topic-chip.available')).indexOf(chip);
                        
                        if (isPermanent || (otherIdx !== -1 && otherIdx < 40)) {
                            chip.classList.remove('hidden');
                        } else {
                            chip.classList.add('hidden');
                        }
                    });
                    if (showMoreBtn) showMoreBtn.classList.remove('hidden');
                    return;
                }

                // Filtering
                allChips.forEach(chip => {
                    const name = chip.dataset.name.toLowerCase();
                    const slug = chip.dataset.slug ? chip.dataset.slug.toLowerCase() : '';
                    if (name.includes(query) || slug.includes(query)) {
                        chip.classList.remove('hidden');
                    } else {
                        chip.classList.add('hidden');
                    }
                });

                if (showMoreBtn) showMoreBtn.classList.add('hidden');
            });
        }

        function addTopic(id, name, isPermanent) {
            id = id.toString();
            if (selectedIds.has(id)) return;
            selectedIds.add(id);

            // Hide placeholder
            if (placeholder) placeholder.classList.add('hidden');

            // Create chip in selected area
            const chip = document.createElement('div');
            chip.className = `px-2.5 py-1 text-xs font-normal border rounded-full flex items-center gap-1.5 transition-all ${isPermanent ? 'bg-rose-50 text-rose-700 border-rose-100' : 'bg-indigo-50 text-indigo-700 border-indigo-100'}`;
            chip.dataset.id = id;
            chip.innerHTML = `
                ${name}
                <button type="button" class="remove-topic font-bold hover:text-red-600">&times;</button>
            `;
            area.appendChild(chip);

            // Add hidden input
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'topic_ids[]';
            input.value = id;
            input.id = `input-topic-${id}`;
            hiddenContainer.appendChild(input);

            // Mark in selector
            const selectorChip = document.querySelector(`.topic-chip.available[data-id="${id}"]`);
            if (selectorChip) selectorChip.classList.add('opacity-40', 'pointer-events-none');
        }

        function removeTopic(id) {
            id = id.toString();
            selectedIds.delete(id);
            
            // Remove chip
            const chip = area.querySelector(`div[data-id="${id}"]`);
            if (chip) chip.remove();

            // Remove hidden input
            const input = document.getElementById(`input-topic-${id}`);
            if (input) input.remove();

            // Show placeholder if empty
            if (selectedIds.size === 0 && placeholder) {
                placeholder.classList.remove('hidden');
            }

            // Unmark in selector
            const selectorChip = document.querySelector(`.topic-chip.available[data-id="${id}"]`);
            if (selectorChip) selectorChip.classList.remove('opacity-40', 'pointer-events-none');
        }

        // Handle clicks on available chips
        document.querySelectorAll('.topic-chip.available').forEach(chip => {
            chip.addEventListener('click', function() {
                addTopic(this.dataset.id, this.dataset.name, this.dataset.permanent === 'true');
            });
        });

        // Modal Helpers
        const qModal = document.getElementById('quickTopicModal');
        const qContainer = document.getElementById('quickModalContainer');
        const qBackdrop = document.getElementById('quickTopicModalBackdrop');
        const qCloseX = document.getElementById('quickTopicModalCloseX');
        const qCancel = document.getElementById('quickTopicModalCancel');

        window.openQuickTopicModal = function() {
            qModal.classList.remove('hidden');
            setTimeout(() => {
                qContainer.classList.remove('scale-95', 'opacity-0');
                qContainer.classList.add('scale-100', 'opacity-100');
                document.getElementById('quick-topic-name').focus();
            }, 10);
        }

        window.closeQuickTopicModal = function() {
            qContainer.classList.remove('scale-100', 'opacity-100');
            qContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { qModal.classList.add('hidden'); }, 200);
        }

        if (qBackdrop) qBackdrop.addEventListener('click', closeQuickTopicModal);
        if (qCloseX) qCloseX.addEventListener('click', closeQuickTopicModal);
        if (qCancel) qCancel.addEventListener('click', closeQuickTopicModal);

        // Auto-slugification for Quick Add
        (function() {
            const nameInput = document.getElementById('quick-topic-name');
            const slugInput = document.getElementById('quick-topic-slug');
            if (!nameInput || !slugInput) return;

            function slugify(str) {
                return str.toString().toLowerCase().trim()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w-]+/g, '')       // Remove all non-word chars
                    .replace(/--+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
            }

            let slugManuallyChanged = false;
            
            // When typing in name, update slug if NOT manually edited
            nameInput.addEventListener('keyup', () => {
                if (!slugManuallyChanged) {
                    slugInput.value = slugify(nameInput.value);
                }
            });

            // When typing in slug, slugify it in real-time and mark as manual
            slugInput.addEventListener('input', (e) => {
                slugManuallyChanged = true;
                const start = e.target.selectionStart;
                const end = e.target.selectionEnd;
                
                // Keep allow user to type but replace spaces/special on the fly
                // or just wait for blur. User wants space to be -
                let val = slugInput.value;
                val = val.toLowerCase().replace(/\s+/g, '-');
                slugInput.value = val;
                
                // Try to keep cursor position
                slugInput.setSelectionRange(start, end);
            });

            // Final slugify on blur for slug input
            slugInput.addEventListener('blur', () => {
                slugInput.value = slugify(slugInput.value);
            });
        })();

        // Handle Quick Add AJAX
        const confirmBtn = document.getElementById('confirm-quick-add');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', async function() {
                const nameInput = document.getElementById('quick-topic-name');
                const slugInput = document.getElementById('quick-topic-slug');
                const name = nameInput.value.trim();
                const slug = slugInput.value.trim();
                
                if (!name) return;

                this.disabled = true;
                const originalText = this.textContent;
                this.innerHTML = '<svg class="animate-spin h-3.5 w-3.5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                try {
                    const response = await fetch("{{ route('admin.topics.quick-store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ name: name, slug: slug })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Add to selected
                        addTopic(data.topic.id, data.topic.name, false);
                        
                        // Clear and close
                        nameInput.value = '';
                        slugInput.value = '';
                        closeQuickTopicModal();
                        
                        // Add to "Other" list dynamically
                        const otherList = document.getElementById('other-topics-list');
                        if (otherList) {
                            const newChip = document.createElement('div');
                            newChip.className = 'topic-chip available cursor-pointer px-2.5 py-1 text-xs font-normal bg-slate-100 text-slate-700 border border-slate-200 rounded-full hover:bg-slate-200 transition-all opacity-40 pointer-events-none';
                            newChip.dataset.id = data.topic.id;
                            newChip.dataset.name = data.topic.name;
                            newChip.dataset.slug = data.topic.slug;
                            newChip.dataset.permanent = 'false';
                            newChip.textContent = data.topic.name;
                            otherList.prepend(newChip);
                        }
                    } else {
                        alert(data.message || 'Error adding topic');
                    }
                } catch (error) {
                    console.error('Quick add error:', error);
                    alert('Failed to add topic. Please try again.');
                } finally {
                    this.disabled = false;
                    this.textContent = originalText;
                }
            });
        }

        // Handle removal
        area.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-topic')) {
                const chip = e.target.closest('div');
                removeTopic(chip.dataset.id);
            }
        });

        // Auto-load on Scroll (Infinite Scroll)
        const sentinel = document.getElementById('topics-loader-sentinel');
        if (sentinel) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    // Only trigger if visible AND not searching
                    if (entry.isIntersecting && (!searchInput || searchInput.value.trim() === '')) {
                        // Small delay for visual feedback
                        setTimeout(() => {
                            const hiddenItems = document.querySelectorAll('.topic-chip.available.hidden');
                            let count = 0;
                            hiddenItems.forEach(item => {
                                if (count < 20) {
                                    item.classList.remove('hidden');
                                    count++;
                                }
                            });

                            const remaining = document.querySelectorAll('.topic-chip.available.hidden').length;
                            if (remaining === 0) {
                                sentinel.classList.add('hidden');
                                observer.unobserve(sentinel);
                            }
                        }, 300);
                    }
                });
            }, {
                root: document.getElementById('topics-selector-container'),
                threshold: 0.1
            });
            observer.observe(sentinel);
        }

        // Pre-fill selections
        @php 
            $selectedTopicIds = old('topic_ids', $post->topics->pluck('id')->toArray());
        @endphp
        
        @if(!empty($selectedTopicIds))
            @foreach($selectedTopicIds as $id)
                @php $t = $topics->firstWhere('id', $id); @endphp
                @if($t)
                    addTopic("{{ $t->id }}", "{{ $t->name }}", {{ $t->can_delete ? 'false' : 'true' }});
                @endif
            @endforeach
        @endif
    }

    // Hero Layer: একটাই সিলেক্ট থাকবে, বাকি ৩টা অটো আনচেক
    function initHeroLayerCheckboxes() {
        document.querySelectorAll('.hero-layer-checkbox').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var hidden = document.getElementById('hero_layer_value');
                if (this.checked) {
                    hidden.value = this.getAttribute('data-value');
                    document.querySelectorAll('.hero-layer-checkbox').forEach(function(other) {
                        if (other !== cb) other.checked = false;
                    });
                } else {
                    hidden.value = '';
                }
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroLayerCheckboxes);
    } else {
        initHeroLayerCheckboxes();
    }

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

    function initSubTitlePoints() {
        const wrapper = document.getElementById('sub-title-points-wrapper');
        const addBtn = document.getElementById('add-sub-title-point');
        if (!wrapper || !addBtn) return;

        addBtn.addEventListener('click', function () {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 sub-title-point-row';
            row.innerHTML = `
                <input
                    type="text"
                    name="sub_title_points[]"
                    placeholder="Sub title point"
                    class="flex-1 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm"
                >
                <button
                    type="button"
                    class="remove-sub-title-point inline-flex items-center justify-center w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-600 hover:border-rose-300 text-sm"
                    title="Remove point"
                >&times;</button>
            `;
            wrapper.appendChild(row);
        });

        wrapper.addEventListener('click', function (event) {
            const target = event.target;
            if (target.classList.contains('remove-sub-title-point')) {
                const row = target.closest('.sub-title-point-row');
                if (!row) return;
                const rows = wrapper.querySelectorAll('.sub-title-point-row');
                if (rows.length > 1) {
                    row.remove();
                } else {
                    const input = row.querySelector('input[name="sub_title_points[]"]');
                    if (input) input.value = '';
                }
            }
        });
    }
</script>
@endpush
