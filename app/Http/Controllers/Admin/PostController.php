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
    public function index(): View
    {
        $posts = Post::with(['categories', 'reporter'])->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        // Get only root categories with their sub-categories where type is 'post'
        $categories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->where('type', 'post')
            ->with(['subCategories' => function($query) {
                $query->where('status', 'active')->where('type', 'post');
            }])
            ->get();

        $reporters = Reporter::where('status', 'active')->orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'reporters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'sub_title'          => 'nullable|string|max:255',
            'categories'         => 'nullable|array',
            'categories.*'       => 'exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_caption'      => 'nullable|string',
            'description'        => 'nullable|string',
            'reporter_id'        => 'nullable|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'main_section_layer' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'sub_title', 'description', 'image_caption',
            'reporter_id', 'seo_keywords', 'status', 'main_section_layer'
        ]);

        // Generate slug from SEO Keywords. If user emptied it, fallback to title.
        $slugBase = $request->seo_keywords ?: $request->title;
        $data['slug'] = Str::slug($slugBase);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if ($request->categories) {
            $post->categories()->attach($request->categories);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post published successfully!');
    }

    public function edit($id): View
    {
        $post = Post::with('categories')->findOrFail($id);
        
        $categories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->where('type', 'post')
            ->with(['subCategories' => function($query) {
                $query->where('status', 'active')->where('type', 'post');
            }])
            ->get();

        $reporters = Reporter::where('status', 'active')->orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'reporters'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title'              => 'required|string|max:255',
            'sub_title'          => 'nullable|string|max:255',
            'categories'         => 'nullable|array',
            'categories.*'       => 'exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_caption'      => 'nullable|string',
            'description'        => 'nullable|string',
            'reporter_id'        => 'nullable|exists:reporters,id',
            'seo_keywords'       => 'nullable|string',
            'status'             => 'required|in:published,draft,pending',
            'main_section_layer' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'sub_title', 'description', 'image_caption',
            'reporter_id', 'seo_keywords', 'status', 'main_section_layer'
        ]);

        $slugBase = $request->seo_keywords ?: $request->title;
        $data['slug'] = Str::slug($slugBase);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        $post->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
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
}
