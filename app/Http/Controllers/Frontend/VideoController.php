<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function show(string $slug): View
    {
        $video = Video::with(['category', 'reporter'])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $related = Video::where('id', '!=', $video->id)
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.video-details', compact('video', 'related'));
    }
}
