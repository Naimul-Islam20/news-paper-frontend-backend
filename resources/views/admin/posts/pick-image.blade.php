@extends('admin.layout')

@section('title', 'মিডিয়া লাইব্রেরি')
@section('header_title', 'মিডিয়া লাইব্রেরি')

@section('content')
@php
    $cancelUrl = $context === 'edit'
        ? route('admin.posts.edit', $postId)
        : route('admin.posts.create');
@endphp

<style>
    .pick-image-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem;
    }
    @media (min-width: 768px) {
        .pick-image-grid {
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 1rem;
        }
    }
    .pick-image-item {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 0.5rem;
        border: 3px solid transparent;
        cursor: pointer;
        background: #f1f5f9;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .dark .pick-image-item {
        background: #1e293b;
    }
    .pick-image-item:hover {
        border-color: #a5b4fc;
    }
    .pick-image-item.is-selected {
        border-color: #4f46e5;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.35);
    }
    .pick-image-item img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pick-image-item .pick-image-check {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(79, 70, 229, 0);
        pointer-events: none;
        transition: background 0.15s ease;
    }
    .pick-image-item.is-selected .pick-image-check {
        background: rgba(79, 70, 229, 0.28);
    }
    .pick-image-item .pick-image-check span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        border-radius: 9999px;
        background: #4f46e5;
        color: #fff;
        transform: scale(0);
        transition: transform 0.15s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    .pick-image-item.is-selected .pick-image-check span {
        transform: scale(1);
    }
    .pick-image-close {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.5rem;
        color: #dc2626;
        background: #fef2f2;
        border: 1px solid #fecaca;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
    }
    .pick-image-close:hover {
        color: #b91c1c;
        background: #fee2e2;
        border-color: #fca5a5;
    }
    .dark .pick-image-close {
        color: #f87171;
        background: rgba(127, 29, 29, 0.35);
        border-color: rgba(248, 113, 113, 0.35);
    }
    .dark .pick-image-close:hover {
        color: #fca5a5;
        background: rgba(127, 29, 29, 0.55);
        border-color: rgba(248, 113, 113, 0.5);
    }
</style>

<div class="py-1 w-full">
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="flex flex-wrap items-center justify-end border-b border-slate-100 dark:border-slate-800 px-4 py-3 sm:px-6">
            <a href="{{ $cancelUrl }}" class="pick-image-close" aria-label="ফিরে যান" title="ফিরে যান">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        @if($errors->has('existing_image'))
            <div class="mx-4 mt-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 sm:mx-6 dark:border-rose-800 dark:bg-rose-950/50 dark:text-rose-300">
                {{ $errors->first('existing_image') }}
            </div>
        @endif

        <div class="border-b border-slate-100 dark:border-slate-800 px-4 py-4 sm:px-6">
            <form method="GET" action="{{ route('admin.posts.pick-image') }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="context" value="{{ $context }}">
                @if($context === 'edit')
                    <input type="hidden" name="post_id" value="{{ $postId }}">
                @endif
                <div class="relative min-w-0 flex-1 sm:max-w-md">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="পোস্ট শিরোনাম দিয়ে খুঁজুন..."
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-10 pr-4 text-sm outline-none focus:ring-1 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button type="submit" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200">
                    খুঁজুন
                </button>
            </form>
        </div>

        <form method="POST" action="{{ route('admin.posts.pick-image.apply') }}" id="pick-image-form">
            @csrf
            <input type="hidden" name="context" value="{{ $context }}">
            @if($context === 'edit')
                <input type="hidden" name="post_id" value="{{ $postId }}">
            @endif
            <input type="hidden" name="existing_image" id="picked-image-path" value="">

            <div class="px-4 py-4 sm:px-6 sm:py-6">
                @if($images->isEmpty())
                    <p class="py-16 text-center text-sm text-slate-500 dark:text-slate-400">কোনো ছবি পাওয়া যায়নি।</p>
                @else
                    <div class="pick-image-grid" id="pick-image-grid">
                        @foreach($images as $row)
                            <div
                                class="pick-image-item"
                                role="button"
                                tabindex="0"
                                data-path="{{ $row->image }}"
                                title="{{ $row->sample_title }}"
                                aria-pressed="false">
                                <img src="{{ storage_image_url($row->image) }}" alt="" loading="lazy">
                                <span class="pick-image-check" aria-hidden="true">
                                    <span>
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    </div>

                    @if($images->total() > $images->perPage())
                        <div class="mt-6">
                            {{ $images->links('pagination::tailwind') }}
                        </div>
                    @endif
                @endif
            </div>

            <div class="sticky bottom-0 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 bg-white/95 px-4 py-3 backdrop-blur dark:border-slate-800 dark:bg-slate-900/95 sm:px-6">
                <p id="pick-image-status" class="text-sm text-slate-500 dark:text-slate-400">কোনো ছবি নির্বাচন করা হয়নি</p>
                <div class="flex items-center gap-2">
                    <a href="{{ $cancelUrl }}" class="inline-flex h-10 items-center justify-center rounded-lg border border-slate-200 px-5 text-sm font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                        বাতিল
                    </a>
                    <button
                        type="submit"
                        id="pick-image-submit"
                        disabled
                        class="inline-flex h-10 items-center justify-center rounded-lg bg-indigo-600 px-6 text-sm font-medium text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50">
                        ব্যবহার করুন
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
(function () {
    const form = document.getElementById('pick-image-form');
    const grid = document.getElementById('pick-image-grid');
    const hidden = document.getElementById('picked-image-path');
    const submitBtn = document.getElementById('pick-image-submit');
    const statusEl = document.getElementById('pick-image-status');

    if (!form || !grid || !hidden || !submitBtn) {
        return;
    }

    function selectItem(item) {
        grid.querySelectorAll('.pick-image-item').forEach(function (other) {
            other.classList.remove('is-selected');
            other.setAttribute('aria-pressed', 'false');
        });

        item.classList.add('is-selected');
        item.setAttribute('aria-pressed', 'true');
        hidden.value = item.getAttribute('data-path') || '';
        submitBtn.disabled = hidden.value === '';

        if (statusEl) {
            statusEl.textContent = hidden.value
                ? '১টি ছবি নির্বাচিত'
                : 'কোনো ছবি নির্বাচন করা হয়নি';
        }
    }

    grid.addEventListener('click', function (event) {
        const item = event.target.closest('.pick-image-item');
        if (!item || !grid.contains(item)) {
            return;
        }
        event.preventDefault();
        selectItem(item);
    });

    grid.addEventListener('keydown', function (event) {
        if (event.key !== 'Enter' && event.key !== ' ') {
            return;
        }
        const item = event.target.closest('.pick-image-item');
        if (!item || !grid.contains(item)) {
            return;
        }
        event.preventDefault();
        selectItem(item);
    });

    form.addEventListener('submit', function (event) {
        if (!hidden.value) {
            event.preventDefault();
            if (statusEl) {
                statusEl.textContent = 'আগে একটি ছবি নির্বাচন করুন';
            }
        }
    });
})();
</script>
@endsection
