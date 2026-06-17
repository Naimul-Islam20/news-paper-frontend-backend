<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Legacy Google index: /news-view/{id} → /{slug}
     */
    public function redirectLegacyNewsView(int $id): RedirectResponse
    {
        return $this->redirectLegacyPostById($id);
    }

    /**
     * Legacy URL: /news/{slug-or-id} → /{slug}
     */
    public function redirectLegacyNews(string $slug): RedirectResponse
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if ($post) {
            return redirect()->to(news_url($post), 301);
        }

        if (ctype_digit($slug)) {
            return $this->redirectLegacyPostById((int) $slug);
        }

        abort(404);
    }

    private function redirectLegacyPostById(int $id): RedirectResponse
    {
        $post = Post::query()
            ->where('id', $id)
            ->where('status', 'published')
            ->first();

        if ($post && $post->slug) {
            return redirect()->to(news_url($post), 301);
        }

        abort(404);
    }

    /**
     * Post featured image — full page viewer (/{slug}/photo).
     */
    public function showPhoto(string $slug): View
    {
        $post = Post::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (! $post || ! $post->image) {
            abort(404);
        }

        return view('frontend.post-photo', compact('post'));
    }

    /**
     * Post detail page by slug (/{slug}).
     */
    public function show(string $slug): View
    {
        // Try finding a Post first (slug), then numeric ID (WhatsApp share links)
        $post = Post::with(['reporter.subEditor', 'creator', 'categories.parent.subCategories', 'topics'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (! $post && ctype_digit($slug)) {
            $post = Post::with(['reporter.subEditor', 'creator', 'categories.parent.subCategories', 'topics'])
                ->where('id', (int) $slug)
                ->where('status', 'published')
                ->first();
        }

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
        $video = \App\Models\Video::with(['category', 'reporter.subEditor'])
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
        $gallery = \App\Models\Gallery::with(['images', 'category', 'reporter.subEditor'])
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
