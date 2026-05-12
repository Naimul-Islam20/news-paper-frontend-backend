<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisementQueueItem extends Model
{
    protected $table = 'advertisement_queue_items';

    protected $fillable = [
        'advertisement_id',
        'sort_order',
        'duration_days',
        'duration_hours',
        'display_started_at',
        'expired_at',
        'title',
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
            'display_started_at' => 'datetime',
            'expired_at' => 'datetime',
        ];
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function scopeWhereNotExpired(Builder $query): Builder
    {
        return $query->whereNull('expired_at');
    }

    public function scopeWhereExpired(Builder $query): Builder
    {
        return $query->whereNotNull('expired_at');
    }

    public function scopeActiveForDisplay(Builder $query): Builder
    {
        $now = now();

        return $query->where(function (Builder $q) use ($now) {
            $q->where(function (Builder $w) use ($now) {
                $w->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })->where(function (Builder $w) use ($now) {
                $w->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
        });
    }

    public function isActiveForDisplay(): bool
    {
        $now = now();
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }
        if ($this->ends_at && $this->ends_at->lt($now)) {
            return false;
        }

        return true;
    }

    /** দিন + ঘণ্টা দিয়ে ঘূর্ণন চালু */
    public function usesDurationRotation(): bool
    {
        return ((int) $this->duration_days) > 0 || ((int) $this->duration_hours) > 0;
    }

    public function displayRunEndsAt(): ?Carbon
    {
        if (! $this->display_started_at || ! $this->usesDurationRotation()) {
            return null;
        }

        return $this->display_started_at->copy()
            ->addDays((int) $this->duration_days)
            ->addHours((int) $this->duration_hours);
    }

    /**
     * মেয়াদ শেষ বা ক্যালেন্ডার শিডিউল শেষ হলে expired_at সেট করে পরের আইটেমকে জায়গা দেয়।
     * মূল স্লট ফর্মের ক্যালেন্ডার উইন্ডো চলাকালীন কিউর কিছুই মেয়াদ শেষ/ঘূর্ণন হিসেবে এগোয় না —
     * কিউর সময় শুধু সেই উইন্ডো শেষ হওয়ার পর থেকে গণনা (ফ্রন্টে কিউ দেখানোর সাথে মিল রেখে)।
     */
    public static function reconcileExpiredForAdvertisementId(int $advertisementId): void
    {
        $now = now();

        // লিগ্যাসি সারি (দিন/ঘণ্টা ০): display_started_at ব্যবহার হয় না; ডাটা ভুল থাকলে সরিয়ে একটিভ স্টেট দ্বিধা কমানো।
        static::query()
            ->where('advertisement_id', $advertisementId)
            ->whereNull('expired_at')
            ->where('duration_days', 0)
            ->where('duration_hours', 0)
            ->whereNotNull('display_started_at')
            ->update(['display_started_at' => null]);

        $parentAd = Advertisement::query()->find($advertisementId);
        if ($parentAd && $parentAd->isWithinSlotScheduleWindow()) {
            return;
        }

        $running = static::query()
            ->where('advertisement_id', $advertisementId)
            ->whereNull('expired_at')
            ->whereNotNull('display_started_at')
            ->get();

        foreach ($running as $item) {
            if (! $item->usesDurationRotation()) {
                continue;
            }
            $end = $item->displayRunEndsAt();
            if ($end && $now->gte($end)) {
                static::query()->whereKey($item->id)->update(['expired_at' => $now]);
            }
        }

        $legacy = static::query()
            ->where('advertisement_id', $advertisementId)
            ->whereNull('expired_at')
            ->where('duration_days', 0)
            ->where('duration_hours', 0)
            ->get();

        foreach ($legacy as $item) {
            if (! $item->isActiveForDisplay()) {
                static::query()->whereKey($item->id)->update(['expired_at' => $now]);
            }
        }
    }

    /**
     * ক্যালেন্ডার-মাত্র মোড (পুরনো আইটেম): ends_at না থাকলে পরের starts_at দিয়ে হাত বদল।
     */
    public function isLiveInQueuedRotation(?AdvertisementQueueItem $nextSiblingInSortOrder): bool
    {
        if ($this->ends_at !== null) {
            return $this->isActiveForDisplay();
        }

        $now = now();
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }

        if ($nextSiblingInSortOrder && $nextSiblingInSortOrder->starts_at) {
            return $now->lt($nextSiblingInSortOrder->starts_at);
        }

        return true;
    }
}
