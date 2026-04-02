<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Post detail page by slug (/news/{slug}).
     */
    public function show(string $slug): View
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
            ->take(6)
            ->get();

        // Refresh the model instance to get the latest views value
        $post->refresh();

        return view('frontend.post', compact('post', 'related'));
    }
}
