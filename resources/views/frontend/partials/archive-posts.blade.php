@foreach($posts as $post)
<article class="flex flex-col md:flex-row gap-2 md:gap-4 last:pb-0 category-post-item">
    <a href="{{ route('news.show', [$post->slug]) }}" class="w-full md:w-auto flex-shrink-0">
        <div class="img-placeholder w-full md:w-[350px] aspect-video overflow-hidden shrink-0">
            <img src="{{ $post->image ? storage_image_url($post->image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600' }}"
                alt="{{ $post->title }}"
                class="w-full h-full object-cover"
                onload="this.parentElement.classList.remove('img-placeholder')">
        </div>
    </a>
    <div class="flex flex-col justify-start gap-2 pt-1 flex-1">
        <a href="{{ route('news.show', [$post->slug]) }}">
            <h3 class="text-lg md:text-lg font-bold serif text-title leading-snug hover:text-primary transition-colors">
                {{ $post->title }}
            </h3>
        </a>
        @if($post->description)
            <p class="text-base font-normal text-desc leading-relaxed line-clamp-3 max-md:line-clamp-2">
                {!! html_entity_decode(Str::limit(strip_tags($post->description), 250)) !!}
            </p>
        @endif
        <x-post-list-meta :post="$post" />
    </div>
</article>
@endforeach
