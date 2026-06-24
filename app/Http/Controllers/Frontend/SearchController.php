<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Video;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Unified search: Post, Gallery, Video by title/description.
     * Results merged into one list (category-page style), sorted by date.
     */
    public function index(Request $request, $slug = null): View
    {
        $district = trim((string) $request->get('district', ''));
        $upazila = trim((string) $request->get('upazila', ''));
        $topic = null;
        $isDivisionTopic = false;
        $divisionName = '';

        if ($slug) {
            $topic = Topic::where('slug', $slug)->first();
            $divisionName = $topic ? $topic->name : str_replace('-', ' ', $slug);
            $isDivisionTopic = ($topic && ! $topic->can_delete)
                || array_key_exists($divisionName, bangladesh_division_districts_map());

            if ($isDivisionTopic) {
                $query = bangladesh_regional_search_label($divisionName, $district ?: null, $upazila ?: null);
            } else {
                $query = $topic ? $topic->name : $divisionName;
            }
        } else {
            $query = trim((string) $request->get('q', ''));
        }

        $limit = $isDivisionTopic ? 50 : 20;

        $items = collect();

        if ($query !== '' || $slug) {
            $term = '%' . $query . '%';

            $postsQuery = Post::with(['categories.parent', 'topics'])
                ->where('status', 'published');

            if ($slug) {
                if ($isDivisionTopic) {
                    $locationNames = bangladesh_regional_search_location_names(
                        $divisionName,
                        $district ?: null,
                        $upazila ?: null
                    );
                    $topicIds = bangladesh_topic_ids_for_location_names($locationNames);

                    if ($topicIds !== []) {
                        $postsQuery->whereHas('topics', function ($topicQuery) use ($topicIds) {
                            $topicQuery->whereIn('topics.id', $topicIds);
                        });
                    } else {
                        $postsQuery->whereRaw('1 = 0');
                    }
                } else {
                    $postsQuery->whereHas('topics', function ($topicQuery) use ($slug) {
                        $topicQuery->where('slug', $slug);
                    });
                }
            } else {
                $postsQuery->where(function ($q) use ($term) {
                    $q->where('title', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhere('seo_keywords', 'like', $term);
                });
            }

            $posts = $postsQuery->latest()
                ->limit($limit)
                ->get();

            foreach ($posts as $post) {
                // Handling sub_title if it's JSON or has HTML tags
                $subTitle = $post->sub_title;
                if ($subTitle && is_string($subTitle)) {
                    $decoded = json_decode($subTitle, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $subTitle = collect($decoded)
                            ->map(fn($v) => is_string($v) ? html_entity_decode(strip_tags($v)) : $v)
                            ->first(fn($v) => is_string($v) && trim($v) !== '');
                    } else {
                        $subTitle = html_entity_decode(strip_tags($subTitle));
                    }
                }

                $items->push((object) [
                    'type'       => 'post',
                    'url'        => news_url($post),
                    'title'      => $post->title,
                    'image'      => $post->image ? storage_image_url($post->image) : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600',
                    'snippet'    => $subTitle ?: html_entity_decode(Str::limit(strip_tags((string) $post->description ?? ''), 160)),
                    'created_at' => $post->created_at,
                ]);
            }

            if (!$slug) {
                // Galleries (active)
                $galleries = Gallery::with('images')
                    ->where('status', 'active')
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('description', 'like', $term);
                    })
                    ->latest()
                    ->limit($limit)
                    ->get();

                foreach ($galleries as $gallery) {
                    $firstImage = $gallery->images->first();
                    $imageUrl = $firstImage && $firstImage->image
                        ? storage_image_url($firstImage->image)
                        : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600';
                    $items->push((object) [
                        'type'       => 'gallery',
                        'url'        => route('gallery.show', $gallery->slug),
                        'title'      => $gallery->title,
                        'image'      => $imageUrl,
                        'snippet'    => html_entity_decode(Str::limit(strip_tags((string) $gallery->description), 160)),
                        'created_at' => $gallery->created_at,
                    ]);
                }

                // Videos (active)
                $videos = Video::where('status', 'active')
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('description', 'like', $term);
                    })
                    ->latest()
                    ->limit($limit)
                    ->get();

                foreach ($videos as $video) {
                    $imageUrl = $video->image
                        ? storage_image_url($video->image)
                        : 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600';
                    $items->push((object) [
                        'type'       => 'video',
                        'url'        => route('videos.show', $video->slug),
                        'title'      => $video->title,
                        'image'      => $imageUrl,
                        'snippet'    => html_entity_decode(Str::limit(strip_tags((string) $video->description), 160)),
                        'created_at' => $video->created_at,
                    ]);
                }
            }

            $items = $items->sortByDesc(fn ($i) => $i->created_at->timestamp)->values();
        }

        return view('frontend.search', compact('query', 'items'));
    }
}
