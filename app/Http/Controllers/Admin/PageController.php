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
    public function index(): View
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'page')->where('status', 'active')->orderBy('name')->get();
        return view('admin.pages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'      => 'required|in:active,inactive',
        ]);

        // Unique slug
        $slug = Str::slug($request->title);
        $base = $slug;
        $i = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $data = [
            'category_id' => $request->category_id,
            'title'       => $request->title,
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
            'title'       => 'required|string|max:255',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'      => 'required|in:active,inactive',
        ]);

        $page->category_id = $request->category_id;
        $page->title       = $request->title;
        $page->content     = $request->content;
        $page->status      = $request->status;

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
