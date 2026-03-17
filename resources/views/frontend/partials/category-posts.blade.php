@foreach($posts as $post)
@php
$primaryCategory = $post->categories->first();
$parentCategory = optional($primaryCategory)->parent;
$categorySlug = $parentCategory ? $parentCategory->slug : optional($primaryCategory)->slug;
$subCategorySlug = $parentCategory ? $primaryCategory->slug : null;
@endphp
<article class="flex flex-col md:flex-row gap-2 md:gap-4 last:pb-0 category-post-item">
    <a
        href="{{ $subCategorySlug ? route('news.show.sub', [$categorySlug, $subCategorySlug, $post->slug]) : route('news.show', [$categorySlug, $post->slug]) }}"
        class="w-full md:w-auto flex-shrink-0">
        <div class="img-placeholder w-full md:w-[305px] h-[200px] md:h-[170px] overflow-hidden">
            <img src="{{ $post->image ? asset('storage/'.$post->image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600' }}"
                alt="{{ $post->title }}"
                class="w-full h-full object-cover"
                onload="this.parentElement.classList.remove('img-placeholder')">
        </div>
    </a>
    <div class="flex flex-col justify-start gap-2 pt-1 flex-1">
        <a href="{{ $subCategorySlug ? route('news.show.sub', [$categorySlug, $subCategorySlug, $post->slug]) : route('news.show', [$categorySlug, $post->slug]) }}">
            <h3 class="text-xl md:text-base font-bold serif text-title leading-snug hover:text-rose-600 transition-colors">
                {{ $post->title }}
            </h3>
        </a>
        @php
            $subTitleText = null;
            if (!empty($post->sub_title)) {
                $decoded = json_decode($post->sub_title, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $subTitleText = collect($decoded)
                        ->first(function ($value) {
                            return is_string($value) && trim($value) !== '';
                        });
                } else {
                    $subTitleText = $post->sub_title;
                }
            }
        @endphp
        @if($subTitleText)
            <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                {{ $subTitleText }}
            </p>
        @elseif($post->description)
            <p class="hidden md:block text-sm font-semibold text-desc leading-relaxed line-clamp-2">
                {{ Str::limit(strip_tags($post->description), 160) }}
            </p>
        @endif
        <div class="flex items-center gap-1.5 mt-auto text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
            <span class="text-xs font-medium text-gray-500">
                {{ $post->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
</article>
@endforeach
