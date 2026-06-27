@props(['variant' => 'inline'])

@php
$menuLinkClass = 'font-normal hover:text-primary border-b-2 border-transparent hover:border-primary pb-1 transition-all';
$isMenuVariant = $variant === 'menu';
@endphp

@if($isMenuVariant)
<ul class="flex justify-start items-center gap-3 text-base whitespace-nowrap py-0.5 {{ $attributes->get('class') }}">
    <li>
        <a href="{{ route('bangla-converter') }}"
            class="{{ $menuLinkClass }} {{ request()->routeIs('bangla-converter') ? 'text-primary border-primary' : '' }}"
            title="Unicode to Bijoy - Bangla text Converter">
            <span class="i18n-bn">বাংলা কনভার্টার</span>
            <span class="i18n-en">Bangla Converter</span>
        </a>
    </li>
    <li>
        <a href="{{ route('archive') }}"
            class="{{ $menuLinkClass }} {{ request()->routeIs('archive') ? 'text-primary border-primary' : '' }}">
            <span class="i18n-bn">আর্কাইভ</span>
            <span class="i18n-en">Archive</span>
        </a>
    </li>
    <li>
        <x-language-switcher :class="$menuLinkClass" />
    </li>
</ul>
@elseif($variant === 'drawer')
<ul class="space-y-2 {{ $attributes->get('class') }}">
    <li class="border-b border-white/30 pb-1">
        <a href="{{ route('bangla-converter') }}"
            class="block text-2xl font-medium text-white hover:text-white/80 transition-colors {{ request()->routeIs('bangla-converter') ? 'font-semibold underline' : '' }}"
            title="Unicode to Bijoy - Bangla text Converter">
            <span class="i18n-bn">বাংলা কনভার্টার</span>
            <span class="i18n-en">Bangla Converter</span>
        </a>
    </li>
    <li class="border-b border-white/30 pb-1">
        <a href="{{ route('archive') }}"
            class="block text-2xl font-medium text-white hover:text-white/80 transition-colors {{ request()->routeIs('archive') ? 'font-semibold underline' : '' }}">
            <span class="i18n-bn">আর্কাইভ</span>
            <span class="i18n-en">Archive</span>
        </a>
    </li>
    <li class="border-b border-white/30 pb-1">
        <x-language-switcher class="block text-2xl font-medium text-white hover:text-white/80 transition-colors text-left w-full" />
    </li>
</ul>
@else
<div class="header-utility-links flex flex-wrap items-center justify-center gap-x-2 gap-y-1 text-xs md:text-sm font-normal text-slate-800 {{ $attributes->get('class') }}">
    <a href="{{ route('bangla-converter') }}"
        class="hover:text-primary transition-colors whitespace-nowrap {{ request()->routeIs('bangla-converter') ? 'text-primary' : '' }}"
        title="Unicode to Bijoy - Bangla text Converter">
        <span class="i18n-bn">বাংলা কনভার্টার</span>
        <span class="i18n-en">Bangla Converter</span>
    </a>
    <span aria-hidden="true">|</span>
    <a href="{{ route('archive') }}"
        class="hover:text-primary transition-colors whitespace-nowrap {{ request()->routeIs('archive') ? 'text-primary' : '' }}">
        <span class="i18n-bn">আর্কাইভ</span>
        <span class="i18n-en">Archive</span>
    </a>
    <span aria-hidden="true">|</span>
    <x-language-switcher />
</div>
@endif