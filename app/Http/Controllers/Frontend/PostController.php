<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Legacy article detail page by slug only (/news/{slug}).
     */
    public function showLegacy(string $slug): View
    {
        $post = Post::with(['reporter', 'categories.parent.subCategories'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Increase view count each time a post detail page is opened
        $post->increment('views');

        $categoryIds = $post->categories->pluck('id');

        $related = Post::with('categories.parent')
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->when($categoryIds->isNotEmpty(), function ($query) use ($categoryIds) {
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            })
            ->latest()
            ->take(4)
            ->get();

        // Refresh the model instance to get the latest views value
        $post->refresh();

        return view('frontend.post', compact('post', 'related'));
    }

    /**
     * Article detail page with category / subcategory path:
     * - /{categorySlug}/{postSlug}
     * - /{categorySlug}/{subCategorySlug}/{postSlug}
     *
     * We currently resolve the post ONLY by its own slug for simplicity,
     * and ignore the category slugs (they are for SEO / readability).
     */
    public function showWithPath(string $categorySlug, string $second, ?string $third = null): View
    {
        // When URL is /{categorySlug}/{postSlug} → second is post slug
        // When URL is /{categorySlug}/{subCategorySlug}/{postSlug} → third is post slug
        $postSlug = $third ?? $second;

        return $this->showLegacy($postSlug);
    }
}
