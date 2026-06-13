@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;

$styles = match ($format) {
    'sidebar', 'inline' => 'display:block;width:100%;max-width:300px;height:250px;margin:0 auto;',
    'header' => 'display:block;width:100%;max-width:1000px;height:90px;margin:0 auto;',
    default => 'display:block;width:100%;max-width:1000px;height:90px;margin:0 auto;',
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="{{ $styles }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"></ins>
</div>
@endif
