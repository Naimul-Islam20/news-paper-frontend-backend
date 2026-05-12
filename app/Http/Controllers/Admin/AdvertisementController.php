<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementQueueItem;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
        $advertisement = Advertisement::with([
            'queueItems' => fn ($q) => $q->whereNull('expired_at')->orderBy('sort_order')->orderBy('id'),
        ])->findOrFail($id);

        AdvertisementQueueItem::reconcileExpiredForAdvertisementId((int) $advertisement->id);

        $queueItems = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereNull('expired_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $liveQueueItem = $advertisement->currentRotatingQueueItem();
        $liveQueueIndex = null;
        if ($liveQueueItem) {
            $idx = $queueItems->search(fn (AdvertisementQueueItem $i) => $i->id === $liveQueueItem->id);
            $liveQueueIndex = $idx === false ? null : (int) $idx;
        }
        $queueItemsWaiting = $liveQueueItem
            ? $queueItems->reject(fn (AdvertisementQueueItem $i) => $i->id === $liveQueueItem->id)->values()
            : $queueItems;

        $expiredQueueItems = AdvertisementQueueItem::query()
            ->where('advertisement_id', $advertisement->id)
            ->whereNotNull('expired_at')
            ->orderByDesc('expired_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.advertisements.edit', compact(
            'advertisement',
            'queueItems',
            'queueItemsWaiting',
            'liveQueueItem',
            'liveQueueIndex',
            'expiredQueueItems',
        ));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $advertisement = Advertisement::findOrFail($id);

        $isVideoSlot = $advertisement->slug === 'home_video';

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'required|url|max:500',
            'caption' => 'nullable|string|max:500',
            'video_youtube_id' => 'nullable|string|max:500',
            'slot_duration_days' => 'required|integer|min:0|max:365',
            'slot_duration_hours' => 'required|integer|min:0|max:23',
        ]);

        if ($isVideoSlot) {
            $data = [];
            $data['video_youtube_id'] = $this->normalizeYoutubeId($request->input('video_youtube_id'));
            $data['link'] = $request->input('link');
        } else {
            $data = [
                'link' => $request->input('link'),
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
        $isVideoSlot = $advertisement->slug === 'home_video';

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'required|url|max:500',
            'caption' => 'nullable|string|max:500',
            'video_youtube_id' => 'nullable|string|max:500',
            'duration_days' => 'required|integer|min:0|max:365',
            'duration_hours' => 'required|integer|min:0|max:23',
        ]);
        if (((int) $request->input('duration_days', 0)) + ((int) $request->input('duration_hours', 0)) === 0) {
            return redirect()->back()
                ->withErrors(['duration_hours' => 'কমপক্ষে ১ ঘণ্টা বা ১ দিন মেয়াদ দিন।'])
                ->withInput();
        }

        if ($isVideoSlot) {
            $videoId = $this->normalizeYoutubeId($request->input('video_youtube_id'));
            if ($videoId === null || $videoId === '') {
                return redirect()->back()
                    ->withErrors(['video_youtube_id' => 'YouTube ভিডিও ID বা URL দিন।'])
                    ->withInput();
            }
            $data = [
                'advertisement_id' => $advertisement->id,
                'title' => $request->input('title'),
                'video_youtube_id' => $videoId,
                'link' => $request->input('link'),
                'image' => null,
                'image_mobile' => null,
                'caption' => null,
            ];
        } else {
            if (! $request->hasFile('image')) {
                return redirect()->back()
                    ->withErrors(['image' => 'কিউ আইটেমের জন্য ডেস্কটপ ইমেজ আপলোড করুন।'])
                    ->withInput();
            }
            $data = [
                'advertisement_id' => $advertisement->id,
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'caption' => $request->input('caption'),
                'image' => store_public_upload($request->file('image'), 'advertisements'),
                'image_mobile' => $request->hasFile('image_mobile')
                    ? store_public_upload($request->file('image_mobile'), 'advertisements')
                    : null,
                'video_youtube_id' => null,
            ];
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

        $isVideoSlot = $advertisement->slug === 'home_video';

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'link' => 'required|url|max:500',
            'caption' => 'nullable|string|max:500',
            'video_youtube_id' => 'nullable|string|max:500',
            'duration_days' => 'required|integer|min:0|max:365',
            'duration_hours' => 'required|integer|min:0|max:23',
        ]);
        if (((int) $request->input('duration_days', 0)) + ((int) $request->input('duration_hours', 0)) === 0) {
            return redirect()->back()
                ->withErrors(['duration_hours' => 'কমপক্ষে ১ ঘণ্টা বা ১ দিন মেয়াদ দিন।'])
                ->withInput();
        }

        if ($isVideoSlot) {
            $videoId = $this->normalizeYoutubeId($request->input('video_youtube_id'));
            if ($videoId === null || $videoId === '') {
                return redirect()->back()
                    ->withErrors(['video_youtube_id' => 'YouTube ভিডিও ID বা URL দিন।'])
                    ->withInput();
            }
            $data = [
                'title' => $request->input('title'),
                'video_youtube_id' => $videoId,
                'link' => $request->input('link'),
            ];
        } else {
            $data = [
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'caption' => $request->input('caption'),
            ];

            if ($request->filled('remove_image') && $item->image) {
                delete_uploaded_media($item->image);
                $data['image'] = null;
            } elseif ($request->hasFile('image')) {
                delete_uploaded_media($item->image);
                $data['image'] = store_public_upload($request->file('image'), 'advertisements');
            }

            if ($request->filled('remove_image_mobile') && $item->image_mobile) {
                delete_uploaded_media($item->image_mobile);
                $data['image_mobile'] = null;
            } elseif ($request->hasFile('image_mobile')) {
                delete_uploaded_media($item->image_mobile);
                $data['image_mobile'] = store_public_upload($request->file('image_mobile'), 'advertisements');
            }

            $finalDesktop = array_key_exists('image', $data) ? $data['image'] : $item->image;
            if (! filled($finalDesktop)) {
                return redirect()->back()
                    ->withErrors(['image' => 'ডেস্কটপ ইমেজ থাকতে হবে (আপলোড করুন)।'])
                    ->withInput();
            }
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

        delete_uploaded_media($item->image);
        delete_uploaded_media($item->image_mobile);
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
