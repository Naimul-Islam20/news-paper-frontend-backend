<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdvertisementController extends Controller
{
    public function index(): View
    {
        $advertisements = Advertisement::orderBy('slug')->get();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function edit(int $id): View
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('admin.advertisements.edit', compact('advertisement'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);

        $isVideoSlot = $advertisement->slug === 'home_video';

        $request->validate([
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link'    => 'nullable|url|max:500',
            'caption' => 'nullable|string|max:500',
            'video_youtube_id' => 'nullable|string|max:500',
        ]);

        if ($isVideoSlot) {
            $data = [];
            $videoRaw = $request->input('video_youtube_id');
            if ($videoRaw !== null && $videoRaw !== '') {
                $videoRaw = trim($videoRaw);
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $videoRaw, $m)) {
                    $data['video_youtube_id'] = $m[1];
                } else {
                    $data['video_youtube_id'] = strlen($videoRaw) <= 20 ? $videoRaw : null;
                }
            } else {
                $data['video_youtube_id'] = null;
            }
        } else {
            $data = [
                'link'    => $request->input('link'),
                'caption' => $request->input('caption'),
            ];

            if ($request->filled('remove_image') && $advertisement->image) {
                if (Storage::disk('public')->exists($advertisement->image)) {
                    Storage::disk('public')->delete($advertisement->image);
                }
                $data['image'] = null;
            } elseif ($request->hasFile('image')) {
                if ($advertisement->image && Storage::disk('public')->exists($advertisement->image)) {
                    Storage::disk('public')->delete($advertisement->image);
                }
                $data['image'] = $request->file('image')->store('advertisements', 'public');
            }
        }

        $advertisement->update($data);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'অ্যাড স্লট আপডেট করা হয়েছে।');
    }
}
