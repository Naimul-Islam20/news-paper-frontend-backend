@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;

$styles = match ($format) {
    'sidebar', 'inline' => 'display:inline-block;width:300px;max-width:100%;height:250px;',
    'header' => 'display:inline-block;width:100%;max-width:1000px;height:90px;',
    default => 'display:inline-block;width:100%;max-width:1000px;height:90px;',
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="{{ $styles }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        data-full-width-responsive="false"></ins>
</div>
@endif
