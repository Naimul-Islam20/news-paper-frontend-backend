<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        // Base query with relationships and default ordering (latest first)
        $baseQuery = Post::with(['categories', 'reporter'])->latest();

        // Filter by category (if selected)
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $baseQuery->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Clone for applying search / serial logic on top of the same base query
        $query = clone $baseQuery;

        if ($request->filled('search')) {
            $search = trim($request->search);

            // If only digits given, treat as serial number (SL)
            if ($search !== '' && ctype_digit($search)) {
                $serial = (int) $search;

                if ($serial > 0) {
                    // Find the N-th post (respecting filters + ordering), then filter by that id
                    $targetPost = (clone $baseQuery)
                        ->skip($serial - 1)
                        ->take(1)
                        ->first();

                    if ($targetPost) {
                        $query->whereKey($targetPost->id);
                    } else {
                        // No such serial exists in current filtered list
                        $query->whereRaw('1 = 0');
                    }
                }
            } else {
                // Text search: match by title
                $query->where('title', 'like', '%' . $search . '%');
            }
        }

        $posts = $query->paginate(10)->withQueryString();

        $categories = Category::where('type', 'post')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'post')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $reporters = $this->reportersForCurrentUser();

        return view('admin.posts.create', compact('categories', 'reporters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'sub_title'          => 'nullable|string|max:1000',
            'category_id'        => 'required|exists:categories,id',
            'image'              => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_caption'      => 'nullable|string',
            'description'        => 'required|string',
            'reporter_id'        => 'required|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'hero_layer'         => 'nullable|in:1,2,3,4',
        ], [
            'title.required'       => 'শিরোনাম অবশ্যই দিতে হবে।',
            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'image.required'       => 'ছবি আপলোড করুন।',
            'description.required' => 'বিবরণ লিখুন।',
            'reporter_id.required' => 'রিপোর্টার নির্বাচন করুন।',
        ]);

        $data = $request->only([
            'title', 'sub_title', 'description', 'image_caption',
            'seo_keywords', 'status', 'hero_layer'
        ]);
        $data['reporter_id'] = $this->resolveReporterId($request->reporter_id);
        $data['is_special_news'] = $request->boolean('is_special_news');

        // Slug: from SEO keywords (auto = title) or title. Title Bangla হলে slug ও Bangla থাকবে (slugifyUnicode).
        $slugSource = $request->seo_keywords ?: $request->title;
        $data['slug'] = $this->makePostSlug($slugSource);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        // Ensure a post belongs to at most one category
        if ($request->filled('category_id')) {
            $post->categories()->sync([$request->category_id]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post published successfully!');
    }

    public function edit($id): View
    {
        $post = Post::with('categories')->findOrFail($id);

        $categories = Category::where('type', 'post')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $reporters = $this->reportersForCurrentUser();

        return view('admin.posts.edit', compact('post', 'categories', 'reporters'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'              => 'required|string|max:255',
            'sub_title'          => 'nullable|string|max:1000',
            'category_id'        => 'required|exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_caption'      => 'nullable|string',
            'description'        => 'required|string',
            'reporter_id'        => 'required|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'hero_layer'         => 'nullable|in:1,2,3,4',
        ], [
            'title.required'       => 'শিরোনাম অবশ্যই দিতে হবে।',
            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন।',
            'description.required' => 'বিবরণ লিখুন।',
            'reporter_id.required' => 'রিপোর্টার নির্বাচন করুন।',
        ]);

        $data = $request->only([
            'title', 'sub_title', 'description', 'image_caption',
            'seo_keywords', 'status', 'hero_layer'
        ]);
        $data['reporter_id'] = $this->resolveReporterId($request->reporter_id);
        $data['is_special_news'] = $request->boolean('is_special_news');

        // Slug: from SEO keywords (auto = title) or title. Title Bangla হলে slug ও Bangla থাকবে (slugifyUnicode).
        $slugSource = $request->seo_keywords ?: $request->title;
        $data['slug'] = $this->makePostSlug($slugSource, $post->id);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        // Ensure a post belongs to at most one category
        if ($request->filled('category_id')) {
            $post->categories()->sync([$request->category_id]);
        } else {
            $post->categories()->sync([]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Build a unique slug for posts.
     *
     * - Keeps Bangla characters (and other Unicode letters) intact
     * - Converts spaces/underscores to single hyphens
     * - Ensures uniqueness in posts.slug column
     */
    protected function makePostSlug(string $source, ?int $ignoreId = null): string
    {
        $slug = $this->slugifyUnicode($source);

        if ($slug === '') {
            $slug = 'post';
        }

        $original = $slug;
        $i = 2;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, function ($query, $id) {
                    return $query->where('id', '!=', $id);
                })
                ->exists()
        ) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Slugify but keep Unicode letters + marks (e.g. Bangla যুক্তাক্ষর/কার). Title যেমন লিখা তেমন slug; ASCII ফোর্স করা হয় না।
     */
    protected function slugifyUnicode(string $value): string
    {
        $value = trim($value);

        // Keep letters, numbers, marks (বাংলা কার/মাত্রা), spaces, underscores, hyphens. Strip only punctuation/symbols.
        $value = preg_replace('/[^\pL\pN\pM\s_-]+/u', '', $value);

        // Replace spaces/underscores with single hyphen
        $value = preg_replace('/[\s_-]+/u', '-', $value);

        // Trim hyphens from both ends
        $value = trim($value, '-');

        // Lowercase (supports multibyte)
        return function_exists('mb_strtolower') ? mb_strtolower($value, 'UTF-8') : strtolower($value);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }

    /** Reporter লগইন থাকলে শুধু ওই রিপোর্টার; নাহলে সব active reporter */
    protected function reportersForCurrentUser()
    {
        $user = auth()->user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return Reporter::where('id', $user->reporter_id)->get();
        }
        return Reporter::where('status', 'active')->orderBy('name')->get();
    }

    /** Reporter role থাকলে শুধু নিজের id সেট হয়; অন্যথায় request থেকে */
    protected function resolveReporterId($requestReporterId)
    {
        $user = auth()->user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return $user->reporter_id;
        }
        return $requestReporterId;
    }
}
