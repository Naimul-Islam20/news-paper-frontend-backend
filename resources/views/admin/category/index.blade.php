@extends('admin.layout')

@section('header_title', 'Category Management')

@section('content')
<div class="px-8 py-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Category List</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage and organize your news categories.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openModal()" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all shadow-lg shadow-indigo-200 dark:shadow-none order-first">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Category
            </button>
            <button onclick="openSubModal()" class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 rounded-xl font-semibold transition-all hover:bg-slate-50 dark:hover:bg-slate-800 shadow-sm border-dashed">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add Sub Category
            </button>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800 divide-x divide-slate-200 dark:divide-slate-800">
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">ID</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Name</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Type</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Subcategories</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Description</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($categories as $category)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors divide-x divide-slate-100 dark:divide-slate-800">
                        <td class="px-6 py-4 text-sm font-medium text-black">{{ $category['id'] }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-black">{{ $category['name'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold uppercase tracking-wider text-black">
                                {{ $category['type'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-black max-w-[200px] truncate">{{ $category['subcategory'] }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 text-xs font-bold rounded-xl {{ $category['status'] == 'Active' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                {{ $category['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-black max-w-[250px] truncate">{{ $category['description'] }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditModal()" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Placeholder --}}
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <p class="text-sm text-slate-500">Showing 1 to {{ count($categories) }} of {{ count($categories) }} results</p>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 text-xs font-bold text-slate-500 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg opacity-50 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1.5 text-xs font-bold text-slate-500 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg opacity-50 cursor-not-allowed">Next</button>
            </div>
        </div>
    </div>
</div>

{{-- Add New Category Modal --}}
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    
    {{-- Modal Content --}}
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="if(event.target === this) closeModal()">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="modalContainer">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Add New Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Fill in the details to create a new category.</p>
                </div>
                <button onclick="closeModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="#" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Category Name</label>
                    <input type="text" placeholder="e.g. Technology" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Type</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option value="post">Post</option>
                                <option value="page">Page</option>
                                <option value="gallery">Gallery</option>
                                <option value="video">Video</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option>Active</option>
                                <option>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Description</label>
                    <textarea rows="3" placeholder="Short description about this category..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none resize-none"></textarea>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal()" class="flex-1 px-5 py-3 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none text-sm">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Add New Sub Category Modal --}}
<div id="addSubCategoryModal" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeSubModal()"></div>
    
    {{-- Modal Content --}}
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="if(event.target === this) closeSubModal()">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="subModalContainer">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Add New Sub Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Select a parent category and add a sub-item.</p>
                </div>
                <button onclick="closeSubModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="#" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Parent Category</label>
                    <div class="relative">
                        <select required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                            <option value="" disabled selected>Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Sub Category Name</label>
                    <input type="text" placeholder="e.g. AI & Robotics" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                    <div class="relative">
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeSubModal()" class="flex-1 px-5 py-3 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none text-sm">
                        Save Sub Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Category Modal --}}
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="if(event.target === this) closeEditModal()">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="editModalContainer">
            <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Edit Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Modify the details of this category.</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="#" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Category Name</label>
                    <input type="text" value="National" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Type</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option value="post" selected>Post</option>
                                <option value="page">Page</option>
                                <option value="gallery">Gallery</option>
                                <option value="video">Video</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                        <div class="relative">
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option selected>Active</option>
                                <option>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Description</label>
                    <textarea rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none resize-none">Breaking news from across the nation.</textarea>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-5 py-3 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none text-sm">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId, containerId, action) {
        const modal = document.getElementById(modalId);
        const container = document.getElementById(containerId);
        if (action === 'open') {
            modal.classList.remove('hidden');
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            container.classList.remove('scale-100', 'opacity-100');
            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    function openModal() { toggleModal('addCategoryModal', 'modalContainer', 'open'); }
    function closeModal() { toggleModal('addCategoryModal', 'modalContainer', 'close'); }

    function openSubModal() { toggleModal('addSubCategoryModal', 'subModalContainer', 'open'); }
    function closeSubModal() { toggleModal('addSubCategoryModal', 'subModalContainer', 'close'); }

    function openEditModal() { toggleModal('editCategoryModal', 'editModalContainer', 'open'); }
    function closeEditModal() { toggleModal('editCategoryModal', 'editModalContainer', 'close'); }
</script>
@endsection
