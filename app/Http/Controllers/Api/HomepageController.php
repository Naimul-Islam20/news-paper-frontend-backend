<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Http\Resources\GalleryResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\VideoResource;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

class HomepageController extends Controller
{
    public function show(): JsonResponse
    {
        // Hero and top strips based on main_section_layer
        $heroPosts = Post::with(['categories', 'reporter'])
            ->where('status', 'published')
            ->where('main_section_layer', '1')
            ->latest()
            ->take(2)
            ->get();

        $topStripPosts = Post::with(['categories', 'reporter'])
            ->where('status', 'published')
            ->whereIn('main_section_layer', ['2', '3', '4'])
            ->latest()
            ->take(10)
            ->get();

        // Category sections with a handful of posts each
        $sectionCategories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->where('type', 'post')
            ->with(['subCategories', 'subCategories.children'])
            ->get();

        $sections = $sectionCategories->map(function (Category $category) {
            $posts = Post::with(['categories', 'reporter'])
                ->whereHas('categories', fn ($q) => $q->where('categories.id', $category->id))
                ->where('status', 'published')
                ->latest()
                ->take(8)
                ->get();

            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'children' => $category->subCategories->map(function (Category $child) {
                    return [
                        'id' => $child->id,
                        'name' => $child->name,
                        'slug' => $child->slug,
                    ];
                })->values(),
                'posts' => PostResource::collection($posts),
            ];
        })->values();

        // Galleries with a few images each
        $galleries = Gallery::with(['images', 'category'])
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Gallery $gallery) {
                return [
                    'id' => $gallery->id,
                    'title' => $gallery->title,
                    'slug' => $gallery->slug,
                    'category' => optional($gallery->category)->name,
                    'description' => $gallery->description,
                    'images' => $gallery->images->take(6)->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'url' => $image->image,
                            'caption' => $image->description,
                        ];
                    })->values(),
                ];
            })->values();

        // Videos: one main and a list
        $mainVideo = Video::with('category')
            ->where('status', 'active')
            ->where('is_main_video', 'yes')
            ->latest()
            ->first();

        $moreVideos = Video::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(12)
            ->get();

        // Simple advertisements list (schema is minimal for now)
        $ads = Advertisement::query()
            ->orderBy('id')
            ->get()
            ->map(fn ($ad) => ['id' => $ad->id])
            ->values();

        $payload = [
            'meta' => [
                'site_name' => 'Demo News',
                'site_title' => 'Demo News – Bangla Online Newspaper',
                'description' => 'Developer demo homepage data, seeded from Laravel.',
            ],
            'hero' => PostResource::collection($heroPosts),
            'top_strips' => PostResource::collection($topStripPosts),
            'sections' => $sections,
            'galleries' => GalleryResource::collection($galleries),
            'videos' => [
                'main' => $mainVideo ? new VideoResource($mainVideo) : null,
                'list' => VideoResource::collection($moreVideos),
            ],
            'ads' => AdvertisementResource::collection($ads),
        ];

        return response()->json($payload);
    }

    // Note: Post and Video transformations are handled by API Resources.
}

