@props(['ad', 'layout' => 'strip'])

@php
$client = google_adsense_client();
$slotId = google_adsense_slot_for($ad);
$boxStyle = $ad ? $ad->slotBoxStyle($layout === 'strip' ? 'strip' : 'box') : '';
@endphp

@if($client && $slotId && $ad)
<div class="ad-slot-frame ad-slot-google w-full flex items-center justify-center overflow-hidden bg-white" style="{{ $boxStyle }}">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ $client }}"
         data-ad-slot="{{ $slotId }}"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
</div>
@push('scripts')
<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
@endpush
@endif
