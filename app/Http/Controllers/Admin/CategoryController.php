<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * All categories (parent ones) with their subcategories
     */
    public function index()
    {
        // Parent categories with their children
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->latest()
            ->get();

        // All parent categories for the sub-category "add" dropdown
        $parentCategories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // Category types
        $categoryTypes = [
            'post'    => 'Post',
            'page'    => 'Page',
            'gallery' => 'Gallery',
            'video'   => 'Video',
        ];

        return view('admin.category.index', compact('categories', 'parentCategories', 'categoryTypes'));
    }

    /**
     * Store a new category or subcategory
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'type'        => 'nullable|string|in:post,page,gallery,video|max:100', // Type is nullable because subcategory inherits it
            'description' => 'nullable|string|max:500',
            'parent_id'   => 'nullable|exists:categories,id',
            'status'      => 'required|in:active,inactive',
        ]);

        // Generate slug: use user-provided slug if given, otherwise from name.
        // Keep Unicode (e.g. Bangla) characters; only normalize spaces/dashes.
        $baseSlug = $request->filled('slug')
            ? $this->makeSlug($request->slug)
            : $this->makeSlug($request->name);

        $slug = $baseSlug;
        $originalSlug = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        // Determine type: inherit from parent if it's a subcategory
        $type = $request->type;
        if ($request->parent_id) {
            $parent = Category::find($request->parent_id);
            if ($parent) {
                $type = $parent->type;
            }
        }

        Category::create([
            'name'        => $request->name,
            'type'        => $type ?? 'post',
            'description' => $request->description,
            'slug'        => $slug,
            'parent_id'   => $request->parent_id ?: null,
            'status'      => $request->status,
        ]);

        $message = $request->parent_id ? 'Sub-category added successfully!' : 'Category added successfully!';
        $route = $request->parent_id ? 'admin.sub-categories.index' : 'admin.categories.index';

        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Update an existing category
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'type'        => 'nullable|string|in:post,page,gallery,video|max:100', // Nullable for subcategory edit
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
        ]);

        // Recalculate slug if user provided a new one or name changed and slug not manually set
        if ($request->filled('slug')) {
            $baseSlug = $this->makeSlug($request->slug);
        } elseif ($category->name !== $request->name) {
            $baseSlug = $this->makeSlug($request->name);
        } else {
            $baseSlug = null;
        }

        if ($baseSlug !== null) {
            $slug = $baseSlug;
            $originalSlug = $slug;
            $i = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
            $category->slug = $slug;
        }

        $category->name        = $request->name;
        // Only update type if it's a parent category or provided
        if (!$category->parent_id && $request->filled('type')) {
            $category->type = $request->type;
        }
        $category->description = $request->description;
        $category->status      = $request->status;
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Delete a category (and its subcategories cascade)
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    /**
     * Build a slug that keeps Unicode letters (e.g. Bangla) and normalizes spaces/dashes.
     */
    private function makeSlug(string $value): string
    {
        $slug = trim($value);
        // Replace any whitespace with single dash
        $slug = preg_replace('/\s+/u', '-', $slug);
        // Collapse multiple dashes
        $slug = preg_replace('/-+/u', '-', $slug);
        // Trim leading/trailing dashes
        $slug = trim($slug, '-');

        return mb_strtolower($slug, 'UTF-8');
    }
}
