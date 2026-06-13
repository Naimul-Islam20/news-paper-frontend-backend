{{-- Local বা Google Ad — Local priority; Google fallback --}}
@props([
    'slug' => null,
    'ad' => null,
    'variant' => 'banner',
    'wrapperClass' => '',
    'sidebarClass' => '',
    'pictureClass' => 'ad-slot-media max-w-full max-h-full w-auto h-auto object-contain',
    'sidebarPictureClass' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100',
])

@php
$ad = $ad ?? ($slug ? ad_slot($slug) : null);
$isStrip = in_array($variant, ['header', 'banner'], true);
$stripFormat = $variant === 'header' ? 'header' : 'banner';
$stripFrameClass = $variant === 'header' ? 'ad-slot-frame--header' : 'ad-slot-frame--banner';
$stripOuterClass = $variant === 'header'
    ? 'hidden w-full py-1 md:flex md:py-2 bg-white'
    : 'py-2 md:py-3 w-full';
@endphp

@if($ad && ad_should_display($ad))
    @php
        $useLocal = $ad->displayUsesLocalAd();
        $useGoogle = ! $useLocal && $ad->displayUsesGoogleAd();
    @endphp

    @if($isStrip)
        <div class="{{ $stripOuterClass }} {{ $wrapperClass }}" @if($useGoogle) data-ad-slot-root @endif>
            <div class="container">
                @if($useLocal)
                <a href="{{ advertisement_click_url($ad) }}" class="ad-slot-frame {{ $stripFrameClass }} w-full flex items-center justify-center bg-slate-50 img-placeholder" target="_blank" rel="noopener">
                    <x-ad-picture :ad="$ad" class="{{ $pictureClass }}" />
                </a>
                @elseif($useGoogle)
                <div class="ad-slot-google ad-slot-google--{{ $stripFormat }} w-full flex items-center justify-center bg-slate-50">
                    <x-google-ad-unit :ad="$ad" :format="$stripFormat" />
                </div>
                @endif
            </div>
        </div>
    @elseif($useLocal && $variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}">
            <a href="{{ advertisement_click_url($ad) }}" target="_blank" rel="noopener" class="block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/3] w-full {{ $sidebarClass }}">
                <x-ad-picture :ad="$ad" class="{{ $sidebarPictureClass }}" />
            </a>
        </div>
    @elseif($useGoogle && $variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}" data-ad-slot-root>
            <div class="block relative bg-gray-50 w-full {{ $sidebarClass }}">
                <x-google-ad-unit :ad="$ad" format="sidebar" class="mx-auto" />
            </div>
        </div>
    @elseif($useLocal && $variant === 'inline')
        @include('frontend.partials.detail-inline-ad', ['ad' => $ad])
    @elseif($useGoogle && $variant === 'inline')
        <div class="not-prose lg:hidden ad-section my-6 w-full max-w-[min(100%,320px)] mx-auto {{ $wrapperClass }}" data-ad-slot-root>
            <div class="block relative bg-gray-50 w-full">
                <x-google-ad-unit :ad="$ad" format="inline" class="mx-auto" />
            </div>
        </div>
    @endif
@elseif($slug)
<!-- ad-slot:{{ $slug }} status=empty (local+google both off) -->
@endif
