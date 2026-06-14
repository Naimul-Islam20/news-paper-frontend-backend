@props([
    'ad',
    'format' => 'banner',
])

@php
$client = google_adsense_client();
$slot = google_adsense_slot_for($ad);

$insFormat = match ($format) {
    'header', 'banner' => ['data-ad-format' => 'horizontal', 'data-full-width-responsive' => 'false'],
    'sidebar', 'inline' => ['data-ad-format' => 'rectangle', 'data-full-width-responsive' => 'false'],
    default => [],
};
@endphp

@if($ad && $client && filled($slot))
<div {{ $attributes->merge(['class' => 'google-ad-unit google-ad-unit--'.$format]) }}>
    <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="{{ $client }}"
        data-ad-slot="{{ $slot }}"
        @foreach($insFormat as $attr => $value)
        {{ $attr }}="{{ $value }}"
        @endforeach></ins>
</div>
@endif
