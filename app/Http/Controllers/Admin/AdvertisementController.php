<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementQueueItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        Advertisement::archiveExpiredSlotForId((int) $advertisement->id);
        $advertisement->refresh();

        AdvertisementQueueItem::reconcileExpiredForAdvertisementId((int) $advertisement->id);

        $queueItems = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereNull('expired_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $expiredAds = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereNotNull('expired_at')
            ->orderByDesc('expired_at')
            ->orderByDesc('id')
            ->get();

        $slotFormDisplay = $advertisement->isWithinSlotScheduleWindow() ? $advertisement : null;

        $liveQueueItem = $advertisement->findQueueItemForFrontDisplayMerge();

        return view('admin.advertisements.edit', compact(
            'advertisement',
            'slotFormDisplay',
            'queueItems',
            'expiredAds',
            'liveQueueItem',
        ));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate(array_merge($this->mediaValidationRules(), [
            'slot_duration_days' => 'required|integer|min:0|max:365',
            'slot_duration_hours' => 'required|integer|min:0|max:23',
        ]));

        $data = [
            'link' => $request->input('link'),
            'caption' => $request->input('caption'),
        ];

        if ($mediaError = $this->applyMediaFromRequest($request, $data, $advertisement, requireMedia: true)) {
            return $mediaError;
        }

        $days = min(365, max(0, (int) $request->input('slot_duration_days', 0)));
        $hours = min(23, max(0, (int) $request->input('slot_duration_hours', 0)));

        if ($days + $hours === 0) {
            return redirect()->back()
                ->withErrors(['slot_duration_hours' => 'কমপক্ষে ১ ঘণ্টা বা ১ দিন মেয়াদ দিতে হবে। নইলে সংরক্ষণ হবে না এবং ফ্রন্টে অ্যাড দেখাবে না।'])
                ->withInput();
        }

        $data['starts_at'] = now();
        $data['ends_at'] = now()->copy()->addDays($days)->addHours($hours);

        $advertisement->update($data);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'অ্যাড স্লট আপডেট করা হয়েছে।');
    }

    public function storeQueueItem(Request $request, int $id): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate(array_merge($this->mediaValidationRules(), [
            'title' => 'nullable|string|max:255',
            'duration_days' => 'required|integer|min:0|max:365',
            'duration_hours' => 'required|integer|min:0|max:23',
        ]));
        if (((int) $request->input('duration_days', 0)) + ((int) $request->input('duration_hours', 0)) === 0) {
            return redirect()->back()
                ->withErrors(['duration_hours' => 'কমপক্ষে ১ ঘণ্টা বা ১ দিন মেয়াদ দিন।'])
                ->withInput();
        }

        $data = [
            'advertisement_id' => $advertisement->id,
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'caption' => $request->input('caption'),
        ];

        if ($mediaError = $this->applyMediaFromRequest($request, $data, null, requireMedia: true)) {
            return $mediaError;
        }

        $data = array_merge($data, $this->queueItemDurationFromRequest($request));

        // নতুন আইটেম কিউর শীর্ষে — ফ্রন্টে `applyQueueItemDisplayOverride` sort অনুযায়ী প্রথমটি মিলায়; শেষে যোগ করলে পুরনো সারি সবসময় আগে থাকত।
        DB::transaction(function () use ($advertisement, $data): void {
            AdvertisementQueueItem::query()
                ->where('advertisement_id', $advertisement->id)
                ->whereNull('expired_at')
                ->increment('sort_order');

            $data['sort_order'] = 1;
            AdvertisementQueueItem::query()->create($data);
        });

        return redirect()
            ->route('admin.advertisements.edit', $advertisement->id)
            ->with('success', 'কিউতে নতুন অ্যাড যোগ করা হয়েছে (সবার উপরে — ফ্রন্টে এটিই আগে দেখাবে)।');
    }

    public function updateQueueItem(Request $request, int $id, int $itemId): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);
        $item = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereKey($itemId)
            ->firstOrFail();

        $request->validate(array_merge($this->mediaValidationRules(), [
            'title' => 'nullable|string|max:255',
            'duration_days' => 'required|integer|min:0|max:365',
            'duration_hours' => 'required|integer|min:0|max:23',
        ]));
        if (((int) $request->input('duration_days', 0)) + ((int) $request->input('duration_hours', 0)) === 0) {
            return redirect()->back()
                ->withErrors(['duration_hours' => 'কমপক্ষে ১ ঘণ্টা বা ১ দিন মেয়াদ দিন।'])
                ->withInput();
        }

        $data = [
            'title' => $request->input('title'),
            'link' => $request->input('link'),
            'caption' => $request->input('caption'),
        ];

        if ($mediaError = $this->applyMediaFromRequest($request, $data, $item, requireMedia: true)) {
            return $mediaError;
        }

        $data = array_merge($data, $this->queueItemDurationFromRequest($request));

        $item->update($data);

        return redirect()
            ->route('admin.advertisements.edit', $advertisement->id)
            ->with('success', 'কিউ আইটেম আপডেট করা হয়েছে।');
    }

    public function destroyQueueItem(int $id, int $itemId): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);
        $item = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereKey($itemId)
            ->firstOrFail();

        $this->deleteAllMediaPaths($item);
        $item->delete();

        $this->renumberQueueSortOrder($advertisement->id);

        return redirect()
            ->route('admin.advertisements.edit', $advertisement->id)
            ->with('success', 'কিউ আইটেম মুছে ফেলা হয়েছে।');
    }

    public function reorderQueueItems(Request $request, int $id): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:advertisement_queue_items,id',
        ]);

        /** @var array<int, int> $order */
        $order = array_values(array_map('intval', $request->input('order', [])));
        $expected = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereNull('expired_at')
            ->orderBy('id')
            ->pluck('id')
            ->map(fn (int|string $v) => (int) $v)
            ->sort()
            ->values()
            ->all();
        $sortedSubmitted = $order;
        sort($sortedSubmitted);

        if ($sortedSubmitted !== $expected || count($order) !== count($expected)) {
            return redirect()->back()->withErrors(['order' => 'অবৈধ ক্রম।']);
        }

        foreach ($order as $index => $itemId) {
            AdvertisementQueueItem::query()->whereKey($itemId)->update(['sort_order' => $index]);
        }

        return redirect()
            ->route('admin.advertisements.edit', $advertisement->id)
            ->with('success', 'কিউ ক্রম আপডেট করা হয়েছে।');
    }

    /**
     * @return array<string, string>
     */
    protected function mediaValidationRules(): array
    {
        return [
            'media_type' => 'required|in:image,video,youtube',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,mov,ogv,quicktime|max:51200',
            'video_mobile' => 'nullable|file|mimes:mp4,webm,mov,ogv,quicktime|max:51200',
            'link' => 'required|url|max:500',
            'caption' => 'nullable|string|max:500',
            'video_youtube_id' => 'nullable|string|max:500',
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function applyMediaFromRequest(Request $request, array &$data, Advertisement|AdvertisementQueueItem|null $existing, bool $requireMedia): ?RedirectResponse
    {
        $type = $request->input('media_type', $existing?->resolvedMediaType() ?? 'image');

        if ($type === 'youtube') {
            $videoId = $this->normalizeYoutubeId($request->input('video_youtube_id'));
            if (! filled($videoId)) {
                return redirect()->back()
                    ->withErrors(['video_youtube_id' => 'YouTube ভিডিও ID বা URL দিন।'])
                    ->withInput();
            }
            if ($existing) {
                $this->clearImageMedia($existing, $data);
                $this->clearVideoMedia($existing, $data);
            } else {
                $data['image'] = null;
                $data['image_mobile'] = null;
                $data['video'] = null;
                $data['video_mobile'] = null;
            }
            $data['video_youtube_id'] = $videoId;
            $data['caption'] = $request->input('caption');

            return null;
        }

        if ($type === 'video') {
            $hasNewDesktop = $request->hasFile('video');
            $removingDesktop = $request->boolean('remove_video');
            $finalDesktop = $existing?->video;
            if ($request->hasFile('video')) {
                if ($existing?->video) {
                    delete_uploaded_media($existing->video);
                }
                $data['video'] = store_public_upload($request->file('video'), 'advertisements');
                $finalDesktop = $data['video'];
            } elseif ($removingDesktop && $existing?->video) {
                delete_uploaded_media($existing->video);
                $data['video'] = null;
                $finalDesktop = null;
            }

            if ($request->filled('remove_video_mobile') && $existing?->video_mobile) {
                delete_uploaded_media($existing->video_mobile);
                $data['video_mobile'] = null;
            } elseif ($request->hasFile('video_mobile')) {
                delete_uploaded_media($existing?->video_mobile);
                $data['video_mobile'] = store_public_upload($request->file('video_mobile'), 'advertisements');
            }

            if ($requireMedia && ! filled($finalDesktop) && ! $request->hasFile('video_mobile')) {
                return redirect()->back()
                    ->withErrors(['video' => 'ডেস্কটপ ভিডিও ফাইল আপলোড করুন।'])
                    ->withInput();
            }

            if ($existing) {
                $this->clearImageMedia($existing, $data);
            } else {
                $data['image'] = null;
                $data['image_mobile'] = null;
            }
            $data['video_youtube_id'] = null;
            $data['caption'] = $request->input('caption');

            return null;
        }

        // image / gif
        $hasNewDesktop = $request->hasFile('image');
        $removingDesktop = $request->boolean('remove_image');
        $finalDesktop = $existing?->image;
        if ($request->hasFile('image')) {
            delete_uploaded_media($existing?->image);
            $data['image'] = store_public_upload($request->file('image'), 'advertisements');
            $finalDesktop = $data['image'];
        } elseif ($removingDesktop && $existing?->image) {
            delete_uploaded_media($existing->image);
            $data['image'] = null;
            $finalDesktop = null;
        }

        if ($request->filled('remove_image_mobile') && $existing?->image_mobile) {
            delete_uploaded_media($existing->image_mobile);
            $data['image_mobile'] = null;
        } elseif ($request->hasFile('image_mobile')) {
            delete_uploaded_media($existing?->image_mobile);
            $data['image_mobile'] = store_public_upload($request->file('image_mobile'), 'advertisements');
        }

        if ($requireMedia && ! filled($finalDesktop)) {
            return redirect()->back()
                ->withErrors(['image' => 'ডেস্কটপ ইমেজ বা GIF আপলোড করুন।'])
                ->withInput();
        }

        if ($existing) {
            $this->clearVideoMedia($existing, $data);
        } else {
            $data['video'] = null;
            $data['video_mobile'] = null;
        }
        $data['video_youtube_id'] = null;
        $data['caption'] = $request->input('caption');

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function clearImageMedia(Advertisement|AdvertisementQueueItem $existing, array &$data): void
    {
        if ($existing->image) {
            delete_uploaded_media($existing->image);
        }
        if ($existing->image_mobile) {
            delete_uploaded_media($existing->image_mobile);
        }
        $data['image'] = null;
        $data['image_mobile'] = null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function clearVideoMedia(Advertisement|AdvertisementQueueItem $existing, array &$data): void
    {
        if ($existing->video) {
            delete_uploaded_media($existing->video);
        }
        if ($existing->video_mobile) {
            delete_uploaded_media($existing->video_mobile);
        }
        $data['video'] = null;
        $data['video_mobile'] = null;
    }

    protected function deleteAllMediaPaths(Advertisement|AdvertisementQueueItem $model): void
    {
        delete_uploaded_media($model->image);
        delete_uploaded_media($model->image_mobile);
        delete_uploaded_media($model->video);
        delete_uploaded_media($model->video_mobile);
    }

    protected function normalizeYoutubeId(mixed $videoRaw): ?string
    {
        if ($videoRaw === null || $videoRaw === '') {
            return null;
        }
        $videoRaw = trim((string) $videoRaw);
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $videoRaw, $m)) {
            return $m[1];
        }

        return strlen($videoRaw) <= 20 ? $videoRaw : null;
    }

    /**
     * @return array{duration_days: int, duration_hours: int, starts_at: null, ends_at: null}
     */
    protected function queueItemDurationFromRequest(Request $request): array
    {
        $days = min(365, max(0, (int) $request->input('duration_days', 0)));
        $hours = min(23, max(0, (int) $request->input('duration_hours', 0)));

        return [
            'duration_days' => $days,
            'duration_hours' => $hours,
            'starts_at' => null,
            'ends_at' => null,
        ];
    }

    protected function renumberQueueSortOrder(int $advertisementId): void
    {
        $ids = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisementId)
            ->whereNull('expired_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id');
        foreach ($ids as $index => $itemId) {
            AdvertisementQueueItem::query()->whereKey($itemId)->update(['sort_order' => $index]);
        }
    }
}
