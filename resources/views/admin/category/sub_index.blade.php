@extends('admin.layout')

@section('header_title', 'Sub Category Management')

@section('content')
@php
    $counts = collect($subCategories)->groupBy('parent')->map->count();
@endphp
<div class="px-8 py-8">
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Sub Category List</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage and organize your news sub-categories.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openSubModal()" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-all shadow-lg shadow-indigo-200 dark:shadow-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Add New Sub Category
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
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Parent Category</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Type</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Description</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 text-center">Serial</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($subCategories as $sub)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors divide-x divide-slate-100 dark:divide-slate-800">
                        <td class="px-6 py-4 text-sm font-medium text-black">{{ $sub['id'] }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-black">{{ $sub['name'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-black">
                            <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-lg bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400">
                                {{ $sub['parent'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 text-[11px] font-semibold rounded-full bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                {{ $sub['type'] ?? 'general' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <span class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">
                                {{ $sub['description'] ?? '—' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-black">{{ $sub['serial'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="px-3 py-1.5 text-xs font-bold rounded-xl {{ $sub['status'] == 'Active' ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400' }}">
                                {{ $sub['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openEditSubModal({{ $sub['id'] }}, {{ $sub['parent_id'] }}, '{{ addslashes($sub['name']) }}', '{{ addslashes($sub['description'] ?? '') }}', '{{ $sub['rawStatus'] }}')" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-all" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $sub['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this sub category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Placeholder --}}
        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <p class="text-sm text-slate-500">Showing 1 to {{ count($subCategories) }} of {{ count($subCategories) }} results</p>
            <div class="flex items-center gap-2">
                <button class="px-3 py-1.5 text-xs font-bold text-slate-500 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg opacity-50 cursor-not-allowed">Previous</button>
                <button class="px-3 py-1.5 text-xs font-bold text-slate-500 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg opacity-50 cursor-not-allowed">Next</button>
            </div>
        </div>
    </div>
</div>

{{-- Sub Category Modal --}}
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
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Parent Category <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="parent_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                            <option value="" disabled selected>Select Parent Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" {{ old('parent_id') == $category['id'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Sub Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g. AI & Robotics" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Description</label>
                    <textarea name="description" rows="3" placeholder="Short description" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                        <div class="relative">
                            <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
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

{{-- Edit Sub Category Modal --}}
<div id="editSubCategoryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditSubModal()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="if(event.target === this) closeEditSubModal()">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="editSubModalContainer">
            <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Edit Sub Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Modify the details of this sub-category.</p>
                </div>
                <button onclick="closeEditSubModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editSubCategoryForm" action="" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Parent Category <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="parent_id" id="editSubParentId" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
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
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Sub Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="editSubName" required class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Description</label>
                    <textarea name="description" id="editSubDescription" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white"></textarea>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Status</label>
                        <div class="relative">
                            <select name="status" id="editSubStatus" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeEditSubModal()" class="flex-1 px-5 py-3 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none text-sm">Update Sub Category</button>
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

    function openSubModal() { toggleModal('addSubCategoryModal', 'subModalContainer', 'open'); }
    function closeSubModal() { toggleModal('addSubCategoryModal', 'subModalContainer', 'close'); }

    function openEditSubModal(id, parent_id, name, description, status) { 
        document.getElementById('editSubParentId').value = parent_id;
        document.getElementById('editSubName').value = name;
        document.getElementById('editSubDescription').value = description;
        document.getElementById('editSubStatus').value = status;
        document.getElementById('editSubCategoryForm').action = '/admin/categories/' + id;
        toggleModal('editSubCategoryModal', 'editSubModalContainer', 'open'); 
    }
    function closeEditSubModal() { toggleModal('editSubCategoryModal', 'editSubModalContainer', 'close'); }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            openSubModal();
        });
    @endif
</script>
@endsection
