<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advertisement extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'image',
        'image_mobile',
        'link',
        'caption',
        'video_youtube_id',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    /**
     * ফ্রন্ট/API: স্লটের ক্যালেন্ডার উইন্ডোর মধ্যে, অথবা উইন্ডো শেষ হয়ে গেলেও কিউতে অপেক্ষমান আইটেম থাকলে।
     */
    public function scopeActiveForDisplay(Builder $query): Builder
    {
        $now = now();

        return $query
            ->whereNotNull('starts_at')
            ->whereNotNull('ends_at')
            ->where(function (Builder $q) use ($now) {
                $q->where(function (Builder $w) use ($now) {
                    $w->where('starts_at', '<=', $now)
                        ->where('ends_at', '>=', $now);
                })->orWhere(function (Builder $w) use ($now) {
                    $w->where('ends_at', '<', $now)
                        ->whereHas('queueItems', function (Builder $qi) {
                            $qi->whereNull('expired_at');
                        });
                });
            });
    }

    public function isActiveForDisplay(): bool
    {
        if (! $this->starts_at || ! $this->ends_at) {
            return false;
        }

        $now = now();
        if ($this->starts_at->gt($now)) {
            return false;
        }

        if ($this->ends_at->gte($now)) {
            return true;
        }

        return $this->hasActiveQueueItems();
    }

    /** অপেক্ষমান (মেয়াদ শেষ নয় এমন) কিউ আইটেম আছে কিনা */
    public function hasActiveQueueItems(): bool
    {
        return $this->queueItems()->whereNull('expired_at')->exists();
    }

    /** মূল স্লট ফর্মের ক্যালেন্ডার উইন্ডো এখন চলছে কিনা (এই সময় কিউ ফ্রন্টে মিলাব না) */
    public function isWithinSlotScheduleWindow(): bool
    {
        if (! $this->starts_at || ! $this->ends_at) {
            return false;
        }

        $now = now();

        return $this->starts_at->lte($now) && $this->ends_at->gte($now);
    }

    public function queueItems(): HasMany
    {
        return $this->hasMany(AdvertisementQueueItem::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * অ্যাডমিন/ড্যাশবোর্ড: ফ্রন্টে এখন কোন কিউ আইটেমের মেয়াদ চলছে (মিউটেশন ছাড়া)।
     * স্লটের ক্যালেন্ডার উইন্ডো চলাকালীন ফ্রন্টে কিউ মিলে না — এখানেও null যেন একই সময়ে দুই স্তর «চলছে» না দেখায়।
     */
    public function currentRotatingQueueItem(): ?AdvertisementQueueItem
    {
        if ($this->isWithinSlotScheduleWindow()) {
            return null;
        }

        $items = AdvertisementQueueItem::query()
            ->where('advertisement_id', $this->id)
            ->whereNull('expired_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $isVideo = $this->slug === 'home_video';

        foreach ($items as $i => $item) {
            $next = $items[$i + 1] ?? null;

            if ($isVideo) {
                if (! filled($item->video_youtube_id)) {
                    continue;
                }
            } elseif (! filled($item->image)) {
                continue;
            }

            if ($item->starts_at && $item->starts_at->gt(now())) {
                continue;
            }

            if ($item->usesDurationRotation()) {
                if (! $item->display_started_at) {
                    continue;
                }
                $end = $item->displayRunEndsAt();
                if (! $end || now()->gte($end)) {
                    continue;
                }

                return $item;
            }

            if (! $item->isLiveInQueuedRotation($next)) {
                continue;
            }

            return $item;
        }

        return null;
    }

    /**
     * একই স্লটে কিউ: দিন+ঘণ্টা মেয়াদ শেষ হলে পরের অ্যাড replace; প্রথম দেখানোর সময় থেকে মেয়াদ গণনা।
     * পুরনো ক্যালেন্ডার-মাত্র আইটেম (দিন/ঘণ্টা ০) আগের isLiveInQueuedRotation লজিক।
     */
    public function applyQueueItemDisplayOverride(): void
    {
        AdvertisementQueueItem::reconcileExpiredForAdvertisementId((int) $this->id);

        // স্লটের উপরের সময়সূচি উইন্ডো চলাকালীন ফ্রন্টে শুধু মূল স্লট (ফর্ম) এর ডেটা; কিউ এখানে মিলবে না।
        if ($this->isWithinSlotScheduleWindow()) {
            return;
        }

        $items = AdvertisementQueueItem::query()
            ->where('advertisement_id', $this->id)
            ->whereNull('expired_at')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $isVideo = $this->slug === 'home_video';

        foreach ($items as $i => $item) {
            $next = $items[$i + 1] ?? null;

            if ($isVideo) {
                if (! filled($item->video_youtube_id)) {
                    continue;
                }
            } elseif (! filled($item->image)) {
                continue;
            }

            // ক্যালেন্ডার শুরু এখনো হয়নি — এই সারি ফ্রন্টে মিলাব না (পিছনের স্লট ফর্ম বা পরের কিউ আইটেম)।
            if ($item->starts_at && $item->starts_at->gt(now())) {
                continue;
            }

            if ($item->usesDurationRotation()) {
                if ($item->display_started_at) {
                    $end = $item->displayRunEndsAt();
                    if ($end && now()->gte($end)) {
                        continue;
                    }
                }
            } elseif (! $item->isLiveInQueuedRotation($next)) {
                continue;
            }

            if ($item->usesDurationRotation() && ! $item->display_started_at) {
                AdvertisementQueueItem::query()->whereKey($item->id)->update(['display_started_at' => now()]);
                $item->display_started_at = now();
            }

            $this->mergeQueueItemDisplayFrom($item);
            ad_queue_display_set($this, (int) $item->id);

            return;
        }
    }

    protected function mergeQueueItemDisplayFrom(AdvertisementQueueItem $item): void
    {
        $this->setAttribute('image', $item->image);
        $this->setAttribute('image_mobile', $item->image_mobile);
        $this->setAttribute('link', $item->link);
        $this->setAttribute('caption', $item->caption);
        $this->setAttribute('video_youtube_id', $item->video_youtube_id);
        $this->setAttribute('views_count', (int) ($item->views_count ?? 0));
        $this->setAttribute('clicks_count', (int) ($item->clicks_count ?? 0));
    }

    /**
     * Get ad slot by slug (for frontend and views) — শিডিউলের মধ্যে থাকলে।
     */
    public static function getBySlug(string $slug): ?self
    {
        $ad = static::query()
            ->where('slug', $slug)
            ->with(['queueItems' => fn ($q) => $q->whereNull('expired_at')->orderBy('sort_order')->orderBy('id')])
            ->activeForDisplay()
            ->first();
        if ($ad) {
            $ad->applyQueueItemDisplayOverride();
        }

        return $ad;
    }
}
