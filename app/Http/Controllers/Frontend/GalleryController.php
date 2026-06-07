<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::with(['images', 'category'])->where('status', 'active')->latest()->paginate(12);
        return view('frontend.gallery', compact('galleries'));
    }

    public function show(string $slug): View
    {
        $gallery = Gallery::with(['images', 'category', 'reporter'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $related = Gallery::with('images')
            ->where('id', '!=', $gallery->id)
            ->where('status', 'active')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.gallery-details', compact('gallery', 'related'));
    }
}
