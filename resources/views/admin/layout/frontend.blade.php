@extends('admin.layout')

@section('title', 'Frontend Layout Settings')
@section('header_title', 'Frontend Layout')
@section('header_subtitle', 'Header ও Footer এ কোন category দেখাবে তা এখান থেকে নির্বাচন করুন')

@section('content')
<div class="max-w-5xl mx-auto">

    <form method="POST" action="{{ route('admin.layout.frontend.save') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- ===== HEADER CATEGORIES ===== --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-indigo-50 to-slate-50 dark:from-indigo-900/20 dark:to-slate-900">
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h8"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 dark:text-slate-200">Header Navigation</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Navbar এ যে category গুলো দেখাবে</p>
                    </div>
                    <span id="header-count" class="ml-auto text-xs font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/40 px-2 py-1 rounded-full">
                        {{ count($headerCategoryIds) }} selected
                    </span>
                </div>

                <div class="p-4 space-y-1 max-h-[500px] overflow-y-auto custom-scrollbar">
                    @forelse($categories as $category)
                    <label class="flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer transition-all hover:bg-indigo-50 dark:hover:bg-indigo-900/20 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-800 {{ in_array($category->id, $headerCategoryIds) ? 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-100 dark:border-indigo-800' : '' }}">
                        <input
                            type="checkbox"
                            name="header_categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $headerCategoryIds) ? 'checked' : '' }}
                            onchange="updateCount('header')"
                            class="w-4 h-4 rounded accent-indigo-600 cursor-pointer">
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex-1">
                            {{ $category->name }}
                        </span>
                        @if($category->type)
                        <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">
                            {{ $category->type }}
                        </span>
                        @endif
                    </label>
                    @empty
                    <p class="text-sm text-slate-400 text-center py-8">কোনো category পাওয়া যায়নি।</p>
                    @endforelse
                </div>

                <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between">
                    <button type="button" onclick="toggleAll('header_categories[]', true, 'header')"
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                        সব select করুন
                    </button>
                    <button type="button" onclick="toggleAll('header_categories[]', false, 'header')"
                        class="text-xs font-medium text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        সব বাদ দিন
                    </button>
                </div>
            </div>

            {{-- ===== FOOTER CATEGORIES ===== --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-violet-50 to-slate-50 dark:from-violet-900/20 dark:to-slate-900">
                    <div class="w-9 h-9 rounded-xl bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 14h16M4 18h8"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 dark:text-slate-200">Footer Navigation</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Footer এ যে category গুলো দেখাবে</p>
                    </div>
                    <span id="footer-count" class="ml-auto text-xs font-bold text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/40 px-2 py-1 rounded-full">
                        {{ count($footerCategoryIds) }} selected
                    </span>
                </div>

                <div class="p-4 space-y-1 max-h-[500px] overflow-y-auto custom-scrollbar">
                    @forelse($categories as $category)
                    <label class="flex items-center gap-3 px-4 py-2.5 rounded-xl cursor-pointer transition-all hover:bg-violet-50 dark:hover:bg-violet-900/20 border border-transparent hover:border-violet-100 dark:hover:border-violet-800 {{ in_array($category->id, $footerCategoryIds) ? 'bg-violet-50 dark:bg-violet-900/20 border-violet-100 dark:border-violet-800' : '' }}">
                        <input
                            type="checkbox"
                            name="footer_categories[]"
                            value="{{ $category->id }}"
                            {{ in_array($category->id, $footerCategoryIds) ? 'checked' : '' }}
                            onchange="updateCount('footer')"
                            class="w-4 h-4 rounded accent-violet-600 cursor-pointer">
                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex-1">
                            {{ $category->name }}
                        </span>
                        @if($category->type)
                        <span class="text-[10px] font-bold uppercase tracking-wide text-slate-400 bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded">
                            {{ $category->type }}
                        </span>
                        @endif
                    </label>
                    @empty
                    <p class="text-sm text-slate-400 text-center py-8">কোনো category পাওয়া যায়নি।</p>
                    @endforelse
                </div>

                <div class="px-5 py-3 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-between">
                    <button type="button" onclick="toggleAll('footer_categories[]', true, 'footer')"
                        class="text-xs font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400">
                        সব select করুন
                    </button>
                    <button type="button" onclick="toggleAll('footer_categories[]', false, 'footer')"
                        class="text-xs font-medium text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                        সব বাদ দিন
                    </button>
                </div>
            </div>

        </div>

        {{-- Save Button --}}
        <div class="mt-6 flex items-center justify-end gap-4">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all dark:bg-slate-900 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-800">
                বাতিল করুন
            </a>
            <button type="submit" class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                সংরক্ষণ করুন
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
// Update selected count badge
function updateCount(section) {
    const checked = document.querySelectorAll('input[name="' + section + '_categories[]"]:checked').length;
    const el = document.getElementById(section + '-count');
    if (el) el.textContent = checked + ' selected';
}

// Select/deselect all (skip disabled ones)
function toggleAll(name, check, section) {
    document.querySelectorAll('input[name="' + name + '"]:not(:disabled)').forEach(cb => cb.checked = check);
    updateCount(section);
}

// When header checkbox changes → sync footer and vice versa
function syncOpposite(changedInput, section) {
    const catId = changedInput.value;
    const isChecked = changedInput.checked;
    const oppositeSection = section === 'header' ? 'footer' : 'header';

    const oppositeInput = document.querySelector(
        'input[name="' + oppositeSection + '_categories[]"][value="' + catId + '"]'
    );

    if (!oppositeInput) return;

    if (isChecked) {
        // Disable & uncheck the opposite
        oppositeInput.checked = false;
        oppositeInput.disabled = true;
        oppositeInput.closest('label').classList.add('opacity-40', 'cursor-not-allowed');
        oppositeInput.closest('label').classList.remove('cursor-pointer');
    } else {
        // Re-enable the opposite
        oppositeInput.disabled = false;
        oppositeInput.closest('label').classList.remove('opacity-40', 'cursor-not-allowed');
        oppositeInput.closest('label').classList.add('cursor-pointer');
    }

    updateCount(section);
    updateCount(oppositeSection);
}

document.addEventListener('DOMContentLoaded', function () {
    // Attach change listeners to ALL category checkboxes
    document.querySelectorAll('input[name="header_categories[]"]').forEach(cb => {
        cb.addEventListener('change', () => syncOpposite(cb, 'header'));
    });
    document.querySelectorAll('input[name="footer_categories[]"]').forEach(cb => {
        cb.addEventListener('change', () => syncOpposite(cb, 'footer'));
    });

    // On page load: disable already-conflicting checkboxes
    document.querySelectorAll('input[name="header_categories[]"]:checked').forEach(cb => {
        syncOpposite(cb, 'header');
    });
    document.querySelectorAll('input[name="footer_categories[]"]:checked').forEach(cb => {
        syncOpposite(cb, 'footer');
    });

    updateCount('header');
    updateCount('footer');
});
</script>
@endpush
@endsection
