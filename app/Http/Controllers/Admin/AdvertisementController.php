<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link'         => 'nullable|url|max:500',
            'caption'      => 'nullable|string|max:500',
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
                delete_uploaded_media($advertisement->image);
                $data['image'] = null;
            } elseif ($request->hasFile('image')) {
                delete_uploaded_media($advertisement->image);
                $data['image'] = store_public_upload($request->file('image'), 'advertisements');
            }

            if ($request->filled('remove_image_mobile') && $advertisement->image_mobile) {
                delete_uploaded_media($advertisement->image_mobile);
                $data['image_mobile'] = null;
            } elseif ($request->hasFile('image_mobile')) {
                delete_uploaded_media($advertisement->image_mobile);
                $data['image_mobile'] = store_public_upload($request->file('image_mobile'), 'advertisements');
            }
        }

        $advertisement->update($data);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'অ্যাড স্লট আপডেট করা হয়েছে।');
    }
}
