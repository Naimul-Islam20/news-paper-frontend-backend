@props([
'ad',
'layout' => 'strip',
'class' => '',
])

@php
$client = google_adsense_client();
$slotId = google_adsense_slot_for($ad);
$boxStyle = $ad ? $ad->slotBoxStyle($layout === 'strip' ? 'strip' : 'box') : '';
$adFormat = $layout === 'strip' ? 'horizontal' : 'rectangle';
$frameClass = $layout === 'strip'
? 'ad-slot-frame ad-slot-google w-full flex items-center justify-center overflow-hidden bg-white'
: 'ad-slot-frame ad-slot-google block overflow-hidden bg-white w-full';
@endphp

@if($client && $slotId && $ad)
<div class="{{ $frameClass }} {{ $class }}" style="{{ $boxStyle }}" data-ad-layout="{{ $layout }}">
    <ins class="adsbygoogle ad-slot-media block w-full h-full max-w-full max-h-full"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slotId }}"
        data-ad-format="{{ $adFormat }}"
        data-full-width-responsive="false"></ins>
</div>
@endif