@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;
$isResponsive = in_array($format, ['header', 'banner'], true);
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    @if($isResponsive)
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
    @else
    <ins class="adsbygoogle"
        style="display:block;width:300px;max-width:100%;height:250px;"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"></ins>
    @endif
</div>
@endif
