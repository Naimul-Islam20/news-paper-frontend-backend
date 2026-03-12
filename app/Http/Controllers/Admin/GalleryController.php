<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryImage;
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
        return view('admin.galleries.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
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
        return view('admin.galleries.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'images'      => 'nullable|array',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'image_desc'  => 'nullable|array',
            'image_desc.*'=> 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        $gallery->category_id = $request->category_id;
        $gallery->title       = $request->title;
        $gallery->slug        = Str::slug($request->title);
        $gallery->description = $request->description;
        $gallery->status      = $request->status;
        $gallery->save();

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
}
