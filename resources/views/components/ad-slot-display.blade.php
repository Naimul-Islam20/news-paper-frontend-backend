{{-- Local বা Google Ad — স্লট অনুযায়ী ফ্রন্টএন্ড লেআউট --}}
@props([
    'slug' => null,
    'ad' => null,
    'variant' => 'banner',
    'wrapperClass' => '',
    'sidebarClass' => '',
    'pictureClass' => 'w-full h-full object-cover object-center shadow-sm',
    'sidebarPictureClass' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100',
])

@php
$ad = $ad ?? ($slug ? ad_slot($slug) : null);
@endphp

@if($ad && ad_should_display($ad))
    @if($ad->displayUsesGoogleAd())
        @if($variant === 'header')
        <div class="hidden w-full py-1 md:flex md:py-2 justify-center bg-white px-2 {{ $wrapperClass }}">
            <div class="container flex justify-center overflow-hidden">
                <div class="w-full flex justify-center max-w-[1000px]">
                    <x-google-ad-unit :ad="$ad" format="header" class="w-full max-w-[1000px]" />
                </div>
            </div>
        </div>
        @elseif($variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}">
            <div class="block relative overflow-hidden bg-gray-50 w-full min-h-[250px] {{ $sidebarClass }}">
                <x-google-ad-unit :ad="$ad" format="sidebar" class="w-full max-w-[300px] mx-auto" />
            </div>
        </div>
        @elseif($variant === 'inline')
        <div class="not-prose lg:hidden ad-section my-6 w-full max-w-[min(100%,320px)] mx-auto {{ $wrapperClass }}">
            <div class="block relative overflow-hidden bg-gray-50 aspect-[4/3] w-full">
                <x-google-ad-unit :ad="$ad" format="inline" class="w-full max-w-[300px] mx-auto" />
            </div>
        </div>
        @else
        <div class="py-2 md:py-3 flex justify-center bg-transparent px-0 md:px-4 {{ $wrapperClass }}">
            <div class="container flex justify-center overflow-hidden">
                <div class="w-full flex justify-center max-w-[1000px] mx-auto">
                    <x-google-ad-unit :ad="$ad" format="banner" class="w-full max-w-[1000px]" />
                </div>
            </div>
        </div>
        @endif
    @else
        @if($variant === 'header')
        <div class="hidden w-full py-1 md:flex md:py-2 justify-center bg-white px-2 {{ $wrapperClass }}">
            <div class="container flex justify-center overflow-hidden">
                <a href="{{ advertisement_click_url($ad) }}" class="w-full flex justify-center max-w-[1000px]" target="_blank" rel="noopener">
                    <div class="img-placeholder w-full max-w-[1000px] h-[70px] md:h-[90px] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0">
                        <x-ad-picture :ad="$ad" class="max-w-full max-h-full w-auto h-full object-contain shadow-sm" />
                    </div>
                </a>
            </div>
        </div>
        @elseif($variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}">
            <a href="{{ advertisement_click_url($ad) }}" target="_blank" rel="noopener" class="block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/3] w-full {{ $sidebarClass }}">
                <x-ad-picture :ad="$ad" class="{{ $sidebarPictureClass }}" />
            </a>
        </div>
        @elseif($variant === 'inline')
        @include('frontend.partials.detail-inline-ad', ['ad' => $ad])
        @else
        <div class="py-2 md:py-3 flex justify-center bg-transparent px-0 md:px-4 {{ $wrapperClass }}">
            <div class="container flex justify-center overflow-hidden">
                <a href="{{ advertisement_click_url($ad) }}" class="w-full flex justify-center max-w-[1000px] mx-auto" target="_blank" rel="noopener">
                    <div class="img-placeholder w-full max-w-[1000px] h-[90px] md:h-[100px] overflow-hidden shrink-0">
                        <x-ad-picture :ad="$ad" class="{{ $pictureClass }}" />
                    </div>
                </a>
            </div>
        </div>
        @endif
    @endif
@endif
