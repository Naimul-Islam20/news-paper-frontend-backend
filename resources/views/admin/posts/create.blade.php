@extends('admin.layout')

@section('title', 'Create New Post')
@section('header_title', 'Create New Post')

@section('content')
@php
    $existingImageValue = old('existing_image', $pickedImage ?? '');
    $skipDraftRestore = $errors->any() || session()->pull('clear_post_create_draft', false);
    $forceDraftClear = $skipDraftRestore && ! $errors->any();
@endphp
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form id="post-create-form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    {{-- Left Column: Primary Content --}}
                    <div class="lg:col-span-8 space-y-6">
                        {{-- Subtitle (above title on frontend) --}}
                        @php $showSubtitleInput = filled(old('subtitle')); @endphp
                        <div id="post-subtitle-field">
                            <div class="mb-2 ml-0.5 flex items-center gap-2">
                                <span class="text-sm font-normal text-slate-900">Subtitle</span>
                                <button
                                    type="button"
                                    id="toggle-post-subtitle"
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-md border border-dashed border-slate-300 text-sm font-medium text-slate-600 transition-all hover:border-indigo-400 hover:text-indigo-600 dark:border-slate-600 dark:text-slate-300 {{ $showSubtitleInput ? 'hidden' : '' }}"
                                    title="Subtitle যোগ করুন">+</button>
                            </div>
                            <div id="post-subtitle-input-wrap" class="{{ $showSubtitleInput ? '' : 'hidden' }}">
                                <input
                                    type="text"
                                    name="subtitle"
                                    id="post_subtitle"
                                    value="{{ old('subtitle') }}"
                                    maxlength="150"
                                    class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-700 text-xs md:text-sm">
                                @error('subtitle') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Title --}}
                        <div id="post-title-field">
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" id="post_title" value="{{ old('title') }}" required placeholder="Enter post title..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                            @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Sub Title Points --}}
                        @php
                            $oldPoints = old('sub_title_points', []);
                            $oldPoints = is_array($oldPoints) ? $oldPoints : [];
                            $showSubTitlePoints = collect($oldPoints)->contains(fn ($value) => trim((string) $value) !== '');
                            $oldPoints = collect($oldPoints)->filter(fn ($value) => trim((string) $value) !== '')->values()->all();
                        @endphp
                        <div id="sub-title-points-field">
                            <div class="mb-2 ml-0.5">
                                <button
                                    type="button"
                                    id="add-sub-title-point"
                                    class="inline-flex items-center rounded-md border border-dashed border-slate-300 px-2.5 py-1 text-xs font-normal text-slate-700 transition-all hover:border-indigo-400 hover:text-indigo-600 dark:border-slate-600 dark:text-slate-300">
                                    + Add point
                                </button>
                            </div>
                            <div id="sub-title-points-wrapper" class="{{ $showSubTitlePoints ? 'space-y-2' : 'hidden space-y-2' }}">
                                @foreach($oldPoints as $value)
                                    <div class="flex items-center gap-2 sub-title-point-row">
                                        <input
                                            type="text"
                                            name="sub_title_points[]"
                                            value="{{ $value }}"
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
                            @error('sub_title_points') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            @error('sub_title_points.*') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Category (multiple allowed) --}}
                        <div id="post-category-field">
                            <label class="block text-sm font-normal text-slate-900 dark:text-slate-200 mb-2 ml-0.5">Post Category <span class="text-rose-500">*</span></label>
                            <div class="p-4 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30 max-h-[300px] overflow-y-auto shadow-inner custom-scrollbar">
                                <div class="columns-1 md:columns-2 gap-x-12">
                                    @forelse($categories as $category)
                                        <div class="break-inside-avoid mb-2">
                                            <label class="flex items-center gap-2 cursor-pointer group py-1 px-2 rounded hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-all">
                                                <input
                                                    type="checkbox"
                                                    name="category_ids[]"
                                                    value="{{ $category->id }}"
                                                    class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-900"
                                                    {{ is_array(old('category_ids')) && in_array($category->id, old('category_ids')) ? 'checked' : '' }}
                                                >
                                                <span class="text-sm font-medium text-slate-900 dark:text-slate-200 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-all">{{ $category->name }}</span>
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
                            <div id="post-image-field">
                                <div class="mb-2 ml-0.5 flex items-center justify-between gap-2">
                                    <label class="text-sm font-normal text-slate-900">Featured Image <span class="text-rose-500">*</span></label>
                                    <a href="{{ route('admin.posts.pick-image', ['context' => 'create']) }}" class="inline-flex items-center gap-1 rounded-md border border-slate-200 px-2.5 py-1 text-xs font-medium text-indigo-600 hover:bg-indigo-50 dark:border-slate-700 dark:text-indigo-400 dark:hover:bg-indigo-500/10">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Media
                                    </a>
                                </div>
                                <input type="hidden" name="existing_image" id="existingImagePath" value="{{ $existingImageValue }}" @if($existingImageValue) data-preview-url="{{ storage_image_url($existingImageValue) }}" @endif>
                                <div class="relative w-full h-32 rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-xs shadow-sm bg-white dark:bg-slate-900" data-main-image-upload>
                                    <img id="mainImagePreview" class="absolute inset-0 z-[1] w-full h-full object-contain bg-slate-100 dark:bg-slate-800 hidden" alt="">
                                    <div id="mainImagePlaceholder" class="absolute inset-0 z-0 flex flex-col items-center justify-center gap-1.5">
                                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>Choose Image</span>
                                    </div>
                                    <input type="file" name="image" id="mainImageInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="absolute inset-0 z-20 opacity-0 cursor-pointer">
                                </div>
                                <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">ছবির অনুপাত: <span class="font-medium text-slate-600 dark:text-slate-300">১৬:৯</span> — আপলোডের পর সাইটে <span class="font-medium text-slate-600 dark:text-slate-300">৬০০×৩৩৮ px</span> এ সেভ হবে</p>
                                @error('image') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Image Caption</label>
                                <div class="h-32">
                                    <textarea name="image_caption" placeholder="Enter image caption..." class="w-full h-full px-4 py-3 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm italic resize-none bg-white dark:bg-slate-900">{{ old('image_caption') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Post Content --}}
                        <div id="post-description-field">
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Post Description <span class="text-rose-500">*</span></label>
                            <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm">
                                <textarea id="editor" name="description">{{ old('description') }}</textarea>
                            </div>
                            @error('description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    {{-- Right Column: Settings --}}
                    <div class="lg:col-span-4 space-y-6">

                        {{-- Reporter --}}
                        <div id="post-reporter-field">
                            <div class="flex items-center justify-between gap-2 mb-2 ml-0.5">
                                <label class="text-sm font-normal text-slate-900">Reporter <span class="text-rose-500">*</span></label>
                                <button type="button" onclick="openQuickReporterModal()" class="shrink-0 inline-flex items-center gap-1 px-2 py-1 text-xs font-normal text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-500/15 dark:border-indigo-500/30 dark:hover:bg-indigo-500/25 transition-all" title="নতুন Reporter যোগ করুন">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Add
                                </button>
                            </div>
                            <div class="relative">
                                <select name="reporter_id" id="post-reporter-select" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none font-normal text-slate-900 cursor-pointer text-sm">
                                    <option value="" disabled {{ old('reporter_id') ? '' : 'selected' }}>Select</option>
                                    @foreach($reporters as $reporter)
                                        <option value="{{ $reporter->id }}" {{ old('reporter_id') == $reporter->id ? 'selected' : '' }}>{{ $reporter->desk ?: $reporter->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('reporter_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror

                            <div id="quickReporterModal" class="fixed inset-0 z-[9999] hidden text-left">
                                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" id="quickReporterModalBackdrop"></div>
                                <div class="fixed inset-0 flex items-center justify-center p-4" id="quickReporterModalWrap">
                                    <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300 pointer-events-auto" id="quickReporterModalContainer">
                                        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                                            <h3 class="text-base font-semibold text-slate-900 dark:text-white">Add Reporter</h3>
                                            <button type="button" id="quickReporterModalCloseX" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                        <div class="p-5 space-y-4">
                                            <div>
                                                <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Reporter ধরন / ডেস্ক <span class="text-rose-500">*</span></label>
                                                <input type="text" id="quick-reporter-desk" placeholder="যেমন: ডিজিটাল ডেস্ক, সম্পাদকীয়" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                                                <p id="quick-reporter-error" class="mt-1 text-xs text-rose-500 hidden"></p>
                                            </div>
                                            <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                                                <button type="button" id="quickReporterModalCancel" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                                                <button type="button" id="confirm-quick-reporter-add" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Save Reporter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Division & District (Commented Out) --}}
                        {{-- <div class="grid grid-cols-2 gap-4">...</div> --}}

                        {{-- Hero Layer – 4 টা চেকবক্স, যেকোনো একটা সিলেক্ট করলে বাকি ৩টা সিলেক্ট করা যাবে না --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">Hero Layer</label>
                            <input type="hidden" name="hero_layer" id="hero_layer_value" value="{{ old('hero_layer') }}">
                            <div class="flex flex-wrap items-center gap-6">
                                @foreach([1 => '1st Layer', 2 => '2nd Layer', 3 => '3rd Layer', 4 => '4th Layer'] as $num => $label)
                                    <div class="flex items-center gap-2">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" class="hero-layer-checkbox sr-only peer" data-value="{{ $num }}" {{ old('hero_layer') == (string)$num ? 'checked' : '' }}>
                                            <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                        </label>
                                        <span class="text-sm font-normal text-slate-900">{{ $label }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2 ml-0.5 uppercase tracking-wider">বিশেষ সংবাদ</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_special_news" value="1" class="sr-only peer" {{ old('is_special_news') ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            </label>
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

                        {{-- Topics (Tags) moved to Sidebar --}}
                        <div>
                            <label class="block text-sm font-normal text-slate-900 dark:text-slate-200 mb-2 ml-0.5">Post Topics / Tags</label>
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
                                                    class="w-full pl-9 pr-4 py-1.5 text-xs rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 outline-none bg-white dark:bg-slate-950 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 transition-all font-medium"
                                                >
                                            </div>
                                            <button type="button" onclick="openQuickTopicModal('quickTopicModal', 'quickModalContainer')" class="shrink-0 p-1.5 text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-indigo-100 dark:text-indigo-400 dark:bg-indigo-500/15 dark:border-indigo-500/30 dark:hover:bg-indigo-500/25 transition-all" title="Quick Add Topic">
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
                                                        class="topic-chip available cursor-pointer px-2.5 py-1 text-xs font-normal bg-rose-50 text-rose-700 border border-rose-100 rounded-full hover:bg-rose-100 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30 dark:hover:bg-rose-500/25 transition-all"
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
                                                        class="topic-chip available {{ $idx >= 40 ? 'hidden' : '' }} cursor-pointer px-2.5 py-1 text-xs font-normal bg-slate-100 text-slate-700 border border-slate-200 rounded-full hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 transition-all"
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
                        Confirm & Publish
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<x-admin.post-image-cropper />
<x-admin.post-form-scroll-to-error form-id="post-create-form" :require-image="true" />
@endsection

@push('scripts')
<script>
    const POST_CREATE_DRAFT = {
        storageKey: 'admin_post_create_draft_v4',
        imageDbName: 'admin_post_create_draft',
        imageStoreName: 'uploaded_images',
        imageRecordKey: 'featured',
        skipRestore: @json($skipDraftRestore),
        forceClear: @json($forceDraftClear ?? false),
        serverExistingImage: @json($existingImageValue ?? ''),
        serverExistingImageUrl: @json(! empty($existingImageValue) ? storage_image_url($existingImageValue) : ''),
    };

    let isSeoManuallyEdited = false;
    let postCreateSaveTimer = null;
    let postCreateTopicAdd = null;
    let postCreateSaveInFlight = null;
    let postCreateDraftSubmitted = false;

    function openPostCreateImageDb() {
        return new Promise(function (resolve, reject) {
            const request = indexedDB.open(POST_CREATE_DRAFT.imageDbName, 1);
            request.onupgradeneeded = function () {
                const db = request.result;
                if (!db.objectStoreNames.contains(POST_CREATE_DRAFT.imageStoreName)) {
                    db.createObjectStore(POST_CREATE_DRAFT.imageStoreName);
                }
            };
            request.onsuccess = function () { resolve(request.result); };
            request.onerror = function () { reject(request.error); };
        });
    }

    function idbPutImage(record) {
        return openPostCreateImageDb().then(function (db) {
            return new Promise(function (resolve, reject) {
                const tx = db.transaction(POST_CREATE_DRAFT.imageStoreName, 'readwrite');
                tx.objectStore(POST_CREATE_DRAFT.imageStoreName).put(record, POST_CREATE_DRAFT.imageRecordKey);
                tx.oncomplete = function () { resolve(); };
                tx.onerror = function () { reject(tx.error); };
            });
        });
    }

    function idbGetImage() {
        return openPostCreateImageDb().then(function (db) {
            return new Promise(function (resolve, reject) {
                const tx = db.transaction(POST_CREATE_DRAFT.imageStoreName, 'readonly');
                const req = tx.objectStore(POST_CREATE_DRAFT.imageStoreName).get(POST_CREATE_DRAFT.imageRecordKey);
                req.onsuccess = function () { resolve(req.result || null); };
                req.onerror = function () { reject(req.error); };
            });
        });
    }

    function idbClearImage() {
        return openPostCreateImageDb().then(function (db) {
            return new Promise(function (resolve, reject) {
                const tx = db.transaction(POST_CREATE_DRAFT.imageStoreName, 'readwrite');
                tx.objectStore(POST_CREATE_DRAFT.imageStoreName).delete(POST_CREATE_DRAFT.imageRecordKey);
                tx.oncomplete = function () { resolve(); };
                tx.onerror = function () { reject(tx.error); };
            });
        }).catch(function () {});
    }

    function fileToDataUrl(file) {
        return new Promise(function (resolve, reject) {
            const reader = new FileReader();
            reader.onload = function (e) { resolve(e.target.result); };
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    function compressDataUrlForDraft(dataUrl, maxWidth, quality) {
        maxWidth = maxWidth || 600;
        quality = quality || 0.85;
        return new Promise(function (resolve, reject) {
            const img = new Image();
            img.onload = function () {
                const scale = Math.min(1, maxWidth / img.width);
                const width = Math.max(1, Math.round(img.width * scale));
                const height = Math.max(1, Math.round(img.height * scale));
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);
                resolve(canvas.toDataURL('image/jpeg', quality));
            };
            img.onerror = reject;
            img.src = dataUrl;
        });
    }

    async function getCurrentUploadedImagePayload() {
        const previewEl = document.getElementById('mainImagePreview');
        const fileInput = document.getElementById('mainImageInput');
        let dataUrl = '';
        let fileName = 'featured-image.jpg';

        if (fileInput && fileInput.files && fileInput.files[0]) {
            fileName = fileInput.files[0].name;
            try {
                dataUrl = await fileToDataUrl(fileInput.files[0]);
            } catch (e) {
                dataUrl = '';
            }
        }

        if (!dataUrl && previewEl && !previewEl.classList.contains('hidden') && previewEl.src) {
            if (previewEl.src.startsWith('data:')) {
                dataUrl = previewEl.src;
            } else if (previewEl.src.startsWith('blob:')) {
                try {
                    const blob = await fetch(previewEl.src).then(function (r) { return r.blob(); });
                    dataUrl = await fileToDataUrl(new File([blob], fileName, { type: blob.type || 'image/jpeg' }));
                } catch (e) {
                    dataUrl = '';
                }
            }
        }

        if (!dataUrl) {
            return null;
        }

        try {
            dataUrl = await compressDataUrlForDraft(dataUrl);
        } catch (e) {}

        if (!fileName.match(/\.(jpe?g|png|webp)$/i)) {
            fileName = fileName.replace(/\.[^.]+$/, '') + '.jpg';
        }

        return { dataUrl: dataUrl, fileName: fileName };
    }

    function applyImagePreview(previewUrl) {
        const preview = document.getElementById('mainImagePreview');
        const placeholder = document.getElementById('mainImagePlaceholder');
        if (preview && previewUrl) {
            preview.src = previewUrl;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        }
    }

    function clearExistingImagePath() {
        const hidden = document.getElementById('existingImagePath');
        if (!hidden) return;
        hidden.value = '';
        delete hidden.dataset.previewUrl;
    }

    function resetPostCreateImageUi() {
        const preview = document.getElementById('mainImagePreview');
        const placeholder = document.getElementById('mainImagePlaceholder');
        const fileInput = document.getElementById('mainImageInput');
        if (preview) {
            preview.removeAttribute('src');
            preview.classList.add('hidden');
        }
        if (placeholder) {
            placeholder.classList.remove('hidden');
        }
        if (fileInput) {
            fileInput.value = '';
        }
        clearExistingImagePath();
    }

    function applyExistingImagePreview(path, previewUrl) {
        const hidden = document.getElementById('existingImagePath');
        if (!hidden) return;
        hidden.value = path || '';
        if (path && previewUrl) {
            hidden.dataset.previewUrl = previewUrl;
            applyImagePreview(previewUrl);
        } else {
            delete hidden.dataset.previewUrl;
        }
    }

    function setFileOnMainInput(file) {
        const input = document.getElementById('mainImageInput');
        if (!input || !file) return;
        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
    }

    async function dataUrlToFile(dataUrl, filename) {
        const response = await fetch(dataUrl);
        const blob = await response.blob();
        const type = blob.type || 'image/jpeg';
        const ext = type.split('/')[1] || 'jpg';
        const name = filename || ('featured-image.' + ext);
        return new File([blob], name, { type: type, lastModified: Date.now() });
    }

    async function restorePostCreateDraftImage(draft) {
        if (POST_CREATE_DRAFT.serverExistingImage) {
            applyExistingImagePreview(POST_CREATE_DRAFT.serverExistingImage, POST_CREATE_DRAFT.serverExistingImageUrl);
            return;
        }

        let imageRecord = null;
        try {
            imageRecord = await idbGetImage();
        } catch (e) {
            imageRecord = null;
        }

        if (!imageRecord && draft && draft.image_data_url) {
            imageRecord = {
                dataUrl: draft.image_data_url,
                fileName: draft.image_file_name || 'featured-image.jpg',
            };
        }

        if (imageRecord && imageRecord.dataUrl) {
            clearExistingImagePath();
            try {
                const file = await dataUrlToFile(imageRecord.dataUrl, imageRecord.fileName);
                setFileOnMainInput(file);
                applyImagePreview(imageRecord.dataUrl);
            } catch (e) {
                console.warn('Post draft image restore failed', e);
            }
            return;
        }

        if (draft && draft.existing_image) {
            applyExistingImagePreview(draft.existing_image, draft.existing_image_preview || '');
        }
    }

    function collectPostCreateDraft() {
        const form = document.getElementById('post-create-form');
        if (!form) return null;

        const topicEntries = Array.from(form.querySelectorAll('#hidden-topic-inputs input[name="topic_ids[]"]')).map(function (input) {
            const id = input.value;
            const chip = document.querySelector('.topic-chip.available[data-id="' + id + '"]');
            const selectedChip = document.querySelector('#selected-topics-area div[data-id="' + id + '"]');
            return {
                id: id,
                name: chip ? chip.dataset.name : (selectedChip ? selectedChip.textContent.replace('×', '').trim() : 'Topic'),
                permanent: chip ? chip.dataset.permanent === 'true' : false,
            };
        });

        const description = adminEditorGetData('editor');

        const fileInput = document.getElementById('mainImageInput');
        const previewEl = document.getElementById('mainImagePreview');
        const hasUploadedFile = !!(fileInput && fileInput.files && fileInput.files.length > 0)
            || !!(previewEl && !previewEl.classList.contains('hidden') && previewEl.src
                && (previewEl.src.startsWith('data:') || previewEl.src.startsWith('blob:')));
        const hiddenImage = document.getElementById('existingImagePath');

        return {
            subtitle: document.getElementById('post_subtitle')?.value || '',
            title: document.getElementById('post_title')?.value || '',
            sub_title_points: Array.from(form.querySelectorAll('input[name="sub_title_points[]"]')).map(function (el) { return el.value; }),
            category_ids: Array.from(form.querySelectorAll('input[name="category_ids[]"]:checked')).map(function (el) { return el.value; }),
            existing_image: hasUploadedFile ? '' : (hiddenImage?.value || ''),
            existing_image_preview: hasUploadedFile ? '' : (hiddenImage?.dataset.previewUrl || ''),
            has_uploaded_image: hasUploadedFile,
            image_caption: form.querySelector('[name="image_caption"]')?.value || '',
            description: description,
            reporter_id: form.querySelector('[name="reporter_id"]')?.value || '',
            hero_layer: document.getElementById('hero_layer_value')?.value || '',
            is_special_news: !!form.querySelector('[name="is_special_news"]')?.checked,
            status: form.querySelector('[name="status"]')?.value || 'published',
            seo_keywords: document.getElementById('seo_keywords')?.value || '',
            is_seo_manual: isSeoManuallyEdited,
            topics: topicEntries,
            saved_at: Date.now(),
        };
    }

    async function savePostCreateDraft() {
        if (postCreateDraftSubmitted) {
            return;
        }

        if (postCreateSaveInFlight) {
            return postCreateSaveInFlight;
        }

        postCreateSaveInFlight = (async function () {
            try {
                const draft = collectPostCreateDraft();
                if (!draft) return;

                const imagePayload = await getCurrentUploadedImagePayload();
                if (imagePayload) {
                    draft.has_uploaded_image = true;
                    draft.existing_image = '';
                    draft.existing_image_preview = '';
                    await idbPutImage({
                        dataUrl: imagePayload.dataUrl,
                        fileName: imagePayload.fileName,
                        saved_at: Date.now(),
                    });
                } else if (draft.existing_image) {
                    draft.has_uploaded_image = false;
                    await idbClearImage();
                } else {
                    const idbImage = await idbGetImage().catch(function () { return null; });
                    draft.has_uploaded_image = !!idbImage;
                }

            const empty = !draft.title
                && !draft.subtitle
                && !draft.description
                    && draft.sub_title_points.every(function (p) { return !p; })
                    && !draft.image_caption
                    && !draft.existing_image
                    && !draft.has_uploaded_image
                    && draft.category_ids.length === 0
                    && !draft.reporter_id
                    && draft.topics.length === 0;

                if (empty) {
                    localStorage.removeItem(POST_CREATE_DRAFT.storageKey);
                    await idbClearImage();
                    return;
                }

                localStorage.setItem(POST_CREATE_DRAFT.storageKey, JSON.stringify(draft));
            } catch (e) {
                console.warn('Post draft save failed', e);
            } finally {
                postCreateSaveInFlight = null;
            }
        })();

        return postCreateSaveInFlight;
    }

    function schedulePostCreateDraftSave() {
        if (postCreateDraftSubmitted) {
            return;
        }

        clearTimeout(postCreateSaveTimer);
        postCreateSaveTimer = setTimeout(function () {
            savePostCreateDraft();
        }, 350);
    }

    function wipePostCreateDraftStorage(resetUi) {
        clearTimeout(postCreateSaveTimer);
        localStorage.removeItem(POST_CREATE_DRAFT.storageKey);
        idbClearImage();
        if (resetUi) {
            resetPostCreateImageUi();
        }
    }

    function clearPostCreateDraft() {
        postCreateDraftSubmitted = true;
        wipePostCreateDraftStorage(false);
    }

    function showSubTitlePointsSection() {
        const wrapper = document.getElementById('sub-title-points-wrapper');
        if (wrapper) wrapper.classList.remove('hidden');
    }

    function createSubTitlePointRow() {
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 sub-title-point-row';
        row.innerHTML = ''
            + '<input type="text" name="sub_title_points[]" class="flex-1 px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">'
            + '<button type="button" class="remove-sub-title-point inline-flex items-center justify-center w-8 h-8 rounded-full border border-slate-200 dark:border-slate-700 text-slate-400 hover:text-rose-600 hover:border-rose-300 text-sm" title="Remove point">&times;</button>';
        return row;
    }

    function restoreSubTitlePoints(points) {
        const wrapper = document.getElementById('sub-title-points-wrapper');
        if (!wrapper) return;
        const values = Array.isArray(points)
            ? points.map(function (value) { return String(value || '').trim(); }).filter(Boolean)
            : [];
        if (!values.length) return;
        wrapper.innerHTML = '';
        showSubTitlePointsSection();
        values.forEach(function (value) {
            const row = createSubTitlePointRow();
            const input = row.querySelector('input');
            if (input) input.value = value;
            wrapper.appendChild(row);
        });
    }

    async function restorePostCreateDraft() {
        if (POST_CREATE_DRAFT.skipRestore) return;
        let draft = null;
        try {
            draft = JSON.parse(localStorage.getItem(POST_CREATE_DRAFT.storageKey) || 'null');
        } catch (e) {
            draft = null;
        }

        const hasIdbImage = await idbGetImage().catch(function () { return null; });
        if (!draft && hasIdbImage) {
            await idbClearImage();
            resetPostCreateImageUi();
            return;
        }
        if (!draft && !hasIdbImage) return;
        if (!draft) {
            draft = { has_uploaded_image: true };
        }

        const form = document.getElementById('post-create-form');
        if (!form) return;

        const titleInput = document.getElementById('post_title');
        const seoTextarea = document.getElementById('seo_keywords');
        const subtitleInput = document.getElementById('post_subtitle');
        if (subtitleInput && typeof draft.subtitle === 'string') {
            subtitleInput.value = draft.subtitle;
            if (draft.subtitle.trim() !== '') {
                showPostSubtitleInput();
            }
        }
        if (titleInput && draft.title) titleInput.value = draft.title;
        if (seoTextarea && typeof draft.seo_keywords === 'string') seoTextarea.value = draft.seo_keywords;
        isSeoManuallyEdited = !!draft.is_seo_manual;

        restoreSubTitlePoints(draft.sub_title_points);

        form.querySelectorAll('input[name="category_ids[]"]').forEach(function (el) {
            el.checked = Array.isArray(draft.category_ids) && draft.category_ids.includes(el.value);
        });

        const captionEl = form.querySelector('[name="image_caption"]');
        if (captionEl && typeof draft.image_caption === 'string') captionEl.value = draft.image_caption;

        const reporterEl = form.querySelector('[name="reporter_id"]');
        if (reporterEl && draft.reporter_id) reporterEl.value = draft.reporter_id;

        const heroHidden = document.getElementById('hero_layer_value');
        if (heroHidden) heroHidden.value = draft.hero_layer || '';
        document.querySelectorAll('.hero-layer-checkbox').forEach(function (cb) {
            cb.checked = String(draft.hero_layer || '') === cb.getAttribute('data-value');
        });

        const specialEl = form.querySelector('[name="is_special_news"]');
        if (specialEl) specialEl.checked = !!draft.is_special_news;

        const statusEl = form.querySelector('[name="status"]');
        if (statusEl && draft.status) statusEl.value = draft.status;

        await restorePostCreateDraftImage(draft);

        if (Array.isArray(draft.topics) && postCreateTopicAdd) {
            draft.topics.forEach(function (topic) {
                postCreateTopicAdd(topic.id, topic.name, !!topic.permanent);
            });
        }

        if (draft.description) {
            adminEditorSetData('editor', draft.description);
        }
    }

    function showPostSubtitleInput() {
        const wrap = document.getElementById('post-subtitle-input-wrap');
        const toggle = document.getElementById('toggle-post-subtitle');
        const input = document.getElementById('post_subtitle');
        if (wrap) wrap.classList.remove('hidden');
        if (toggle) toggle.classList.add('hidden');
        if (input) input.focus();
    }

    function initPostSubtitleToggle() {
        const toggle = document.getElementById('toggle-post-subtitle');
        if (!toggle) return;
        toggle.addEventListener('click', showPostSubtitleInput);
    }

    function initPostCreateDraftAutosave() {
        const form = document.getElementById('post-create-form');
        if (!form) return;

        form.addEventListener('input', schedulePostCreateDraftSave);
        form.addEventListener('change', schedulePostCreateDraftSave);

        form.addEventListener('submit', function (event) {
            if (!event.defaultPrevented) {
                clearPostCreateDraft();
            }
        });

        form.querySelector('a[href*="pick-image"]')?.addEventListener('click', function () {
            savePostCreateDraft();
        });

        document.addEventListener('post-featured-image-updated', function (event) {
            clearExistingImagePath();
            const detail = event.detail || {};
            if (!detail.dataUrl) {
                savePostCreateDraft();
                return;
            }

            const fileName = detail.fileName || 'featured-image.jpg';
            idbPutImage({
                dataUrl: detail.dataUrl,
                fileName: fileName,
                saved_at: Date.now(),
            }).then(function () {
                return savePostCreateDraft();
            }).then(function () {
                return compressDataUrlForDraft(detail.dataUrl).then(function (compressed) {
                    return idbPutImage({
                        dataUrl: compressed,
                        fileName: fileName,
                        saved_at: Date.now(),
                    });
                });
            }).catch(function () {
                savePostCreateDraft();
            });
        });

        window.addEventListener('pagehide', function () {
            if (!postCreateDraftSubmitted) {
                savePostCreateDraft();
            }
        });
        window.addEventListener('beforeunload', function () {
            if (!postCreateDraftSubmitted) {
                savePostCreateDraft();
            }
        });
        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'hidden' && !postCreateDraftSubmitted) {
                savePostCreateDraft();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (POST_CREATE_DRAFT.forceClear) {
            wipePostCreateDraftStorage(true);
        } else if (POST_CREATE_DRAFT.serverExistingImage) {
            applyExistingImagePreview(POST_CREATE_DRAFT.serverExistingImage, POST_CREATE_DRAFT.serverExistingImageUrl);
        } else {
            const existingImagePath = document.getElementById('existingImagePath');
            if (existingImagePath && existingImagePath.dataset.previewUrl) {
                applyExistingImagePreview(existingImagePath.value, existingImagePath.dataset.previewUrl);
            }
        }

        const titleInput = document.getElementById('post_title');
        const seoTextarea = document.getElementById('seo_keywords');

        // Auto-fill SEO Keywords from Title as long as user hasn't edited SEO box
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

        initPostSubtitleToggle();
        initSubTitlePoints();
        initTopicsSelection();
        initMainImagePreview();
        initPostCreateDraftAutosave();
        if (!POST_CREATE_DRAFT.skipRestore) {
            restorePostCreateDraft().then(function () {
                if (!postCreateDraftSubmitted) {
                    setTimeout(savePostCreateDraft, 400);
                }
            });
        }
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
            if (selectedIds.has(String(id))) return;
            selectedIds.add(String(id));

            // Hide placeholder
            if (placeholder) placeholder.classList.add('hidden');

            // Create chip in selected area
            const chip = document.createElement('div');
            chip.className = `px-2.5 py-1 text-xs font-normal border rounded-full flex items-center gap-1.5 transition-all ${isPermanent ? 'bg-rose-50 text-rose-700 border-rose-100 dark:bg-rose-500/15 dark:text-rose-300 dark:border-rose-500/30' : 'bg-indigo-50 text-indigo-700 border-indigo-100 dark:bg-indigo-500/15 dark:text-indigo-300 dark:border-indigo-500/30'}`;
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
            schedulePostCreateDraftSave();
        }

        function removeTopic(id) {
            selectedIds.delete(String(id));
            
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
            schedulePostCreateDraftSave();
        }

        // Handle clicks on available chips
        document.querySelectorAll('.topic-chip.available').forEach(chip => {
            chip.addEventListener('click', function() {
                addTopic(this.dataset.id, this.dataset.name, this.dataset.permanent === 'true');
            });
        });

        // Handle removal
        area.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-topic')) {
                const chip = e.target.closest('div');
                removeTopic(chip.dataset.id);
            }
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

        // Quick Add Reporter
        const qrModal = document.getElementById('quickReporterModal');
        const qrContainer = document.getElementById('quickReporterModalContainer');
        const qrBackdrop = document.getElementById('quickReporterModalBackdrop');
        const qrWrap = document.getElementById('quickReporterModalWrap');
        const qrCloseX = document.getElementById('quickReporterModalCloseX');
        const qrCancel = document.getElementById('quickReporterModalCancel');
        const qrDeskInput = document.getElementById('quick-reporter-desk');
        const qrError = document.getElementById('quick-reporter-error');
        const qrConfirm = document.getElementById('confirm-quick-reporter-add');
        const reporterSelect = document.getElementById('post-reporter-select');

        window.openQuickReporterModal = function() {
            if (!qrModal || !qrContainer) return;
            if (qrError) {
                qrError.classList.add('hidden');
                qrError.textContent = '';
            }
            qrModal.classList.remove('hidden');
            setTimeout(() => {
                qrContainer.classList.remove('scale-95', 'opacity-0');
                qrContainer.classList.add('scale-100', 'opacity-100');
                if (qrDeskInput) qrDeskInput.focus();
            }, 10);
        };

        window.closeQuickReporterModal = function() {
            if (!qrModal || !qrContainer) return;
            qrContainer.classList.remove('scale-100', 'opacity-100');
            qrContainer.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { qrModal.classList.add('hidden'); }, 200);
        };

        if (qrBackdrop) qrBackdrop.addEventListener('click', closeQuickReporterModal);
        if (qrWrap) {
            qrWrap.addEventListener('click', function(e) {
                if (e.target === qrWrap) closeQuickReporterModal();
            });
        }
        if (qrCloseX) qrCloseX.addEventListener('click', closeQuickReporterModal);
        if (qrCancel) qrCancel.addEventListener('click', closeQuickReporterModal);

        if (qrConfirm) {
            qrConfirm.addEventListener('click', async function() {
                const desk = (qrDeskInput?.value || '').trim();
                if (!desk) {
                    if (qrError) {
                        qrError.textContent = 'রিপোর্টার ধরন/ডেস্ক লিখুন।';
                        qrError.classList.remove('hidden');
                    }
                    return;
                }

                this.disabled = true;
                const originalText = this.textContent;
                this.innerHTML = '<svg class="animate-spin h-3.5 w-3.5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

                try {
                    const response = await fetch("{{ route('admin.posts.reporters.quick-store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ desk: desk })
                    });

                    const data = await response.json();

                    if (response.ok && data.success && reporterSelect) {
                        const label = data.reporter.desk || data.reporter.name;
                        const option = document.createElement('option');
                        option.value = data.reporter.id;
                        option.textContent = label;
                        option.selected = true;
                        reporterSelect.appendChild(option);
                        reporterSelect.value = String(data.reporter.id);

                        if (qrDeskInput) qrDeskInput.value = '';
                        closeQuickReporterModal();
                    } else {
                        const message = data.message
                            || (data.errors && data.errors.desk && data.errors.desk[0])
                            || 'Reporter যোগ করা যায়নি।';
                        if (qrError) {
                            qrError.textContent = message;
                            qrError.classList.remove('hidden');
                        }
                    }
                } catch (err) {
                    if (qrError) {
                        qrError.textContent = 'Reporter যোগ করা যায়নি। আবার চেষ্টা করুন।';
                        qrError.classList.remove('hidden');
                    }
                } finally {
                    this.disabled = false;
                    this.textContent = originalText;
                }
            });
        }

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
                            newChip.className = 'topic-chip available cursor-pointer px-2.5 py-1 text-xs font-normal bg-slate-100 text-slate-700 border border-slate-200 rounded-full hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 dark:hover:bg-slate-700 transition-all opacity-40 pointer-events-none';
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

        postCreateTopicAdd = addTopic;

        // Pre-fill old selections (if validation fails and returns)
        @if(is_array(old('topic_ids')))
            @foreach(old('topic_ids') as $oldId)
                @php $t = $topics->firstWhere('id', $oldId); @endphp
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

    function initMainImagePreview() {
        if (window.AdminPostImageCrop) {
            window.AdminPostImageCrop.init('#mainImageInput');
        }
    }

    function initCKEditor() {
        if (!document.getElementById('editor')) {
            return;
        }

        adminLoadCkeditor(function () {
            adminCkeditorReplace('editor', { height: 400 }, function (editor) {
                editor.on('change', schedulePostCreateDraftSave);
                if (!POST_CREATE_DRAFT.skipRestore) {
                    try {
                        const draft = JSON.parse(localStorage.getItem(POST_CREATE_DRAFT.storageKey) || 'null');
                        if (draft && draft.description && !adminEditorGetData('editor')) {
                            adminEditorSetData('editor', draft.description);
                        }
                    } catch (e) {}
                }
            });
        });
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
            showSubTitlePointsSection();
            const row = createSubTitlePointRow();
            wrapper.appendChild(row);
            const input = row.querySelector('input');
            if (input) input.focus();
            schedulePostCreateDraftSave();
        });

        wrapper.addEventListener('click', function (event) {
            const target = event.target;
            if (!target.classList.contains('remove-sub-title-point')) return;
            const row = target.closest('.sub-title-point-row');
            if (!row) return;
            row.remove();
            if (!wrapper.querySelector('.sub-title-point-row')) {
                wrapper.classList.add('hidden');
            }
            schedulePostCreateDraftSave();
        });

        wrapper.addEventListener('input', schedulePostCreateDraftSave);
    }
</script>
@endpush
