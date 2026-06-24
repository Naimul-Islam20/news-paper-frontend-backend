@extends('admin.layout')

@section('title', 'Reporter')
@section('header_title', 'Reporter')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex flex-wrap items-center gap-3 sm:gap-4 justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-6 sm:mb-8">
            <form method="GET" action="{{ route('admin.reporters.index') }}" class="relative w-full min-w-0 max-w-full sm:max-w-sm flex items-center">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search reporter (SL, desk)..."
                    class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
            <button type="button" onclick="openModal('addReporterModal', 'addReporterModalContainer')" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-sm text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Reporter
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider w-16 text-center">SL</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">ডেস্ক/ধরন</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider">Created By</th>
                        <th class="py-1 px-2 text-[11px] font-normal text-black dark:text-white uppercase tracking-wider text-right w-24">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($reporters as $reporter)
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-1 px-2 text-center">
                            <span class="text-sm font-normal text-black dark:text-white">
                                {{ $reporters->firstItem() + $loop->index }}
                            </span>
                        </td>
                        <td class="py-1 px-2">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $reporter->desk ?: $reporter->name }}</div>
                        </td>
                        <td class="py-1 px-2">
                            <span class="text-xs font-normal text-black dark:text-white">{{ $reporter->creator->name ?? 'System' }}</span>
                        </td>
                        <td class="py-1 px-2 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button
                                    type="button"
                                    class="p-1 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors reporter-edit-btn"
                                    title="Edit"
                                    data-id="{{ $reporter->id }}"
                                    data-desk="{{ $reporter->desk ?: $reporter->name }}"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.reporters.destroy', $reporter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this reporter?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 dark:text-slate-400">No reporters found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-6 border-t border-slate-100 dark:border-slate-800 mt-6 flex items-center justify-between">
            <span class="text-xs text-black dark:text-white font-normal">
                Showing {{ $reporters->firstItem() ?? 0 }} to {{ $reporters->lastItem() ?? 0 }} of {{ $reporters->total() }} entries
            </span>
            <div class="flex items-center gap-2">
                {{ $reporters->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<x-admin.modal-scripts />

{{-- ADD REPORTER MODAL --}}
<div id="addReporterModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('addReporterModal', 'addReporterModalContainer')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="modalBackdropClose(event, 'addReporterModal', 'addReporterModalContainer')">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="addReporterModalContainer">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Add Reporter</h3>
                </div>
                <button type="button" onclick="closeModal('addReporterModal', 'addReporterModalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('admin.reporters.store') }}" method="POST" class="p-5 space-y-4">
                @csrf
                <input type="hidden" name="_form" value="add">
                @if($errors->any() && old('_form') === 'add')
                    <div class="p-3 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-sm">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Reporter ধরন / ডেস্ক <span class="text-rose-500">*</span></label>
                    <input type="text" name="desk" value="{{ old('_form') === 'add' ? old('desk') : '' }}" required placeholder="যেমন: ডিজিটাল ডেস্ক, সম্পাদকীয়, ডিজিটাল রিপোর্ট" class="w-full px-4 py-2.5 rounded-lg border @error('desk') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                    @error('desk')
                        @if(old('_form') === 'add')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @endif
                    @enderror
                </div>
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('addReporterModal', 'addReporterModalContainer')" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Save Reporter</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- EDIT REPORTER MODAL --}}
<div id="editReporterModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('editReporterModal', 'editReporterModalContainer')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="modalBackdropClose(event, 'editReporterModal', 'editReporterModalContainer')">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="editReporterModalContainer">
            <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Edit Reporter</h3>
                </div>
                <button type="button" onclick="closeModal('editReporterModal', 'editReporterModalContainer')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editReporterForm" action="" method="POST" class="p-5 space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form" value="edit">
                <input type="hidden" name="_reporter_id" id="editReporterId" value="{{ old('_form') === 'edit' ? old('_reporter_id') : '' }}">
                @if($errors->any() && old('_form') === 'edit')
                    <div class="p-3 rounded-xl bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-sm">
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-sm font-normal text-slate-700 dark:text-slate-300 mb-1.5">Reporter ধরন / ডেস্ক <span class="text-rose-500">*</span></label>
                    <input type="text" name="desk" id="editReporterDesk" required placeholder="যেমন: ডিজিটাল ডেস্ক, সম্পাদকীয়, ডিজিটাল রিপোর্ট" class="w-full px-4 py-2.5 rounded-lg border @error('desk') border-rose-500 @else border-slate-200 dark:border-slate-800 @enderror bg-white dark:bg-slate-950 text-sm focus:ring-1 focus:ring-indigo-500 transition-all outline-none text-slate-900 dark:text-white">
                    @error('desk')
                        @if(old('_form') === 'edit')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @endif
                    @enderror
                </div>
                <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('editReporterModal', 'editReporterModalContainer')" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-normal rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">Cancel</button>
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-lg transition-all shadow-md text-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openEditReporterModal(id, desk) {
        document.getElementById('editReporterId').value = id;
        document.getElementById('editReporterDesk').value = desk;
        document.getElementById('editReporterForm').action = '{{ url('/admin/reporters') }}/' + id;
        openModal('editReporterModal', 'editReporterModalContainer');
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.reporter-edit-btn');
        if (!btn) return;
        openEditReporterModal(btn.dataset.id, btn.dataset.desk || '');
    });

    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->any() && old('_form') === 'add')
            openModal('addReporterModal', 'addReporterModalContainer');
        @endif
        @if($errors->any() && old('_form') === 'edit')
            document.getElementById('editReporterDesk').value = @json(old('desk'));
            document.getElementById('editReporterForm').action = '{{ url('/admin/reporters') }}/' + @json(old('_reporter_id'));
            openModal('editReporterModal', 'editReporterModalContainer');
        @endif
    });
</script>
@endpush

@endsection
