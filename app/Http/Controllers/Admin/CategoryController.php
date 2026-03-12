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
            'type'        => 'nullable|string|in:post,page,gallery,video|max:100', // Type is nullable because subcategory inherits it
            'description' => 'nullable|string|max:500',
            'parent_id'   => 'nullable|exists:categories,id',
            'status'      => 'required|in:active,inactive',
        ]);

        // Auto-generate unique slug
        $slug = Str::slug($request->name);
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
            'type'        => 'nullable|string|in:post,page,gallery,video|max:100', // Nullable for subcategory edit
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
        ]);

        // Recalculate slug if name changed
        if ($category->name !== $request->name) {
            $slug = Str::slug($request->name);
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
}
