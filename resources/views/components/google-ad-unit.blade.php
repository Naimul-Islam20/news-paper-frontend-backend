@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
</div>
@endif
