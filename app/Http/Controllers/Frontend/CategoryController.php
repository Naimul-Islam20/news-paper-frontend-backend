<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Post;
use App\Models\Video;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        return match ($category->type) {
            'gallery' => $this->galleryCategory($category),
            'video'   => $this->videoCategory($category),
            'page'    => $this->pageCategory($category),
            default   => $this->postCategory($category),
        };
    }

    // post type → national.blade.php design
    private function postCategory(Category $category): View
    {
        $posts = Post::with(['reporter', 'categories'])
            ->whereHas('categories', fn($q) => $q->where('categories.id', $category->id))
            ->where('status', 'published')
            ->latest()
            ->paginate(10);

        return view('frontend.category', compact('category', 'posts'));
    }

    // gallery type → gallery.blade.php design
    private function galleryCategory(Category $category): View
    {
        $galleries = Gallery::with('images')
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('frontend.category-gallery', compact('category', 'galleries'));
    }

    // video type → videos.blade.php design
    private function videoCategory(Category $category): View
    {
        $videos = Video::where('category_id', $category->id)
            ->where('status', 'active')
            ->latest()
            ->paginate(10);

        return view('frontend.category-video', compact('category', 'videos'));
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
