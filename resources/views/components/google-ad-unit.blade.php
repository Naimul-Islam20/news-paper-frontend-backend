@props([
    'ad',
    'layout' => 'strip',
    'class' => '',
    'fullWidthResponsive' => false,
    'eager' => false,
])

@php
$client = google_adsense_client();
$slotId = google_adsense_slot_for($ad);
$boxStyle = $ad ? $ad->slotBoxStyle($layout === 'strip' ? 'strip' : 'box') : '';
$responsive = filter_var($fullWidthResponsive, FILTER_VALIDATE_BOOLEAN);
$eager = filter_var($eager, FILTER_VALIDATE_BOOLEAN);
$adDims = $ad ? $ad->mediaSpecDimensions() : null;
$adWidth = $adDims['width'] ?? null;
$adHeight = $adDims['height'] ?? null;
$adFormat = $layout === 'strip'
    ? ($responsive ? 'auto' : 'horizontal')
    : 'rectangle';
$frameClass = $layout === 'strip'
    ? 'ad-slot-frame ad-slot-google w-full min-w-0 flex items-center justify-center overflow-hidden bg-white'
    : 'ad-slot-frame ad-slot-google block overflow-hidden bg-white w-full min-w-0';
@endphp

@if($client && $slotId && $ad)
<div class="{{ $frameClass }} {{ $class }}" style="{{ $boxStyle }}" data-ad-layout="{{ $layout }}">
    <ins class="adsbygoogle ad-slot-media block w-full h-full max-w-full max-h-full min-w-0"
         data-ad-client="{{ $client }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="{{ $adFormat }}"
         data-full-width-responsive="{{ $responsive ? 'true' : 'false' }}"
         @if($adWidth && $adHeight && ! $responsive)
         data-ad-width="{{ $adWidth }}"
         data-ad-height="{{ $adHeight }}"
         @endif
         @if($eager) data-ad-eager="1" @endif></ins>
    @if($eager)
    <script>
    (function () {
        var ins = document.currentScript && document.currentScript.previousElementSibling;
        if (!ins || ins.getAttribute('data-ad-loaded') === '1') {
            return;
        }
        ins.setAttribute('data-ad-loaded', '1');
        try {
            (window.adsbygoogle = window.adsbygoogle || []).push({});
        } catch (e) {}
    })();
    </script>
    @endif
</div>
@endif
