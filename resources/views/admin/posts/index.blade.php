@extends('admin.layout')

@section('title', 'All Posts')
@section('header_title', 'All Posts')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        {{-- Header Actions --}}
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-6 sm:mb-8">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center gap-2 sm:gap-3">
                <div class="relative w-48 sm:w-72 lg:w-96">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search posts..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <div class="flex items-stretch gap-2">
                    <div class="w-28 sm:w-40">
                        <select
                            name="category_id"
                            class="w-full pl-3 pr-8 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-xs sm:text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-700 dark:text-slate-200"
                        >
                            <option value="all">{{ __('All Categories') }}</option>
                            @isset($categories)
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="w-28 sm:w-32">
                        <select
                            name="status"
                            class="w-full pl-3 pr-8 py-2 rounded-lg border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 text-xs sm:text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-700 dark:text-slate-200"
                        >
                            <option value="all">All Status</option>
                            <option value="published" @selected(request('status') === 'published')>Published</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        class="px-3 sm:px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs sm:text-sm font-normal rounded-lg border border-slate-200 dark:border-slate-800 transition-all shadow-sm"
                    >
                        Filter
                    </button>
                </div>
            </form>
            <div class="flex items-center gap-2 shrink-0">
                @if(auth()->user()->canFeature('posts.manage'))
                <button
                    type="button"
                    id="enter-selection-btn"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-normal rounded-lg transition-all border border-slate-200 dark:border-slate-700 text-sm flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Select
                </button>
                <button
                    type="button"
                    id="cancel-selection-btn"
                    class="hidden px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-normal rounded-lg transition-all border border-slate-200 dark:border-slate-700 text-sm"
                >
                    Cancel
                </button>
                @endif
                <a href="{{ route('admin.posts.create') }}" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New Post
                </a>
            </div>
        </div>

        @if(auth()->user()->canFeature('posts.manage'))
        <div id="bulk-delete-row" class="hidden -mt-4 mb-6 sm:mb-8 flex justify-end">
            <button
                type="submit"
                form="bulk-delete-form"
                id="bulk-delete-btn"
                disabled
                class="px-4 py-2 bg-rose-600 hover:bg-rose-700 disabled:opacity-40 disabled:cursor-not-allowed text-white font-normal rounded-lg transition-all shadow-md text-sm flex items-center gap-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                <span>Delete (<span id="bulk-selected-count">0</span>)</span>
            </button>
        </div>
        @endif

        @if(session('success'))
            <div class="mb-4 px-4 py-2.5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 rounded-lg text-sm text-emerald-700 dark:text-emerald-400 font-normal">
                {{ session('success') }}
            </div>
        @endif

        @if(auth()->user()->canFeature('posts.manage'))
        <form id="bulk-delete-form" method="POST" action="{{ route('admin.posts.store') }}" class="hidden">
            @csrf
            <input type="hidden" name="bulk_delete" value="1">
        </form>
        @endif

        {{-- Table --}}
        <div id="posts-table-wrap" class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        @if(auth()->user()->canFeature('posts.manage'))
                        <th class="bulk-select-col hidden py-3 px-3 text-xs font-semibold text-slate-900 dark:text-slate-100 w-12 text-center">
                            <input type="checkbox" id="select-all-posts" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" title="Select all on this page" aria-label="Select all posts on this page">
                        </th>
                        @endif
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-16 text-center">SL</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Title</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-24 text-center">Image</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Categories</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-32">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 w-36">Date/Time</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100">Reporter</th>
                        <th class="post-action-col py-3 px-4 text-xs font-semibold text-slate-900 dark:text-slate-100 text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($posts as $post)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors divide-x divide-slate-200 dark:divide-slate-700">
                        @if(auth()->user()->canFeature('posts.manage'))
                        <td class="bulk-select-col hidden py-3 px-3 text-center">
                            <input type="checkbox" value="{{ $post->id }}" class="post-row-checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" aria-label="Select post: {{ $post->title }}">
                        </td>
                        @endif
                        <td class="py-3 px-4 text-center">
                            <span class="text-xs font-normal text-slate-500">
                                {{ $posts->firstItem() + $loop->index }}
                            </span>
                        </td>
                        <td class="py-3 px-4 min-w-[200px]">
                            <div class="text-sm font-normal text-slate-900 dark:text-slate-100 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $post->title }}
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="h-10 w-16 mx-auto rounded border border-slate-200 dark:border-slate-700 overflow-hidden bg-slate-50 flex items-center justify-center">
                                @if($post->image)
                                    <img src="{{ storage_image_url($post->image) }}" class="h-full w-full object-cover">
                                @else
                                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($post->categories as $cat)
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-[10px] font-normal text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                        {{ $cat->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if($post->status == 'published')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Published
                                </span>
                            @elseif($post->status == 'draft')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-slate-50 text-slate-600 dark:bg-slate-500/10 dark:text-slate-400 border border-slate-100 dark:border-slate-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-normal bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-xs font-normal text-slate-600 dark:text-slate-400">{{ $post->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] text-slate-400">{{ $post->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-xs font-normal text-slate-600 dark:text-slate-300">{{ reporter_display_label($post->reporter, 'N/A') }}</span>
                        </td>
                        <td class="py-3 px-4 text-right post-action-col">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                @if(auth()->user()->canFeature('posts.manage'))
                                <button type="submit" form="delete-post-{{ $post->id }}" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete" onclick="return confirm('Are you sure you want to delete this post?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-slate-400 text-sm">No posts found. <a href="{{ route('admin.posts.create') }}" class="text-indigo-500 hover:underline">Create your first post.</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(auth()->user()->canFeature('posts.manage'))
            @foreach($posts as $post)
            <form id="delete-post-{{ $post->id }}" method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
            @endforeach
        @endif

        @if($posts->hasPages())
        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-4">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

@if(auth()->user()->canFeature('posts.manage'))
<script>
(function () {
    var STORAGE_MODE = 'admin_posts_selection_mode';
    var STORAGE_IDS = 'admin_posts_selected_ids';
    var tableWrap = document.getElementById('posts-table-wrap');
    var enterBtn = document.getElementById('enter-selection-btn');
    var cancelBtn = document.getElementById('cancel-selection-btn');
    var bulkDeleteRow = document.getElementById('bulk-delete-row');
    var selectAll = document.getElementById('select-all-posts');
    var bulkBtn = document.getElementById('bulk-delete-btn');
    var bulkForm = document.getElementById('bulk-delete-form');
    var countEl = document.getElementById('bulk-selected-count');
    var selectionActive = false;

    function rowCheckboxes() {
        return Array.prototype.slice.call(document.querySelectorAll('.post-row-checkbox'));
    }

    function getStoredIds() {
        try {
            var raw = sessionStorage.getItem(STORAGE_IDS);
            if (!raw) return [];
            var arr = JSON.parse(raw);
            if (!Array.isArray(arr)) return [];
            return arr.map(function (v) { return parseInt(v, 10); }).filter(function (n) { return n > 0; });
        } catch (e) {
            return [];
        }
    }

    function setStoredIds(ids) {
        var unique = [];
        ids.forEach(function (id) {
            id = parseInt(id, 10);
            if (id > 0 && unique.indexOf(id) === -1) unique.push(id);
        });
        sessionStorage.setItem(STORAGE_IDS, JSON.stringify(unique));
    }

    function persistSelectionMode(on) {
        if (on) {
            sessionStorage.setItem(STORAGE_MODE, '1');
        } else {
            sessionStorage.removeItem(STORAGE_MODE);
            sessionStorage.removeItem(STORAGE_IDS);
        }
    }

    function syncCheckboxToStorage(cb) {
        var id = parseInt(cb.value, 10);
        var ids = getStoredIds();
        if (cb.checked) {
            if (ids.indexOf(id) === -1) ids.push(id);
        } else {
            ids = ids.filter(function (x) { return x !== id; });
        }
        setStoredIds(ids);
    }

    function restoreCheckboxesFromStorage() {
        var ids = getStoredIds();
        rowCheckboxes().forEach(function (cb) {
            var id = parseInt(cb.value, 10);
            cb.checked = ids.indexOf(id) !== -1;
        });
    }

    function prepareBulkForm() {
        if (!bulkForm) return;
        bulkForm.querySelectorAll('input.bulk-hidden-id').forEach(function (el) { el.remove(); });
        getStoredIds().forEach(function (id) {
            var inp = document.createElement('input');
            inp.type = 'hidden';
            inp.name = 'ids[]';
            inp.value = String(id);
            inp.className = 'bulk-hidden-id';
            bulkForm.appendChild(inp);
        });
    }

    function setSelectionMode(on, skipPersist) {
        selectionActive = !!on;
        if (!skipPersist) persistSelectionMode(selectionActive);
        if (tableWrap) tableWrap.classList.toggle('posts-selection-mode', selectionActive);
        document.querySelectorAll('.bulk-select-col').forEach(function (el) {
            el.classList.toggle('hidden', !selectionActive);
        });
        document.querySelectorAll('.post-action-col').forEach(function (el) {
            el.classList.toggle('hidden', selectionActive);
        });
        if (enterBtn) enterBtn.classList.toggle('hidden', selectionActive);
        if (cancelBtn) cancelBtn.classList.toggle('hidden', !selectionActive);
        if (bulkDeleteRow) {
            bulkDeleteRow.classList.toggle('hidden', !selectionActive);
            bulkDeleteRow.classList.toggle('flex', selectionActive);
        }
        if (selectionActive) {
            restoreCheckboxesFromStorage();
        } else {
            rowCheckboxes().forEach(function (cb) { cb.checked = false; });
            if (selectAll) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            }
        }
        updateBulkState();
    }

    function updateBulkState() {
        var boxes = rowCheckboxes();
        var totalSelected = getStoredIds().length;
        var checkedOnPage = boxes.filter(function (cb) { return cb.checked; });
        if (countEl) countEl.textContent = String(totalSelected);
        if (bulkBtn) bulkBtn.disabled = totalSelected === 0;
        if (selectAll) {
            selectAll.indeterminate = checkedOnPage.length > 0 && checkedOnPage.length < boxes.length;
            selectAll.checked = boxes.length > 0 && checkedOnPage.length === boxes.length;
        }
    }

    if (enterBtn) {
        enterBtn.addEventListener('click', function () {
            setSelectionMode(true);
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            setSelectionMode(false);
        });
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            var ids = getStoredIds();
            rowCheckboxes().forEach(function (cb) {
                cb.checked = selectAll.checked;
                var id = parseInt(cb.value, 10);
                if (selectAll.checked) {
                    if (ids.indexOf(id) === -1) ids.push(id);
                } else {
                    ids = ids.filter(function (x) { return x !== id; });
                }
            });
            setStoredIds(ids);
            updateBulkState();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('post-row-checkbox')) {
            syncCheckboxToStorage(e.target);
            updateBulkState();
        }
    });

    if (bulkForm) {
        bulkForm.addEventListener('submit', function (e) {
            var count = getStoredIds().length;
            if (!count) {
                e.preventDefault();
                return;
            }
            var msg = count === 1
                ? 'Are you sure you want to delete 1 selected post?'
                : 'Are you sure you want to delete ' + count + ' selected posts?';
            if (!confirm(msg)) {
                e.preventDefault();
                return;
            }
            prepareBulkForm();
            persistSelectionMode(false);
        });
    }

    if (sessionStorage.getItem(STORAGE_MODE) === '1') {
        setSelectionMode(true, true);
    } else {
        setSelectionMode(false, true);
    }
})();
</script>
@endif
@endsection
