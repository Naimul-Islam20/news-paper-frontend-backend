<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Reporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::with('images')->latest()->paginate(10);
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

        // Create the Gallery
        $gallery = Gallery::create([
            'category_id' => $request->category_id,
            'reporter_id' => $this->resolveReporterId($request->reporter_id),
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
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
        $gallery->slug        = Str::slug($request->title);
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
        $user = auth()->user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return Reporter::where('id', $user->reporter_id)->get();
        }
        return Reporter::where('status', 'active')->orderBy('name')->get();
    }

    protected function resolveReporterId($requestReporterId)
    {
        $user = auth()->user();
        if ($user && $user->role === 'reporter' && $user->reporter_id) {
            return $user->reporter_id;
        }
        return $requestReporterId;
    }
}
