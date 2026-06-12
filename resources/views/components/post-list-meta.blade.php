@php $metaParts = post_list_meta_parts($post); @endphp
@if(!empty($metaParts))
<p class="flex flex-wrap items-center text-[11px] md:text-xs font-medium text-gray-500 leading-snug mt-auto">
    @foreach($metaParts as $index => $part)
        @if($index > 0)
        <span class="px-2" aria-hidden="true">|</span>
        @endif
        <span>{{ $part }}</span>
    @endforeach
</p>
@endif
