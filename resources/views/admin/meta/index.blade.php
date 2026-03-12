@extends('admin.layout')

@section('title', 'SEO & Meta Settings')
@section('header_title', 'SEO & Meta Settings')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-6xl mx-auto">
        <form action="{{ route('admin.meta.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            
            <div class="p-8 space-y-12">
                {{-- 1. Site Info --}}
                <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 space-y-8">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Site Information
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Name</label>
                            <input type="text" name="site_name" placeholder="E.g. My Newspaper" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Title</label>
                            <input type="text" name="site_title" placeholder="SEO Title" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Keywords</label>
                            <input type="text" name="site_keywords" placeholder="Keyword1, Keyword2, Keyword3" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Email</label>
                            <input type="email" name="site_email" placeholder="info@example.com" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Contact Number</label>
                            <input type="text" name="site_number" placeholder="+880123456789" class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>

                        {{-- Logo & Icon --}}
                        <div class="grid grid-cols-2 gap-6 md:col-span-2">
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Logo</label>
                                <div class="relative h-24 rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-[10px] shadow-sm">
                                    <input type="file" name="site_logo" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Upload Logo</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Icon (Favicon)</label>
                                <div class="relative h-24 rounded-lg border-2 border-dashed border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-50 transition-all cursor-pointer overflow-hidden font-normal text-slate-600 text-[10px] shadow-sm">
                                    <input type="file" name="site_icon" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span>Upload Icon</span>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Website Description</label>
                            <textarea name="site_description" rows="3" placeholder="Brief website description..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm"></textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. Social Info --}}
                <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 space-y-8">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Social Information
                        </h3>
                    </div>

                    <div id="social-links-container" class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Facebook Link</label>
                            <input type="text" name="facebook_link" placeholder="https://facebook.com/..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Twitter Link</label>
                            <input type="text" name="twitter_link" placeholder="https://twitter.com/..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Instagram Link</label>
                            <input type="text" name="instagram_link" placeholder="https://instagram.com/..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">YouTube Link</label>
                            <input type="text" name="youtube_link" placeholder="https://youtube.com/..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" onclick="addSocialLink()" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-indigo-600 border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add More Link
                        </button>
                    </div>
                </div>

                {{-- 3. Google Map --}}
                <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 space-y-8">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Google Map Settings
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Map Link</label>
                            <input type="text" name="map_link" placeholder="https://google.com/maps/..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Map Description</label>
                            <input type="text" name="map_desc" placeholder="Location description..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                    </div>
                </div>

                {{-- 4. Address --}}
                <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 space-y-8">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Office Address
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Address 1</label>
                        <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white shadow-sm">
                            <textarea id="editor" name="address_1" placeholder="Enter full address here..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- 5. Editor & Publisher Information --}}
                <div class="p-6 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20 space-y-8">
                    <div class="pb-4 border-b border-slate-200 dark:border-slate-800">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Editor & Publisher Information
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">সম্পাদক (Editor Name)</label>
                            <input type="text" name="editor_name" placeholder="সম্পাদকের নাম লিখুন..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">প্রকাশক (Publisher Name)</label>
                            <input type="text" name="publisher_name" placeholder="প্রকাশকের নাম লিখুন..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                        </div>
                    </div>
                </div>

                {{-- Unified Save Button --}}
                <div class="flex items-center justify-end pt-12 border-t border-slate-100 dark:border-slate-800 mt-12">
                    <button type="submit" class="px-12 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-indigo-500/25 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Save All Settings
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
                height: 200,
                width: '100%',
                removeButtons: 'PasteFromWord',
                versionCheck: false,
            });
        }
    }

    function addSocialLink() {
        const container = document.getElementById('social-links-container');
        const count = container.children.length + 1;
        const div = document.createElement('div');
        div.className = "group relative";
        div.innerHTML = `
            <label class="block text-sm font-normal text-slate-900 mb-2 ml-0.5">Additional Link ${count - 4}</label>
            <div class="flex gap-2">
                <input type="text" name="extra_social_links[]" placeholder="https://..." class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-slate-900 text-sm">
                <button type="button" onclick="this.closest('.group').remove()" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            </div>
        `;
        container.appendChild(div);
    }

    if (document.readyState === 'complete') {
        initCKEditor();
    } else {
        window.addEventListener('load', initCKEditor);
    }
</script>
@endpush
