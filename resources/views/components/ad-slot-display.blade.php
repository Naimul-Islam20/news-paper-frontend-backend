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
$stripOuterClass = $variant === 'header'
    ? 'hidden w-full py-1 md:flex md:py-2 bg-white'
    : 'py-2 md:py-3 w-full';
$stripBoxStyle = $ad ? $ad->slotBoxStyle('strip') : '';
$boxStyle = $ad ? $ad->slotBoxStyle('box') : '';
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
                <a href="{{ advertisement_click_url($ad) }}" class="ad-slot-frame w-full flex items-center justify-center overflow-hidden bg-slate-50 img-placeholder" style="{{ $stripBoxStyle }}" target="_blank" rel="noopener">
                    <x-ad-picture :ad="$ad" class="{{ $pictureClass }}" />
                </a>
                @elseif($useGoogle)
                <div class="ad-slot-frame ad-slot-google w-full flex items-center justify-center overflow-hidden bg-slate-50" style="{{ $stripBoxStyle }}">
                    <x-google-ad-unit :ad="$ad" :format="$stripFormat" />
                </div>
                @endif
            </div>
        </div>
    @elseif($useLocal && $variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}">
            <a href="{{ advertisement_click_url($ad) }}" target="_blank" rel="noopener" class="ad-slot-frame block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 w-full {{ $sidebarClass }}" style="{{ $boxStyle }}">
                <x-ad-picture :ad="$ad" class="{{ $sidebarPictureClass }}" />
            </a>
        </div>
    @elseif($useGoogle && $variant === 'sidebar')
        <div class="{{ $wrapperClass ?: 'shrink-0 w-full' }}" data-ad-slot-root>
            <div class="ad-slot-frame ad-slot-google block relative overflow-hidden bg-gray-50 w-full {{ $sidebarClass }}" style="{{ $boxStyle }}">
                <x-google-ad-unit :ad="$ad" format="sidebar" class="h-full w-full" />
            </div>
        </div>
    @elseif($useLocal && $variant === 'inline')
        @include('frontend.partials.detail-inline-ad', ['ad' => $ad])
    @elseif($useGoogle && $variant === 'inline')
        <div class="not-prose lg:hidden ad-section my-6 w-full mx-auto {{ $wrapperClass }}" data-ad-slot-root>
            <div class="ad-slot-frame ad-slot-google block relative overflow-hidden bg-gray-50 w-full" style="{{ $boxStyle }}">
                <x-google-ad-unit :ad="$ad" format="inline" class="h-full w-full" />
            </div>
        </div>
    @endif
@elseif($slug)
<!-- ad-slot:{{ $slug }} status=empty (local+google both off) -->
@endif
