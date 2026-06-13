@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;

$insStyle = match ($format) {
    'header', 'banner' => 'display:block;min-height:90px;width:100%;',
    'sidebar', 'inline' => 'display:inline-block;width:300px;max-width:100%;height:250px;',
    default => 'display:block;min-height:90px;width:100%;',
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="{{ $insStyle }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        @if(in_array($format, ['header', 'banner'], true))
        data-ad-format="auto"
        data-full-width-responsive="true"
        @endif
    ></ins>
</div>
@endif
