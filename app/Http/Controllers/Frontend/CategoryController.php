<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * সর্বশেষ পেজ – সব ধরনের পোস্ট (post type), নতুন প্রথমে, ক্যাটাগরি পেজের মতোই UI।
     */
    public function latest(): View|JsonResponse
    {
        $baseQuery = Post::with(['reporter', 'categories.parent'])
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->where('type', 'post'))
            ->latest();

        $category = (object) [
            'name'   => 'সর্বশেষ',
            'parent' => null,
            'id'     => 0,
        ];

        $subCategorySource = (object) [
            'subCategories' => collect(),
            'slug'          => 'latest',
        ];

        return $this->categoryPostsWithLoadMore($baseQuery, 10, 20, compact('category', 'subCategorySource'), 'frontend.category');
    }

    public function show(string $slug): View|JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return match ($category->type) {
            'gallery' => $this->galleryCategory($category),
            'video'   => $this->videoCategory($category),
            'page'    => $this->pageCategory($category),
            default   => $this->postCategory($category),
        };
    }

    /**
     * Child category listing with parent + child slug:
     * /category/{parentSlug}/{childSlug}
     */
    public function showChild(string $parentSlug, string $childSlug): View
    {
        $parent = Category::where('slug', $parentSlug)->firstOrFail();

        $category = Category::where('slug', $childSlug)
            ->where('parent_id', $parent->id)
            ->firstOrFail();

        return $this->postCategory($category);
    }

    // post type → national.blade.php design
    private function postCategory(Category $category): View|JsonResponse
    {
        $baseQuery = Post::with(['reporter', 'categories.parent'])
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->where('status', 'published')
            ->latest();

        $subCategorySource = $category->parent ?? $category;

        return $this->categoryPostsWithLoadMore($baseQuery, 10, 20, compact('category', 'subCategorySource'), 'frontend.category');
    }

    /**
     * প্রথমে ১০টি খবর, আরও ক্লিক করলে ২০টি করে লোড। AJAX এ more_page প্যারামিটার ব্যবহার।
     */
    private function categoryPostsWithLoadMore($baseQuery, int $initialCount, int $moreCount, array $viewData, string $viewName): View|JsonResponse
    {
        return $this->categoryLoadMore($baseQuery, $initialCount, $moreCount, $viewData, $viewName, 'frontend.partials.category-posts', 'posts');
    }

    /**
     * যেকোনো টাইপ (পোস্ট/গ্যালারি/ভিডিও): প্রথমে ১০টি, আরও ক্লিক করলে ২০টি করে।
     */
    private function categoryLoadMore($baseQuery, int $initialCount, int $moreCount, array $viewData, string $viewName, string $partialView, string $variableName): View|JsonResponse
    {
        $total = (clone $baseQuery)->count();
        $morePage = (int) request()->input('more_page', 0);

        if (request()->ajax() && $morePage >= 1) {
            $offset = $initialCount + ($morePage - 1) * $moreCount;
            $items = (clone $baseQuery)->skip($offset)->take($moreCount)->get();
            $hasMore = $total > $initialCount + $morePage * $moreCount;
            $nextUrl = $hasMore ? request()->url() . '?more_page=' . ($morePage + 1) : null;

            return response()->json([
                'html'          => view($partialView, [$variableName => $items])->render(),
                'next_page_url' => $nextUrl,
                'has_more'      => $hasMore,
            ]);
        }

        $items = (clone $baseQuery)->take($initialCount)->get();
        $hasMore = $total > $initialCount;
        $nextPageUrl = $hasMore ? request()->url() . '?more_page=1' : null;

        $viewData[$variableName] = $items;
        $viewData['hasMore'] = $hasMore;
        $viewData['nextPageUrl'] = $nextPageUrl;

        return view($viewName, $viewData);
    }

    // gallery type → gallery.blade.php design (প্রথমে ১০, আরও এ ২০টি)
    private function galleryCategory(Category $category): View|JsonResponse
    {
        $baseQuery = Gallery::with('images')
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->latest();

        return $this->categoryLoadMore($baseQuery, 10, 20, compact('category'), 'frontend.category-gallery', 'frontend.partials.category-galleries', 'galleries');
    }

    // video type → videos.blade.php design (প্রথমে ১০, আরও এ ২০টি)
    private function videoCategory(Category $category): View|JsonResponse
    {
        $baseQuery = Video::where('category_id', $category->id)
            ->where('status', 'active')
            ->latest();

        return $this->categoryLoadMore($baseQuery, 10, 20, compact('category'), 'frontend.category-video', 'frontend.partials.category-videos', 'videos');
    }

    // page type → single page (privacy-policy style), not a list
    private function pageCategory(Category $category): View
    {
        $page = Page::where('category_id', $category->id)
            ->where('status', 'active')
            ->latest()
            ->firstOrFail();

        // Reuse the same layout as other single pages (similar to privacy-policy)
        return view('frontend.page', compact('page'));
    }
}
