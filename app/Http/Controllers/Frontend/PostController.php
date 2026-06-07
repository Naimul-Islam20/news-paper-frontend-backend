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
        // Try finding a Post first
        $post = Post::with(['reporter', 'categories.parent.subCategories', 'topics'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if ($post) {
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
            $post->refresh();
            return view('frontend.post', compact('post', 'related'));
        }

        // Try finding a Video
        $video = \App\Models\Video::with(['category', 'reporter'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if ($video) {
            $related = \App\Models\Video::where('id', '!=', $video->id)
                ->where('status', 'active')
                ->latest()
                ->take(8)
                ->get();
            return view('frontend.video-details', compact('video', 'related'));
        }

        // Try finding a Gallery
        $gallery = \App\Models\Gallery::with(['images', 'category', 'reporter'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->first();

        if ($gallery) {
            $related = \App\Models\Gallery::with('images')
                ->where('id', '!=', $gallery->id)
                ->where('status', 'active')
                ->latest()
                ->take(5)
                ->get();
            return view('frontend.gallery-details', compact('gallery', 'related'));
        }

        // If nothing found, 404
        abort(404);
    }
}
