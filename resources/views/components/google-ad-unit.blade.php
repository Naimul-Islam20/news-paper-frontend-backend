@props(['ad', 'minHeight' => null])

@php
$client = google_adsense_client();
$slot = $ad?->google_ad_slot ?? null;
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit w-full overflow-hidden']) }}>
    <ins class="adsbygoogle block w-full"
        style="display:block{{ $minHeight ? ';min-height:'.$minHeight : '' }}"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        data-ad-format="auto"
        data-full-width-responsive="true"></ins>
</div>
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
@endif
