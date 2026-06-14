@if(!empty($ad) && ad_should_display($ad))
    @php $boxStyle = $ad->slotBoxStyle('box'); @endphp
    @if($ad->displayUsesLocalAd())
    <div class="not-prose lg:hidden ad-section my-6 w-full mx-auto">
        <a href="{{ advertisement_click_url($ad) }}" target="_blank" rel="noopener" class="ad-slot-frame block img-placeholder group cursor-pointer relative overflow-hidden bg-gray-50 w-full" style="{{ $boxStyle }}">
            <x-ad-picture :ad="$ad" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90 group-hover:opacity-100" />
        </a>
    </div>
    @elseif($ad->displayUsesGoogleAd())
    <div class="not-prose lg:hidden ad-section my-6 w-full mx-auto" data-ad-slot-root>
        <div class="ad-slot-frame ad-slot-google block relative overflow-hidden bg-gray-50 w-full" style="{{ $boxStyle }}">
            <x-google-ad-unit :ad="$ad" format="inline" class="h-full w-full" />
        </div>
    </div>
    @endif
@endif
