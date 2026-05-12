@if(!empty($ad) && $ad->image)
<div class="not-prose lg:hidden ad-section my-6 w-full max-w-[min(100%,320px)] mx-auto">
    <a href="{{ advertisement_click_url($ad) }}" target="_blank" rel="noopener" class="block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 aspect-[4/3] w-full">
        <x-ad-picture :ad="$ad" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" />
    </a>
</div>
@endif
