@props([
    'ad',
    'layout' => 'strip',
    'class' => '',
    'fullWidthResponsive' => false,
])

@php
$client = google_adsense_client();
$slotId = google_adsense_slot_for($ad);
$boxStyle = $ad ? $ad->slotBoxStyle($layout === 'strip' ? 'strip' : 'box') : '';
$responsive = filter_var($fullWidthResponsive, FILTER_VALIDATE_BOOLEAN);
$adDims = $ad ? $ad->mediaSpecDimensions() : null;
$adWidth = $adDims['width'] ?? null;
$adHeight = $adDims['height'] ?? null;
$adFormat = $layout === 'strip'
    ? ($responsive ? 'auto' : 'horizontal')
    : 'rectangle';
$frameClass = $layout === 'strip'
    ? 'ad-slot-frame ad-slot-google w-full min-w-0 block relative overflow-hidden bg-white'
    : 'ad-slot-frame ad-slot-google block overflow-hidden bg-white w-full min-w-0 relative';
$insStyle = 'display:block;width:100%;';
if ($adHeight) {
    $insStyle .= "min-height:{$adHeight}px;";
}
@endphp

@if($client && $slotId && $ad)
<div class="{{ $frameClass }} {{ $class }}" style="{{ $boxStyle }}" data-ad-layout="{{ $layout }}">
    @if($layout === 'strip')
    <span class="ad-slot-size-hold block w-full pointer-events-none" aria-hidden="true"></span>
    @endif
    <ins class="adsbygoogle"
         style="{{ $insStyle }}"
         data-ad-client="{{ $client }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $adFormat }}"
         data-full-width-responsive="{{ $responsive ? 'true' : 'false' }}"
         @if($adWidth && $adHeight && ! $responsive)
         data-ad-width="{{ $adWidth }}"
         data-ad-height="{{ $adHeight }}"
         @endif></ins>
    {{-- Google AdSense standard — HTML parse হওয়ার সাথে সাথে push --}}
    <script>(adsbygoogle=window.adsbygoogle||[]).push({});</script>
</div>
@endif
