@extends('admin.layout')

@section('header_title', 'Create New Post')

@section('content')
<div class="px-0 py-8 w-full mx-auto">
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        {{-- Unified Form Container --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-sm p-8 space-y-10">
            
            {{-- Header Actions --}}
            <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Post Details</h2>
                    <p class="text-xs text-slate-500 mt-1">Fill in the fields below to publish your news.</p>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 transition-all">Save Draft</button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-sm">
                        Publish Post
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Primary Content --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Title & Subtitle --}}
                    <div class="space-y-4 text-black">
                        <div>
                            <label class="block text-xs font-normal mb-1.5 ml-0.5 uppercase tracking-wide">Post Title <span class="text-rose-500">*</span></label>
                            <input type="text" name="title" placeholder="Enter post title..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                        </div>
                        <div>
                            <label class="block text-xs font-normal mb-1.5 ml-0.5 uppercase tracking-wide">Sub Title</label>
                            <input type="text" name="sub_title" placeholder="Secondary headline..." class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                        </div>
                    </div>

                    {{-- Grouped Category Selection Box --}}
                    <div class="space-y-4">
                        <label class="block text-sm font-normal text-black ml-1">Post Categories</label>
                        <div class="bg-slate-50/50 dark:bg-slate-950/50 border border-slate-100 dark:border-slate-800 rounded-[2rem] p-6 shadow-inner max-h-[300px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800 scrollbar-track-transparent">
                            <div class="columns-1 md:columns-2 gap-8">
                                @foreach($categories as $category)
                                <div class="break-inside-avoid block w-full mb-6">
                                    {{-- Parent Category --}}
                                    <label class="flex items-center gap-2.5 cursor-pointer group mb-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category['id'] }}" class="w-4 h-4 rounded-md border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all">
                                        <span class="text-xs font-normal text-black uppercase tracking-tight group-hover:text-indigo-600 transition-all">{{ $category['name'] }}</span>
                                    </label>

                                    {{-- Sub Categories --}}
                                    @if(count($category['sub_categories']) > 0)
                                    <div class="ml-3 space-y-1">
                                        @foreach($category['sub_categories'] as $sub)
                                        <label class="flex items-center gap-2 cursor-pointer group">
                                            <input type="checkbox" name="categories[]" value="{{ $sub['id'] }}" class="w-3.5 h-3.5 rounded border-slate-300 text-indigo-500 focus:ring-indigo-400 transition-all">
                                            <span class="text-[10px] font-normal text-black group-hover:text-indigo-600 transition-all uppercase tracking-wide">{{ $sub['name'] }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Location Section --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-normal text-black mb-2">Select Division</label>
                            <select name="division" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                                <option value="" disabled selected>-- Select Division --</option>
                                @foreach($divisions as $div)
                                    <option>{{ $div }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-black mb-2">Select District</label>
                            <select name="district" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                                <option value="" disabled selected>-- Select District --</option>
                                @foreach($districts as $dist)
                                    <option>{{ $dist }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Media & Caption --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-normal text-black mb-2">Featured Image</label>
                            <div class="relative h-28 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1 group hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px] space-y-2">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>Upload</span>
                            </div>
                        </div>
                        <div class="md:col-span-2 flex flex-col justify-end pb-1">
                            <label class="block text-sm font-normal text-black mb-2">Image Caption</label>
                            <input type="text" name="image_caption" placeholder="Enter image caption..." class="w-full px-5 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none italic font-normal text-black">
                        </div>
                    </div>
                </div>

                {{-- Right Column: Settings Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-slate-50 dark:bg-slate-950/50 rounded-[2rem] border border-slate-100 dark:border-slate-800/80 p-8 space-y-8">
                        {{-- Settings Groups with Yes/No --}}
                        <div class="space-y-6">
                            @foreach([['name' => 'breaking_news', 'label' => 'Breaking News'], ['name' => 'slider_news', 'label' => 'Slider News'], ['name' => 'category_pin', 'label' => 'Category Pin']] as $setting)
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                                <span class="text-xs font-normal text-black uppercase tracking-wide">{{ $setting['label'] }}</span>
                                <div class="flex items-center gap-2">
                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                        <input type="radio" name="{{ $setting['name'] }}" value="1" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        <span class="text-xs font-normal text-black">Yes</span>
                                    </label>
                                    <label class="flex items-center gap-1.5 cursor-pointer">
                                        <input type="radio" name="{{ $setting['name'] }}" value="0" checked class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-slate-300">
                                        <span class="text-xs font-normal text-black">No</span>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Selects & Inputs --}}
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-normal text-black uppercase tracking-widest mb-2 ml-1">Reporter</label>
                                <select name="reporter" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-normal text-black">
                                    <option value="" disabled selected>-- Select Reporter --</option>
                                    <option>Staff Reporter</option>
                                    <option>District Reporter</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-normal text-black uppercase tracking-widest mb-2 ml-1">Post Status</label>
                                <select name="status" class="w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 outline-none font-normal text-black">
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
     {{-- Visual Divider --}}
                <div class="relative py-12">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-slate-200 dark:border-slate-800"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-6 py-2 rounded-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Editor & SEO Area</span>
                    </div>
                </div>

                {{-- Dedicated Content Area --}}
                <div class="bg-white dark:bg-slate-900/50 rounded-[3rem] border border-slate-100 dark:border-slate-800/60 p-8 md:p-12 shadow-sm space-y-10">
                    {{-- Description area --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between px-1">
                            <label class="block text-sm font-normal text-black">Post Description</label>
                            <span class="text-[10px] font-normal text-black uppercase tracking-wider">Rich Text Editor</span>
                        </div>
                        <div class="border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden bg-white shadow-inner">
                            <textarea id="editor" name="description" placeholder="Start writing your news story here..."></textarea>
                        </div>
                    </div>

                    {{-- SEO Section --}}
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-3 px-1">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <label class="block text-sm font-normal text-black">SEO Search Keywords</label>
                        </div>
                        <input type="text" name="seo_keywords" placeholder="Enter keywords separated by commas (e.g. news, politics, world)..." class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                    </div>

                    {{-- Related News Section --}}
                    <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800/50 mt-4">
                        <div class="flex items-center gap-3 px-1">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <label class="block text-sm font-normal text-black">Related News ID</label>
                        </div>
                        <input type="text" name="related_news_id" placeholder="Related News ID (e.g. 101, 102, 103)..." class="w-full px-6 py-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                        <p class="text-[10px] font-normal text-black ml-1 italic opacity-60">Related News ID (Comma Separated No Space)</p>
                    </div>
                </div>
            </div>

            {{-- Bottom Actions --}}
            <div class="flex items-center justify-end gap-3 pt-8 border-t border-slate-100 dark:border-slate-800">
                <button type="button" class="px-8 py-3.5 text-sm font-bold text-slate-500 border border-slate-200 dark:border-slate-800 rounded-2xl hover:bg-slate-50 transition-all">Discard Changes</button>
                <button type="submit" class="px-10 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl hover:scale-[1.02] transition-all shadow-xl shadow-indigo-100/50 dark:shadow-none">
                    Submit Post
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
                height: 500,
                width: '100%',
                removeButtons: 'PasteFromWord',
                versionCheck: false, // This hides the security warning
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
