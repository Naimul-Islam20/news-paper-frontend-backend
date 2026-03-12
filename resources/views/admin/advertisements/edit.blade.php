@extends('admin.layout')

@section('title', 'Edit Advertisement')
@section('header_title', 'Edit Advertisement')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-lg border border-slate-200 dark:border-slate-800">
            <div class="p-6">
                <div class="mb-6 border-b border-slate-200 dark:border-slate-800 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Edit Advertisement</h2>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Advertisement Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" id="name" value="Election Banner 2024" placeholder="Summer Sale Banner" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        </div>

                        {{-- URL --}}
                        <div>
                            <label for="url" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL <span class="text-rose-500">*</span></label>
                            <input type="url" name="url" id="url" value="https://example.com/promo" placeholder="https://example.com/promo" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        </div>

                        {{-- Location --}}
                        <div>
                            <label for="location" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ad Location</label>
                            <select name="location" id="location" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                                <option value="home_top" selected>Home Top</option>
                                <option value="home_sidebar">Home Sidebar</option>
                                <option value="category_top">Category Top</option>
                                <option value="post_detail_sidebar">Post Detail Sidebar</option>
                                <option value="footer_above">Above Footer</option>
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- Image --}}
                        <div class="md:col-span-2">
                            <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ad Image</label>
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-12 bg-slate-100 rounded border border-slate-200 dark:bg-slate-800 dark:border-slate-700 flex items-center justify-center overflow-hidden">
                                     <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <input type="file" name="image" id="image" class="flex-1 text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>

                        {{-- Custom Ad Code --}}
                        <div class="md:col-span-2">
                            <label for="custom_add_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Custom Ad Code (HTML/Script)</label>
                            <textarea name="custom_add_code" id="custom_add_code" rows="5" placeholder="Paste your code here..." class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm font-mono"></textarea>
                            <p class="mt-1 text-xs text-slate-500">* If custom code is provided, it will override the uploaded image.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200 dark:border-slate-800">
                        <a href="{{ route('admin.advertisements.index') }}" class="px-4 py-2 border border-slate-300 dark:border-slate-700 rounded-md text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

