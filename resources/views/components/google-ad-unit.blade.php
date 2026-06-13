@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;

[$style, $responsive, $adFormat] = match ($format) {
    'sidebar', 'inline' => [
        'display:block;width:300px;max-width:100%;height:250px;',
        'false',
        null,
    ],
    'header' => [
        'display:block;width:100%;min-height:70px;',
        'true',
        'horizontal',
    ],
    'banner' => [
        'display:block;width:100%;min-height:90px;',
        'true',
        'horizontal',
    ],
    default => [
        'display:block;width:100%;min-height:90px;',
        'true',
        'horizontal',
    ],
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="{{ $style }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        @if($adFormat) data-ad-format="{{ $adFormat }}" @endif
        data-full-width-responsive="{{ $responsive }}"></ins>
</div>
@endif
