<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Page::latest();

        $query = clone $baseQuery;

        if ($request->filled('search')) {
            $search = trim($request->search);

            if ($search !== '' && ctype_digit($search)) {
                $serial = (int) $search;

                if ($serial > 0) {
                    $target = (clone $baseQuery)
                        ->skip($serial - 1)
                        ->take(1)
                        ->first();

                    if ($target) {
                        $query->whereKey($target->id);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                }
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('slug', 'like', '%' . $search . '%');
                });
            }
        }

        $pages = $query->paginate(10)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        // For new pages, only show page-type categories that don't already
        // have a page assigned, so one category => one static page.
        $usedCategoryIds = Page::pluck('category_id')
            ->filter()
            ->unique()
            ->toArray();

        $categories = Category::where('type', 'page')
            ->where('status', 'active')
            ->when(!empty($usedCategoryIds), function ($query) use ($usedCategoryIds) {
                $query->whereNotIn('id', $usedCategoryIds);
            })
            ->orderBy('name')
            ->get();

        return view('admin.pages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'      => 'required|in:active,inactive',
        ]);

        // Slug will be based on the selected category (page-type category),
        // so that each page URL matches its category.
        $category = Category::findOrFail($request->category_id);
        $slug = $category->slug ?: Str::slug($category->name);

        $data = [
            'category_id' => $request->category_id,
            // If title is not provided, fall back to category name
            'title'       => $request->title ?: $category->name,
            'slug'        => $slug,
            'content'     => $request->content,
            'status'      => $request->status,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    public function edit($id): View
    {
        $page = Page::findOrFail($id);
        $categories = Category::where('type', 'page')->where('status', 'active')->orderBy('name')->get();
        return view('admin.pages.edit', compact('page', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'nullable|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'      => 'required|in:active,inactive',
        ]);

        $page->category_id = $request->category_id;
        $page->content     = $request->content;
        $page->status      = $request->status;

        // Keep slug in sync with page category so that
        // /page/{slug} always matches the category slug.
        $category = Category::findOrFail($request->category_id);
        $page->slug = $category->slug ?: Str::slug($category->name);
        // If title left empty, fall back to category name
        $page->title = $request->title ?: $category->name;

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $page->image = $request->file('image')->store('pages', 'public');
        }

        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }
}
