@extends('admin.layout')

@section('title', 'Add New Advertisement')
@section('header_title', 'Add New Advertisement')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-lg border border-slate-200 dark:border-slate-800">
            <div class="p-6">
                <div class="mb-6 border-b border-slate-200 dark:border-slate-800 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-white">Advertisement Details</h2>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Name --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Advertisement Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Summer Sale Banner" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        </div>

                        {{-- URL --}}
                        <div>
                            <label for="url" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Target URL <span class="text-rose-500">*</span></label>
                            <input type="url" name="url" id="url" placeholder="https://example.com/promo" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                        </div>

                        {{-- Location --}}
                        <div>
                            <label for="location" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ad Location</label>
                            <select name="location" id="location" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-800 dark:text-white text-sm">
                                <option value="home_top">Home Top</option>
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
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        {{-- Image --}}
                        <div class="md:col-span-2">
                            <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Ad Image</label>
                            <input type="file" name="image" id="image" class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">Create Advertisement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

