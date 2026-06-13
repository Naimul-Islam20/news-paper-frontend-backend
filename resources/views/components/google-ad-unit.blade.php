@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;
$responsive = in_array($format, ['header', 'banner'], true);
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="display:block;{{ $responsive ? 'min-height:90px;width:100%;' : 'width:300px;max-width:100%;height:250px;' }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        @if($responsive)
        data-ad-format="auto"
        data-full-width-responsive="true"
        @endif
    ></ins>
</div>
@endif
