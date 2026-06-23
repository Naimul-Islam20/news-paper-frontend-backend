@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = google_adsense_slot_for($ad);
$dims = $ad?->mediaSpecDimensions();

if ($dims && in_array($format, ['header', 'banner'], true)) {
    $height = $dims['height'];
    $insStyle = "display:block;width:100%;height:{$height}px;min-height:{$height}px;max-height:{$height}px;";
} elseif ($dims) {
    $displayWidth = min($dims['width'], 300);
    $displayHeight = max(90, (int) round($displayWidth * $dims['height'] / $dims['width']));
    $insStyle = "display:block;width:100%;height:{$displayHeight}px;min-height:{$displayHeight}px;max-height:{$displayHeight}px;";
} else {
    $insStyle = 'display:block;width:100%;height:90px;min-height:90px;max-height:90px;';
}
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
