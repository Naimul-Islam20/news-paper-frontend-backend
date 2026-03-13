@extends('admin.layout')

@section('title', 'Home Layout Settings')
@section('header_title', 'Home Layout')
@section('header_subtitle', 'Hero section এর layer গুলো')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm p-6 space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
            <div class="lg:col-span-3">
                <div id="hero-layer-4" class="h-24 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center px-3 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="hero-layer-label">4th Layer</span>
                    <button
                        type="button"
                        class="hero-layer-edit mt-2 inline-flex items-center justify-center w-7 h-7 px-3 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-layer-id="hero-layer-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="lg:col-span-6 space-y-3">
                <div id="hero-layer-1" class="h-16 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center px-3 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="hero-layer-label">1st Layer</span>
                    <button
                        type="button"
                        class="hero-layer-edit mt-1 inline-flex items-center justify-center w-7 h-7 px-3 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-layer-id="hero-layer-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
                <div id="hero-layer-2" class="h-16 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center px-3 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="hero-layer-label">2nd Layer</span>
                    <button
                        type="button"
                        class="hero-layer-edit mt-1 inline-flex items-center justify-center w-7 h-7 px-3 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-layer-id="hero-layer-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
                <div id="hero-layer-3" class="h-16 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center px-3 text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="hero-layer-label">3rd Layer</span>
                    <button
                        type="button"
                        class="hero-layer-edit mt-1 inline-flex items-center justify-center w-7 h-7 px-3 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-layer-id="hero-layer-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9-488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="lg:col-span-3 flex justify-center items-center">
                <div class="h-24 w-full lg:w-3/4 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    Mini Section
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3">
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                রাজনীতি
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                জাতীয়
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                রাজধানী
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                খেলা
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                সারাদেশ
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                বিশ্ব সংবাদ
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                বিনোদন
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

            <!-- First Column -->
            <div class="grid grid-rows-2 gap-4">
                <div id="section-lifestyle" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">লাইফস্টাইল</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-lifestyle">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>

                <div id="section-tech" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">টেক</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-tech">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Middle Column -->
            <div class="grid grid-rows-2 gap-4">
                <div id="section-different-eye" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">ভিন্নচোখে</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-different-eye">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>

                <div id="section-generation" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">প্রজন্ম</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-generation">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Last Column -->
            <div class="grid grid-rows-2 gap-4">
                <div id="section-campus" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">ক্যাম্পাস</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-campus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>

                <div id="section-job" class="h-20 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex flex-col items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                    <span class="section-label">চাকরি</span>
                    <button
                        type="button"
                        class="section-config-edit mt-1 inline-flex items-center justify-center w-7 h-7 rounded-full border border-slate-300 dark:border-slate-700 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800"
                        data-section-id="section-job">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 3.487l3.651 3.651M4.5 19.5l4.223-.469a2 2 0 001.15-.566l9.488-9.488a1.5 1.5 0 000-2.121L16.4 3.05a1.5 1.5 0 00-2.121 0L4.79 12.54a2 2 0 00-.566 1.15L3.75 17.914A1 1 0 004.5 19.5z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
        <div class="grid grid-cols-3 gap-3">

            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                ভিডিও
            </div>
            <div class="h-14 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center text-xs font-semibold text-slate-600 dark:text-slate-300">
                ছবি
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const layerOptions = [{
                value: '1st_layer',
                label: '1st Layer'
            },
            {
                value: '2nd_layer',
                label: '2nd Layer'
            },
            {
                value: '3rd_layer',
                label: '3rd Layer'
            },
            {
                value: '4th_layer',
                label: '4th Layer'
            },
        ];

        const boxes = ['hero-layer-1', 'hero-layer-2', 'hero-layer-3', 'hero-layer-4'];
        const state = {};

        // Initialize state from DOM
        boxes.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            const labelEl = el.querySelector('.hero-layer-label');
            if (!labelEl) return;
            const text = labelEl.textContent.trim();
            const found = layerOptions.find(o => o.label === text);
            state[id] = found ? found.value : null;
        });

        let activeBoxId = null;

        // Create modal once
        const modal = document.createElement('div');
        modal.id = 'hero-layer-modal';
        modal.className = 'fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/40 backdrop-blur';
        modal.innerHTML = `
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 w-full max-w-md p-5 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Hero Layer নির্বাচন করুন</h2>
                <button type="button" id="hero-layer-modal-close" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="hero-layer-modal-options" class="space-y-2 text-xs text-slate-700 dark:text-slate-200"></div>
            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" id="hero-layer-modal-cancel" class="px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    Cancel
                </button>
                <button type="button" id="hero-layer-modal-save" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700">
                    Save
                </button>
            </div>
        </div>
    `;
        document.body.appendChild(modal);

        const optionsContainer = modal.querySelector('#hero-layer-modal-options');

        function renderOptions(selectedValue) {
            optionsContainer.innerHTML = '';
            layerOptions.forEach(opt => {
                const wrapper = document.createElement('label');
                wrapper.className = 'flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer';
                wrapper.innerHTML = `
                <input type="radio" name="hero-layer-choice" value="${opt.value}" class="w-3.5 h-3.5" ${opt.value === selectedValue ? 'checked' : ''} />
                <span>${opt.label}</span>
            `;
                optionsContainer.appendChild(wrapper);
            });
        }

        function openModal(boxId) {
            activeBoxId = boxId;
            const current = state[boxId] || '1st_layer';
            renderOptions(current);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            activeBoxId = null;
        }

        // Attach edit button listeners
        document.querySelectorAll('.hero-layer-edit').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-layer-id');
                if (!id) return;
                openModal(id);
            });
        });

        modal.querySelector('#hero-layer-modal-close').addEventListener('click', closeModal);
        modal.querySelector('#hero-layer-modal-cancel').addEventListener('click', closeModal);

        modal.querySelector('#hero-layer-modal-save').addEventListener('click', () => {
            if (!activeBoxId) return;
            const selectedInput = modal.querySelector('input[name="hero-layer-choice"]:checked');
            if (!selectedInput) return;

            const newValue = selectedInput.value;
            const oldValue = state[activeBoxId];

            // If selecting one of the fixed 4 layers, ensure uniqueness by swapping
            const isLayerValue = ['1st_layer', '2nd_layer', '3rd_layer', '4th_layer'].includes(newValue);
            if (isLayerValue) {
                for (const otherId of boxes) {
                    if (otherId === activeBoxId) continue;
                    if (state[otherId] === newValue) {
                        // swap labels
                        state[otherId] = oldValue;
                        const otherEl = document.getElementById(otherId);
                        const otherLabel = otherEl ? otherEl.querySelector('.hero-layer-label') : null;
                        const oldOpt = layerOptions.find(o => o.value === oldValue);
                        if (otherLabel && oldOpt) {
                            otherLabel.textContent = oldOpt.label;
                        }
                        break;
                    }
                }
            }

            state[activeBoxId] = newValue;
            const activeEl = document.getElementById(activeBoxId);
            const activeLabel = activeEl ? activeEl.querySelector('.hero-layer-label') : null;
            const selectedOpt = layerOptions.find(o => o.value === newValue);
            if (activeLabel && selectedOpt) {
                activeLabel.textContent = selectedOpt.label;
            }

            closeModal();
        });
    });
</script>
@endpush