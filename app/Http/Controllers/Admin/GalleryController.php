<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Gallery::with('images')->latest();

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
                $query->where('title', 'like', '%' . $search . '%');
            }
        }

        $galleries = $query->paginate(10)->withQueryString();

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'gallery')->where('status', 'active')->orderBy('name')->get();
        $reporters = $this->reportersForCurrentUser();
        return view('admin.galleries.create', compact('categories', 'reporters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'reporter_id' => 'required|exists:reporters,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'images'      => 'required|array|min:1',
            'images.*'    => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_desc'  => 'nullable|array',
            'image_desc.*'=> 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $baseSlug = Str::slug($request->title);
        $slug = $this->makeUniqueSlug($baseSlug);

        // Create the Gallery
        $gallery = Gallery::create([
            'category_id' => $request->category_id,
            'reporter_id' => $this->resolveReporterId($request->reporter_id),
            'title'       => $request->title,
            'slug'        => $slug,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        // Save each image to gallery_images
        $images = $request->file('images');
        $descriptions = $request->input('image_desc', []);

        foreach ($images as $index => $image) {
            GalleryImage::create([
                'gallery_id'  => $gallery->id,
                'image'       => $image->store('galleries', 'public'),
                'description' => $descriptions[$index] ?? null,
            ]);
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery created successfully!');
    }

    public function edit($id): View
    {
        $gallery = Gallery::with('images')->findOrFail($id);
        $categories = Category::where('type', 'gallery')->where('status', 'active')->orderBy('name')->get();
        $reporters = $this->reportersForCurrentUser();
        return view('admin.galleries.edit', compact('gallery', 'categories', 'reporters'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_desc'  => 'nullable|array',
            'image_desc.*'=> 'nullable|string',
            'existing_image_desc' => 'nullable|array',
            'existing_image_desc.*' => 'nullable|string',
            'existing_image' => 'nullable|array',
            'existing_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'reporter_id' => 'required|exists:reporters,id',
            'status'      => 'required|in:active,inactive',
        ]);

        $gallery->category_id = $request->category_id;
        $gallery->reporter_id = $this->resolveReporterId($request->reporter_id);
        $gallery->title       = $request->title;
        $baseSlug = Str::slug($request->title);
        $gallery->slug        = $this->makeUniqueSlug($baseSlug, $gallery->id);
        $gallery->description = $request->description;
        $gallery->status      = $request->status;
        $gallery->save();

        // Update existing images: description + optional image replace
        $existingDescs = $request->input('existing_image_desc', []);
        $existingFiles = $request->file('existing_image', []);

        foreach ($gallery->images as $img) {
            $id = $img->id;
            if (array_key_exists($id, $existingDescs)) {
                $img->description = $existingDescs[$id] ?: null;
            }
            if (!empty($existingFiles[$id])) {
                Storage::disk('public')->delete($img->image);
                $img->image = $existingFiles[$id]->store('galleries', 'public');
            }
            $img->save();
        }

        // Add new images if uploaded
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $descriptions = $request->input('image_desc', []);

            foreach ($images as $index => $image) {
                GalleryImage::create([
                    'gallery_id'  => $gallery->id,
                    'image'       => $image->store('galleries', 'public'),
                    'description' => $descriptions[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::with('images')->findOrFail($id);

        // Delete all associated images from storage
        foreach ($gallery->images as $img) {
            Storage::disk('public')->delete($img->image);
        }

        $gallery->delete(); // cascade deletes gallery_images rows

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted successfully!');
    }

    public function destroyImage($imageId)
    {
        $image = GalleryImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image removed successfully!');
    }

    protected function reportersForCurrentUser()
    {
        $user = Auth::user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return Reporter::where('id', $user->reporter_id)->get();
        }
        return Reporter::where('status', 'active')->orderBy('name')->get();
    }

    protected function resolveReporterId($requestReporterId)
    {
        $user = Auth::user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return $user->reporter_id;
        }
        return $requestReporterId;
    }

    /**
     * Make slug unique for `galleries.slug` (DB column has UNIQUE constraint).
     * Example: `my-slug` exists -> `my-slug-1`, `my-slug-2`, ...
     */
    protected function makeUniqueSlug(string $baseSlug, ?int $excludeId = null): string
    {
        $baseSlug = trim($baseSlug);
        if ($baseSlug === '') {
            $baseSlug = 'gallery';
        }

        $candidate = $baseSlug;
        $i = 1;

        while (
            Gallery::query()
                ->where('slug', $candidate)
                ->when($excludeId !== null, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $candidate = $baseSlug . '-' . $i;
            $i++;
        }

        return $candidate;
    }
}
