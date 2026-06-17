<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Post;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * সর্বশেষ পেজ – সব ধরনের পোস্ট (post type), নতুন প্রথমে, ক্যাটাগরি পেজের মতোই UI।
     */
    public function latest(): View|JsonResponse
    {
        return $this->listingPage('সর্বশেষ', 'latest');
    }

    /**
     * আর্কাইভ পেজ – তারিখ বাছাই করলে সেই দিন + তার আগের খবর; পরের দিনের খবর বাদ।
     */
    public function archive(): View|JsonResponse
    {
        $baseQuery = Post::with(['reporter.subEditor', 'categories.parent'])
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->where('type', 'post'));

        $selectedDate = $this->parseArchiveDate(request()->input('date'));

        if ($selectedDate) {
            $baseQuery->where('created_at', '<=', $selectedDate->copy()->endOfDay());
        }

        $baseQuery->latest();

        $calendarMonth = $this->parseArchiveMonth(request()->input('month'), $selectedDate);
        $datesWithPosts = $this->archiveDatesWithPosts($calendarMonth);
        $archiveYears = $this->archiveAvailableYears();

        $category = (object) [
            'name'   => 'আর্কাইভ',
            'parent' => null,
            'id'     => 0,
        ];

        $subCategorySource = (object) [
            'subCategories' => collect(),
            'slug'          => 'archive',
        ];

        return $this->categoryPostsWithLoadMore(
            $baseQuery,
            10,
            20,
            compact('category', 'subCategorySource', 'selectedDate', 'calendarMonth', 'datesWithPosts', 'archiveYears'),
            'frontend.archive',
            'frontend.partials.archive-posts'
        );
    }

    private function listingPage(string $title, string $slug): View|JsonResponse
    {
        $baseQuery = Post::with(['reporter.subEditor', 'categories.parent'])
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->where('type', 'post'))
            ->latest();

        $category = (object) [
            'name'   => $title,
            'parent' => null,
            'id'     => 0,
        ];

        $subCategorySource = (object) [
            'subCategories' => collect(),
            'slug'          => $slug,
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
        $baseQuery = Post::with(['reporter.subEditor', 'categories.parent'])
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->where('status', 'published')
            ->latest();

        $subCategorySource = $category->parent ?? $category;

        return $this->categoryPostsWithLoadMore($baseQuery, 10, 20, compact('category', 'subCategorySource'), 'frontend.category');
    }

    /**
     * প্রথমে ১০টি খবর, আরও ক্লিক করলে ২০টি করে লোড। AJAX এ more_page প্যারামিটার ব্যবহার।
     */
    private function categoryPostsWithLoadMore($baseQuery, int $initialCount, int $moreCount, array $viewData, string $viewName, string $partialView = 'frontend.partials.category-posts'): View|JsonResponse
    {
        return $this->categoryLoadMore($baseQuery, $initialCount, $moreCount, $viewData, $viewName, $partialView, 'posts');
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
            $nextUrl = $hasMore ? $this->loadMoreUrl($morePage + 1) : null;

            return response()->json([
                'html'          => view($partialView, $this->postsPartialData($viewData, $variableName, $items))->render(),
                'next_page_url' => $nextUrl,
                'has_more'      => $hasMore,
            ]);
        }

        $items = (clone $baseQuery)->take($initialCount)->get();
        $hasMore = $total > $initialCount;
        $nextPageUrl = $hasMore ? $this->loadMoreUrl(1) : null;

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

    private function loadMoreUrl(int $morePage): string
    {
        return request()->fullUrlWithQuery(['more_page' => $morePage]);
    }

    private function postsPartialData(array $viewData, string $variableName, $items): array
    {
        $data = [$variableName => $items];

        if (isset($viewData['subCategorySource']->slug)) {
            $data['listingSlug'] = $viewData['subCategorySource']->slug;
        }

        return $data;
    }

    private function parseArchiveDate(?string $date): ?Carbon
    {
        if (! $date) {
            return null;
        }

        try {
            $parsed = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
        } catch (\Throwable) {
            return null;
        }

        if ($parsed->isFuture()) {
            return null;
        }

        return $parsed;
    }

    private function parseArchiveMonth(?string $month, ?Carbon $selectedDate): Carbon
    {
        if ($month) {
            try {
                return Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            } catch (\Throwable) {
                // fall through
            }
        }

        if ($selectedDate) {
            return $selectedDate->copy()->startOfMonth();
        }

        return now()->startOfMonth();
    }

    /** @return array<int, string> */
    private function archiveDatesWithPosts(Carbon $month): array
    {
        $start = $month->copy()->startOfMonth()->startOfDay();
        $end = $month->copy()->endOfMonth()->endOfDay();

        return Post::query()
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->where('type', 'post'))
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as archive_day')
            ->groupBy('archive_day')
            ->pluck('archive_day')
            ->map(fn ($day) => Carbon::parse($day)->format('Y-m-d'))
            ->all();
    }

    /** @return array<int, int> */
    private function archiveAvailableYears(): array
    {
        $oldest = Post::query()
            ->where('status', 'published')
            ->whereHas('categories', fn ($q) => $q->where('type', 'post'))
            ->oldest('created_at')
            ->value('created_at');

        $startYear = $oldest ? (int) Carbon::parse($oldest)->year : (int) now()->year;
        $endYear = (int) now()->year;

        return range($endYear, $startYear);
    }
}
