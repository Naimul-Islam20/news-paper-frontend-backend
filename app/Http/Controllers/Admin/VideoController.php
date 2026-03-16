<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Reporter;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function index(Request $request): View
    {
        $baseQuery = Video::with('category')->latest();

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

        $videos = $query->paginate(10)->withQueryString();

        return view('admin.videos.index', compact('videos'));
    }

    public function create(): View
    {
        $categories = Category::where('type', 'video')->where('status', 'active')->orderBy('name')->get();
        $reporters = $this->reportersForCurrentUser();
        return view('admin.videos.create', compact('categories', 'reporters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'reporter_id'  => 'required|exists:reporters,id',
            'title'        => 'required|string|max:255',
            'youtube_link' => 'required|url',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'description'  => 'nullable|string',
            'status'       => 'required|in:active,inactive',
            'is_main_video'=> 'required|in:yes,no',
        ]);

        $data = [
            'category_id'   => $request->category_id,
            'reporter_id'   => $this->resolveReporterId($request->reporter_id),
            'title'         => $request->title,
            'slug'          => Str::slug($request->title),
            'youtube_link'  => $request->youtube_link,
            'description'   => $request->description,
            'status'        => $request->status,
            'is_main_video' => $request->is_main_video,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('videos', 'public');
        }

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully!');
    }

    public function edit($id): View
    {
        $video = Video::findOrFail($id);
        $categories = Category::where('type', 'video')->where('status', 'active')->orderBy('name')->get();
        $reporters = Reporter::where('status', 'active')->orderBy('name')->get();
        return view('admin.videos.edit', compact('video', 'categories', 'reporters'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);

        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'reporter_id'  => 'required|exists:reporters,id',
            'title'        => 'required|string|max:255',
            'youtube_link' => 'required|url',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'description'  => 'nullable|string',
            'status'       => 'required|in:active,inactive',
            'is_main_video'=> 'required|in:yes,no',
        ]);

        $video->category_id   = $request->category_id;
        $video->reporter_id   = $this->resolveReporterId($request->reporter_id);
        $video->title         = $request->title;
        $video->slug          = Str::slug($request->title);
        $video->youtube_link  = $request->youtube_link;
        $video->description   = $request->description;
        $video->status        = $request->status;
        $video->is_main_video = $request->is_main_video;

        if ($request->hasFile('image')) {
            if ($video->image) {
                Storage::disk('public')->delete($video->image);
            }
            $video->image = $request->file('image')->store('videos', 'public');
        }

        $video->save();

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully!');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if ($video->image) {
            Storage::disk('public')->delete($video->image);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully!');
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
