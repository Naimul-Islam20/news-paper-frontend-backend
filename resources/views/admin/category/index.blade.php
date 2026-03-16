@extends('admin.layout')

@section('title', 'Category Management')
@section('header_title', 'Category Management')

@section('content')
<div class="py-1 w-full mx-auto">

    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-end gap-3 mb-6">
        <button onclick="openModal('addCategoryModal', 'modalContainer')" class="flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-normal text-sm transition-all shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add Category
        </button>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-16 text-center">#</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Category Name</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Type</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Description</th>

                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-28">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-28">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($categories as $category)
                    {{-- Parent Row --}}
                    <tr class="border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="py-3 px-4 text-center">
                            <span class="text-xs font-normal text-black dark:text-white">{{ $category->id }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 shrink-0"></span>
                                <span class="text-sm font-normal text-black dark:text-white">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                {{ $category->type ?? 'general' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 max-w-xs">
                            <span class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">
                                {{ $category->description ?? '—' }}
                            </span>
                        </td>

                        <td class="py-3 px-4">
                            @if($category->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors category-edit-btn"
                                    title="Edit"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    data-type="{{ $category->type ?? 'post' }}"
                                    data-description="{{ $category->description ?? '' }}"
                                    data-status="{{ $category->status }}"
                                    data-slug="{{ $category->slug }}"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category and all its sub categories?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>



                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-slate-400 dark:text-slate-500 text-sm">No categories found. Add your first category.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- ADD CATEGORY MODAL --}}
{{-- ============================================================ --}}
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('addCategoryModal', 'modalContainer')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="modalContainer">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Add New Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Create a new top-level category.</p>
                </div>
                <button onclick="closeModal('addCategoryModal', 'modalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="addCategoryName" required placeholder="e.g. National" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Slug</label>
                    <input type="text" name="slug" id="addCategorySlug" placeholder="auto-generated from name if left empty" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-xs focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-500 dark:text-slate-400">
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Category Type <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="type" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none cursor-pointer text-slate-900 dark:text-white">
                            @foreach($categoryTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Description</label>
                    <textarea name="description" rows="3" placeholder="Short description of this category" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none cursor-pointer text-slate-900 dark:text-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('addCategoryModal', 'modalContainer')" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- ============================================================ --}}
{{-- EDIT MODAL --}}
{{-- ============================================================ --}}
<div id="editCategoryModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('editCategoryModal', 'editModalContainer')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="editModalContainer">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Edit Category</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Modify the details of this category.</p>
                </div>
                <button onclick="closeModal('editCategoryModal', 'editModalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editCategoryForm" action="" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="editCategoryName" required class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Slug</label>
                    <input type="text" name="slug" id="editCategorySlug" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-xs focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-500 dark:text-slate-400">
                </div>
                <div id="editCategoryTypeBlock">
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Category Type <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <select name="type" id="editCategoryType" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none cursor-pointer text-slate-900 dark:text-white">
                            @foreach($categoryTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Status</label>
                    <div class="relative">
                        <select name="status" id="editCategoryStatus" class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none appearance-none cursor-pointer text-slate-900 dark:text-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('editCategoryModal', 'editModalContainer')" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalId, containerId) {
        const modal = document.getElementById(modalId);
        const container = document.getElementById(containerId);
        modal.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(modalId, containerId) {
        const modal = document.getElementById(modalId);
        const container = document.getElementById(containerId);
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { modal.classList.add('hidden'); }, 300);
    }

    function openEditModal(id, name, type, description, status, isSubCategory = false, slug = '') {
        document.getElementById('editCategoryName').value = name;
        document.getElementById('editCategoryType').value = type;
        document.getElementById('editCategoryDescription').value = description;
        document.getElementById('editCategoryStatus').value = status;
        document.getElementById('editCategorySlug').value = slug || '';
        document.getElementById('editCategoryForm').action = '/admin/categories/' + id;
        
        // Hide type selector if it's a sub category (inherits from parent)
        const typeBlock = document.getElementById('editCategoryTypeBlock');
        const typeSelect = document.getElementById('editCategoryType');
        if (isSubCategory) {
            typeBlock.style.display = 'none';
            typeSelect.removeAttribute('required');
        } else {
            typeBlock.style.display = 'block';
            typeSelect.setAttribute('required', 'required');
        }

        openModal('editCategoryModal', 'editModalContainer');
    }

    // Simple slugify helper (Unicode-friendly: keeps Bangla chars)
    function slugify(str) {
        return str
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    // Auto-generate slug on create modal
    (function () {
        const nameInput = document.getElementById('addCategoryName');
        const slugInput = document.getElementById('addCategorySlug');
        if (!nameInput || !slugInput) return;

        let slugManuallyChanged = false;
        slugInput.addEventListener('input', function () {
            slugManuallyChanged = this.value.length > 0;
        });

        nameInput.addEventListener('input', function () {
            if (!slugManuallyChanged || slugInput.value.length === 0) {
                slugInput.value = slugify(nameInput.value);
            }
        });
    })();

    // Attach click handlers to edit buttons (using data-* attributes)
    (function () {
        const buttons = document.querySelectorAll('.category-edit-btn');
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name || '';
                const type = this.dataset.type || 'post';
                const description = this.dataset.description || '';
                const status = this.dataset.status || 'active';
                const slug = this.dataset.slug || '';
                openEditModal(id, name, type, description, status, false, slug);
            });
        });
    })();
</script>



@endsection
