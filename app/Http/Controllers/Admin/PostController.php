<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Reporter;
use App\Models\Topic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        // Base query with relationships and default ordering (latest first)
        $baseQuery = Post::with(['categories', 'reporter.subEditor', 'creator', 'editor'])->latest();

        // Filter by category (if selected)
        if ($request->filled('category_id') && $request->category_id !== 'all') {
            $baseQuery->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Filter by status (if selected)
        if ($request->filled('status') && $request->status !== 'all') {
            $baseQuery->where('status', $request->status);
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
        $topics = Topic::orderBy('can_delete', 'asc')->orderBy('name', 'asc')->get();

        $pickedImage = session()->pull('post_picked_image');

        return view('admin.posts.create', compact('categories', 'reporters', 'topics', 'pickedImage'));
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->boolean('bulk_delete')) {
            return $this->bulkDestroy($request);
        }

        $request->validate([
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:150',
            'sub_title_points'   => 'nullable|array',
            'sub_title_points.*' => 'nullable|string|max:255',
            'category_ids'      => 'required|array|min:1',
            'category_ids.*'    => 'exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'existing_image'     => 'nullable|string|max:255',
            'image_caption'      => 'nullable|string',
            'description'        => 'required|string',
            'reporter_id'        => 'required|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'hero_layer'         => 'nullable|in:1,2,3,4',
        ], [
            'title.required'       => 'শিরোনাম অবশ্যই দিতে হবে।',
            'category_ids.required' => 'ক্যাটাগরি বা সাব-ক্যাটাগরি নির্বাচন করুন।',
            'category_ids.min'      => 'ক্যাটাগরি বা সাব-ক্যাটাগরি নির্বাচন করুন।',
            'image.required'       => 'ছবি আপলোড করুন।',
            'description.required' => 'বিবরণ লিখুন।',
            'reporter_id.required' => 'রিপোর্টার নির্বাচন করুন।',
        ]);

        $data = $this->buildPostFormData($request);
        $data['created_by'] = Auth::id();

        if (! $request->hasFile('image') && ! $request->filled('existing_image')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['image' => 'ছবি আপলোড করুন বা মিডিয়া থেকে বেছে নিন।']);
        }

        try {
            $this->applyImageToPostData($request, $data);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->errors());
        }

        $post = Post::create($data);

        // Sync categories
        if ($request->has('category_ids')) {
            $post->categories()->sync($request->category_ids);
        }

        // Sync topics
        if ($request->has('topic_ids')) {
            $post->topics()->sync($request->topic_ids);
        }

        session()->put('clear_post_create_draft', true);

        return redirect()->route('admin.posts.index')->with('post_published', [
            'slug'   => $post->slug,
            'title'  => $post->title,
            'status' => $post->status,
        ]);
    }

    public function edit($id): View
    {
        $post = Post::with('categories')->findOrFail($id);

        $categories = Category::where('type', 'post')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $reporters = $this->reportersForCurrentUser();
        $topics = Topic::orderBy('can_delete', 'asc')->orderBy('name', 'asc')->get();

        $pickedImage = session()->pull('post_picked_image');

        return view('admin.posts.edit', compact('post', 'categories', 'reporters', 'topics', 'pickedImage'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:150',
            'sub_title_points'   => 'nullable|array',
            'sub_title_points.*' => 'nullable|string|max:255',
            'category_ids'      => 'required|array|min:1',
            'category_ids.*'    => 'exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'existing_image'     => 'nullable|string|max:255',
            'image_caption'      => 'nullable|string',
            'description'        => 'required|string',
            'reporter_id'        => 'required|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'hero_layer'         => 'nullable|in:1,2,3,4',
        ], [
            'title.required'       => 'শিরোনাম অবশ্যই দিতে হবে।',
            'category_ids.required' => 'ক্যাটাগরি বা সাব-ক্যাটাগরি নির্বাচন করুন।',
            'category_ids.min'      => 'ক্যাটাগরি বা সাব-ক্যাটাগরি নির্বাচন করুন।',
            'description.required' => 'বিবরণ লিখুন।',
            'reporter_id.required' => 'রিপোর্টার নির্বাচন করুন।',
        ]);

        $data = $this->buildPostFormData($request, $post);
        $data['edited_by'] = Auth::id();

        if ($request->hasFile('image') || $request->filled('existing_image')) {
            try {
                $this->applyImageToPostData($request, $data, $post);
            } catch (ValidationException $e) {
                return redirect()->back()->withInput()->withErrors($e->errors());
            }
        }

        $post->update($data);

        // Sync categories
        if ($request->has('category_ids')) {
            $post->categories()->sync($request->category_ids);
        } else {
            $post->categories()->sync([]);
        }

        // Sync topics
        if ($request->has('topic_ids')) {
            $post->topics()->sync($request->topic_ids);
        } else {
            $post->topics()->sync([]);
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

    public function pickImage(Request $request): View
    {
        $validated = $request->validate([
            'context' => 'required|in:create,edit',
            'post_id' => 'required_if:context,edit|nullable|integer|exists:posts,id',
            'search'  => 'nullable|string|max:100',
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $perPage = 60;
        $page = max(1, (int) $request->get('page', 1));

        $validImages = $this->queryDistinctPostImages($search)
            ->get()
            ->filter(fn ($row) => $this->postImageFileExists($row->image))
            ->values();

        $lastPage = max(1, (int) ceil($validImages->count() / $perPage));

        if ($page > $lastPage && $validImages->isNotEmpty()) {
            return redirect()->route('admin.posts.pick-image', array_filter([
                'context' => $validated['context'],
                'post_id' => $validated['post_id'] ?? null,
                'search'  => $search !== '' ? $search : null,
                'page'    => $lastPage,
            ]));
        }

        $images = new LengthAwarePaginator(
            $validImages->forPage($page, $perPage)->values(),
            $validImages->count(),
            $perPage,
            $page,
            ['path' => $request->url()]
        );
        $images->appends($request->except('page'));

        return view('admin.posts.pick-image', [
            'images'  => $images,
            'context' => $validated['context'],
            'postId'  => $validated['post_id'] ?? null,
            'search'  => $search,
        ]);
    }

    public function applyPickedImage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'existing_image' => 'required|string|max:255',
            'context'        => 'required|in:create,edit',
            'post_id'        => 'required_if:context,edit|nullable|integer|exists:posts,id',
        ]);

        $path = $this->resolveExistingPostImage($validated['existing_image']);

        if ($path === null) {
            return redirect()
                ->route('admin.posts.pick-image', array_filter([
                    'context' => $validated['context'],
                    'post_id' => $validated['post_id'] ?? null,
                ]))
                ->withErrors(['existing_image' => 'নির্বাচিত ছবি সঠিক নয় বা ফাইল পাওয়া যায়নি।']);
        }

        session(['post_picked_image' => $path]);

        if ($validated['context'] === 'edit') {
            return redirect()->route('admin.posts.edit', $validated['post_id']);
        }

        return redirect()->route('admin.posts.create');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->deletePostImageIfUnused($post->image, $post->id);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:posts,id',
        ], [
            'ids.required' => 'কমপক্ষে একটি পোস্ট নির্বাচন করুন।',
            'ids.min' => 'কমপক্ষে একটি পোস্ট নির্বাচন করুন।',
        ]);

        $ids = array_values(array_unique(array_map('intval', $validated['ids'])));
        $deleted = 0;

        foreach (Post::whereIn('id', $ids)->get() as $post) {
            $this->deletePostImageIfUnused($post->image, $post->id);
            $post->delete();
            $deleted++;
        }

        $message = $deleted === 1
            ? '১টি পোস্ট মুছে ফেলা হয়েছে।'
            : "{$deleted}টি পোস্ট মুছে ফেলা হয়েছে।";

        return redirect()
            ->route('admin.posts.index', $request->only(['search', 'category_id', 'status']))
            ->with('success', $message);
    }

    protected function buildPostFormData(Request $request, ?Post $post = null): array
    {
        $data = $request->only([
            'title', 'subtitle', 'description', 'image_caption',
            'seo_keywords', 'status', 'hero_layer',
        ]);

        $data['subtitle'] = trim((string) ($data['subtitle'] ?? '')) ?: null;

        if (isset($data['description']) && is_string($data['description'])) {
            $data['description'] = sanitize_post_description_for_storage($data['description']);
        }

        $points = collect($request->input('sub_title_points', []))
            ->map(fn ($value) => is_string($value) ? trim($value) : '')
            ->filter(fn ($value) => $value !== '')
            ->values()
            ->all();

        $data['sub_title'] = ! empty($points)
            ? json_encode($points, JSON_UNESCAPED_UNICODE)
            : null;
        $data['reporter_id'] = $this->resolveReporterId($request->reporter_id);
        $data['is_special_news'] = $request->boolean('is_special_news');

        $slugSource = $request->seo_keywords ?: $request->title;
        $data['slug'] = $this->makePostSlug($slugSource, $post?->id);

        return $data;
    }

    protected function queryDistinctPostImages(string $search = '')
    {
        $query = DB::table('posts')
            ->whereNotNull('image')
            ->where('image', '!=', '');

        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return $query
            ->select('image', DB::raw('MAX(created_at) as last_used'), DB::raw('MAX(title) as sample_title'))
            ->groupBy('image')
            ->orderByDesc('last_used');
    }

    protected function applyImageToPostData(Request $request, array &$data, ?Post $post = null): void
    {
        if ($request->hasFile('image')) {
            if ($post?->image) {
                $this->deletePostImageIfUnused($post->image, $post->id);
            }

            $data['image'] = store_post_featured_upload($request->file('image'));

            return;
        }

        if ($request->filled('existing_image')) {
            $path = $this->resolveExistingPostImage($request->input('existing_image'));

            if ($path === null) {
                throw ValidationException::withMessages([
                    'image' => 'মিডিয়া থেকে নির্বাচিত ছবি সঠিক নয়।',
                ]);
            }

            if ($post?->image && $post->image !== $path) {
                $this->deletePostImageIfUnused($post->image, $post->id);
            }

            $data['image'] = $path;
        }
    }

    protected function resolveExistingPostImage(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '' || str_contains($path, '..')) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return null;
        }

        $path = ltrim($path, '/');

        if (! preg_match('#^posts/[A-Za-z0-9._-]+$#', $path)) {
            return null;
        }

        if (! Post::where('image', $path)->exists()) {
            return null;
        }

        return $this->postImageFileExists($path) ? $path : null;
    }

    protected function postImageFileExists(string $path): bool
    {
        $path = ltrim($path, '/');

        return is_file(public_path($path)) || Storage::disk('public')->exists($path);
    }

    protected function deletePostImageIfUnused(?string $path, ?int $ignorePostId = null): void
    {
        if (! $path) {
            return;
        }

        $query = Post::where('image', $path);

        if ($ignorePostId) {
            $query->where('id', '!=', $ignorePostId);
        }

        if ($query->exists()) {
            return;
        }

        delete_uploaded_media($path);
    }

    /** Admin ইত্যাদির জন্য সব active reporter; Reporter role হলে শুধু নিজের row */
    protected function reportersForCurrentUser()
    {
        $user = auth()->user();

        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return Reporter::query()
                ->where('id', $user->reporter_id)
                ->get();
        }

        return Reporter::query()
            ->where('status', 'active')
            ->orderBy('desk')
            ->get();
    }

    /** Reporter role থাকলে শুধু নিজের reporter_id; অন্যথায় form থেকে */
    protected function resolveReporterId($requestReporterId)
    {
        $user = auth()->user();
        if (! $user) {
            return $requestReporterId;
        }

        if ($user->role === 'reporter' && $user->reporter_id) {
            return $user->reporter_id;
        }

        return $requestReporterId;
    }
}
