@props([
    'modalId',
    'containerId',
    'maxWidth' => 'max-w-md',
])
<div id="{{ $modalId }}" {{ $attributes->class(['fixed inset-0 z-50 hidden']) }}>
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeModal('{{ $modalId }}', '{{ $containerId }}')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div
            class="bg-white dark:bg-slate-900 w-full {{ $maxWidth }} rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300 max-h-[90vh] flex flex-col"
            id="{{ $containerId }}"
        >
            @isset($header)
                {{ $header }}
            @endisset
            <div class="overflow-y-auto flex-1 min-h-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
