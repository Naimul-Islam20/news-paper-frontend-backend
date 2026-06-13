@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;

$insStyle = match ($format) {
    'header', 'banner' => 'display:inline-block;width:728px;max-width:100%;height:90px',
    'sidebar', 'inline' => 'display:inline-block;width:300px;max-width:100%;height:250px',
    default => 'display:inline-block;width:728px;max-width:100%;height:90px',
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="{{ $insStyle }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
@endif
