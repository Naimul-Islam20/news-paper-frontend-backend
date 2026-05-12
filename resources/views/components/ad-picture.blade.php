{{-- Desktop: `image`। মোবাইল (max 767px): `image_mobile` থাকলে সেটি, না হলে ডেস্কটপ ইমেজ। --}}
@props(['ad'])

@if($ad && $ad->image)
<picture class="block h-full w-full min-h-0 min-w-0 max-w-full">
    @if(filled($ad->image_mobile))
    <source media="(max-width: 767px)" srcset="{{ storage_image_url($ad->image_mobile) }}">
    @endif
    <img
        src="{{ storage_image_url($ad->image) }}"
        alt="{{ $ad->caption ?? 'বিজ্ঞাপন' }}"
        onload="this.closest('.img-placeholder')?.classList.remove('img-placeholder')"
        {{ $attributes->merge(['class' => 'max-w-full min-w-0']) }}
    />
</picture>
@endif