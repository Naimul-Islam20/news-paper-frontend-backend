<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Advertisement extends Model
{
    protected $fillable = [
        'slug',
        'ad_source',
        'google_ad_slot',
        'google_ad_auto',
        'local_ad_paused',
        'local_ad_paused_remaining_seconds',
        'name',
        'image',
        'image_mobile',
        'video',
        'video_mobile',
        'link',
        'caption',
        'video_youtube_id',
        'starts_at',
        'ends_at',
        'is_auto',
        'views_count',
        'clicks_count',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_auto' => 'boolean',
            'google_ad_auto' => 'boolean',
            'local_ad_paused' => 'boolean',
            'local_ad_paused_remaining_seconds' => 'integer',
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
            ->where(function (Builder $q) use ($now) {
                $q->where(function (Builder $w) use ($now) {
                    $w->where('is_auto', true)
                        ->where('starts_at', '<=', $now);
                })->orWhere(function (Builder $w) use ($now) {
                    $w->whereNotNull('ends_at')
                        ->where(function (Builder $inner) use ($now) {
                            $inner->where(function (Builder $live) use ($now) {
                                $live->where('starts_at', '<=', $now)
                                    ->where('ends_at', '>=', $now);
                            })->orWhere(function (Builder $past) use ($now) {
                                $past->where('ends_at', '<', $now)
                                    ->whereHas('queueItems', function (Builder $qi) {
                                        $qi->whereNull('expired_at');
                                    });
                            });
                        });
                });
            });
    }

    public function isActiveForDisplay(): bool
    {
        if (! $this->starts_at) {
            return false;
        }

        $now = now();
        if ($this->starts_at->gt($now)) {
            return false;
        }

        if ($this->is_auto) {
            return true;
        }

        if (! $this->ends_at) {
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
        if (! $this->starts_at) {
            return false;
        }

        $now = now();

        if ($this->is_auto) {
            return $this->starts_at->lte($now);
        }

        if (! $this->ends_at) {
            return false;
        }

        return $this->starts_at->lte($now) && $this->ends_at->gte($now);
    }

    /**
     * স্লটের মেয়াদ শেষ বা সক্রিয় উইন্ডো বাইরে থাকা কনটেন্ট পুরনো তালিকায় সরিয়ে ফর্ম খালি রাখে।
     */
    public function archiveExpiredSlotIfNeeded(): bool
    {
        if ($this->isLocalAdPaused()) {
            return false;
        }

        if ($this->is_auto || $this->isWithinSlotScheduleWindow()) {
            return false;
        }

        // আসন্ন বা এখনও চলবে এমন উইন্ডো — স্পর্শ করব না
        if ($this->starts_at && $this->starts_at->gt(now())) {
            return false;
        }
        if ($this->ends_at && $this->ends_at->gte(now())) {
            return false;
        }

        $hasContent = $this->hasDisplayableMedia() || filled($this->link);
        $hasSchedule = $this->starts_at !== null || $this->ends_at !== null;

        if (! $hasContent && ! $hasSchedule) {
            return false;
        }

        if ($hasContent) {
            $this->archiveSlotContentToHistory();
        }

        $this->clearSlotContent();

        return true;
    }

    protected function archiveSlotContentToHistory(): void
    {
        if (! $this->hasDisplayableMedia() && ! filled($this->link)) {
            return;
        }

        $totalH = 1;
        $days = 0;
        $hours = 1;
        if ($this->starts_at && $this->ends_at) {
            $totalH = max(1, (int) round($this->starts_at->floatDiffInHours($this->ends_at)));
            $days = intdiv($totalH, 24);
            $hours = $totalH % 24;
        }

        $title = 'স্লট অ্যাড';
        if ($this->starts_at && $this->ends_at) {
            $title .= ' ('.$this->starts_at->format('d M Y, H:i').' – '.$this->ends_at->format('d M Y, H:i').')';
        } elseif ($this->ends_at) {
            $title .= ' (মেয়াদ শেষ '.$this->ends_at->format('d M Y, H:i').')';
        }

        AdvertisementQueueItem::query()->create([
            'advertisement_id' => $this->id,
            'sort_order' => 9999,
            'title' => $title,
            'image' => $this->image,
            'image_mobile' => $this->image_mobile,
            'video' => $this->video,
            'video_mobile' => $this->video_mobile,
            'link' => $this->link,
            'caption' => $this->caption,
            'video_youtube_id' => $this->video_youtube_id,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'display_started_at' => $this->starts_at,
            'duration_days' => $days,
            'duration_hours' => $hours,
            'expired_at' => now(),
            'views_count' => (int) ($this->views_count ?? 0),
            'clicks_count' => (int) ($this->clicks_count ?? 0),
        ]);
    }

    public static function archiveExpiredSlotForId(int $advertisementId): void
    {
        $ad = static::query()->find($advertisementId);
        if ($ad) {
            $ad->archiveExpiredSlotIfNeeded();
        }
    }

    /** অ্যাডমিন তালিকা/ফ্রন্ট লোডের আগে সব নিষ্ক্রিয় স্লট পরিষ্কার */
    public static function archiveAllExpiredSlots(): void
    {
        static::query()
            ->orderBy('id')
            ->each(fn (self $ad) => $ad->archiveExpiredSlotIfNeeded());
    }

    /**
     * অ্যাডমিন তালিকায় প্রিভিউ: শুধু চলমান স্লট উইন্ডোর মিডিয়া (কিউ/মেয়াদোত্তীর্ণ স্লট নয়)।
     */
    public function adminListPreview(): ?self
    {
        if ($this->isWithinSlotScheduleWindow() && $this->hasDisplayableMedia()) {
            return $this;
        }

        return null;
    }

    public function clearSlotContent(): void
    {
        $this->update([
            'image' => null,
            'image_mobile' => null,
            'video' => null,
            'video_mobile' => null,
            'link' => null,
            'caption' => null,
            'video_youtube_id' => null,
            'starts_at' => null,
            'ends_at' => null,
            'is_auto' => false,
            'local_ad_paused' => false,
            'local_ad_paused_remaining_seconds' => null,
            'views_count' => 0,
            'clicks_count' => 0,
        ]);
    }

    public function isLocalAdPaused(): bool
    {
        return (bool) ($this->local_ad_paused ?? false);
    }

    public function hasPausedLocalAd(): bool
    {
        return $this->isLocalAdPaused() && $this->hasDisplayableMedia();
    }

    public function hasRunningLocalAd(): bool
    {
        if ($this->isLocalAdPaused()) {
            return false;
        }

        if (! $this->isActiveForDisplay()) {
            return false;
        }

        return $this->hasDisplayableMedia();
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

        foreach ($items as $i => $item) {
            $next = $items[$i + 1] ?? null;

            if (! $item->hasDisplayableMedia()) {
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
     *
     * @param  bool  $forAdminPreview  true হলে শুধু মেমোরিতে মার্জ (অ্যাডমিন ফর্মে ফ্রন্টের মতো দেখানো); reconcile / display_started_at DB / ভিউ-ম্যাপ স্পর্শ করে না।
     */
    public function applyQueueItemDisplayOverride(bool $forAdminPreview = false): void
    {
        if (! $forAdminPreview) {
            $this->archiveExpiredSlotIfNeeded();
            $this->refresh();
            AdvertisementQueueItem::reconcileExpiredForAdvertisementId((int) $this->id);
        }

        // স্লটের উপরের সময়সূচি উইন্ডো চলাকালীন ফ্রন্টে শুধু মূল স্লট (ফর্ম) এর ডেটা; কিউ এখানে মিলবে না।
        if ($this->isWithinSlotScheduleWindow()) {
            return;
        }

        $item = $this->findQueueItemForFrontDisplayMerge();
        if (! $item) {
            return;
        }

        if ($item->usesDurationRotation() && ! $item->display_started_at) {
            if (! $forAdminPreview) {
                AdvertisementQueueItem::query()->whereKey($item->id)->update(['display_started_at' => now()]);
                $item->display_started_at = now();
            }
        }

        $this->mergeQueueItemDisplayFrom($item);
        if (! $forAdminPreview) {
            ad_queue_display_set($this, (int) $item->id);
        }
    }

    /**
     * ফ্রন্টে `applyQueueItemDisplayOverride` যে সারিটির সঙ্গে মিলাবে তার মডেল (কোনো DB রাইট ছাড়া)।
     */
    public function findQueueItemForFrontDisplayMerge(): ?AdvertisementQueueItem
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

        foreach ($items as $i => $item) {
            $next = $items[$i + 1] ?? null;

            if (! $item->hasDisplayableMedia()) {
                continue;
            }

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

            return $item;
        }

        return null;
    }

    protected function mergeQueueItemDisplayFrom(AdvertisementQueueItem $item): void
    {
        $this->setAttribute('image', $item->image);
        $this->setAttribute('image_mobile', $item->image_mobile);
        $this->setAttribute('video', $item->video);
        $this->setAttribute('video_mobile', $item->video_mobile);
        $this->setAttribute('link', $item->link);
        $this->setAttribute('caption', $item->caption);
        $this->setAttribute('video_youtube_id', $item->video_youtube_id);
        $this->setAttribute('views_count', (int) ($item->views_count ?? 0));
        $this->setAttribute('clicks_count', (int) ($item->clicks_count ?? 0));
    }

    public function googleAdAutoEnabled(): bool
    {
        return (bool) ($this->google_ad_auto ?? false);
    }

    public function resolvedGoogleAdSlot(): ?string
    {
        return google_adsense_slot_for($this);
    }

    public function canShowGoogleAd(): bool
    {
        if (! google_adsense_configured()) {
            return false;
        }

        if (! $this->googleAdAutoEnabled()) {
            return false;
        }

        return filled($this->resolvedGoogleAdSlot());
    }

    /** Local priority — Google শুধু local না চললে fallback */
    public function displayUsesGoogleAd(): bool
    {
        if ($this->slug === 'home_video') {
            return false;
        }

        if ($this->hasRunningLocalAd()) {
            return false;
        }

        return $this->canShowGoogleAd();
    }

    public function displayUsesLocalAd(): bool
    {
        return $this->hasRunningLocalAd();
    }

    /** ফ্রন্ট/অ্যাডমিন প্রিভিউ: কিউ মার্জ + মেয়াদ reconcile */
    public function prepareForFrontDisplay(bool $forAdminPreview = false): self
    {
        $this->applyQueueItemDisplayOverride($forAdminPreview);

        return $this;
    }

    /** @return array{mode: string, reasons: list<string>} */
    public function frontAdDebug(): array
    {
        $this->prepareForFrontDisplay(forAdminPreview: true);

        $reasons = [];

        if (! $this->googleAdAutoEnabled()) {
            $reasons[] = 'Google Auto OFF';
        }
        if (! filled($this->google_ad_slot)) {
            $reasons[] = filled(google_adsense_default_slot())
                ? 'Slot ID নেই (Meta default: '.google_adsense_default_slot().')'
                : 'Slot ID নেই';
        }
        if (! filled(google_adsense_client())) {
            $reasons[] = 'SEO & Meta-তে Client ID নেই';
        }
        if ($this->hasRunningLocalAd()) {
            $reasons[] = 'Local ad চলছে (Google block)';
        }

        if ($this->displayUsesGoogleAd()) {
            if (! google_adsense_frontend_enabled()) {
                $reasons[] = 'JS বন্ধ — GOOGLE_ADSENSE_FRONTEND_ENABLED=true + config:clear';
            }

            return ['mode' => 'Google', 'reasons' => $reasons];
        }
        if ($this->displayUsesLocalAd()) {
            if ($this->canShowGoogleAd()) {
                $reasons[] = 'Google ready — Local বন্ধ/Delete করলে Google দেখাবে';
            }

            return ['mode' => 'Local', 'reasons' => $reasons];
        }

        if ($this->canShowGoogleAd() && ! $this->googleAdAutoEnabled() && filled(normalize_google_adsense_slot($this->google_ad_slot))) {
            $reasons[] = 'Auto OFF (display still OK if Slot ID + Client ID আছে)';
        }

        return ['mode' => 'খালি', 'reasons' => $reasons ?: ['কোনো ad active নেই']];
    }

    /** @deprecated displayUsesGoogleAd() ব্যবহার করুন */
    public function usesGoogleAd(): bool
    {
        return $this->displayUsesGoogleAd();
    }

    /**
     * Get ad slot by slug (for frontend and views).
     * Local চললে local; না থাকলে google_ad_auto + Slot ID থাকলে Google।
     */
    public static function getBySlug(string $slug): ?self
    {
        $ad = static::query()
            ->where('slug', $slug)
            ->with(['queueItems' => fn ($q) => $q->whereNull('expired_at')->orderBy('sort_order')->orderBy('id')])
            ->first();

        if (! $ad) {
            return null;
        }

        $ad->prepareForFrontDisplay();

        if ($ad->displayUsesLocalAd()) {
            return $ad;
        }

        if ($ad->displayUsesGoogleAd()) {
            return $ad;
        }

        return null;
    }

    public function hasDisplayableMedia(): bool
    {
        return filled($this->video_youtube_id)
            || filled($this->video)
            || filled($this->video_mobile)
            || filled($this->image)
            || filled($this->image_mobile);
    }

    public function resolvedMediaType(): string
    {
        if (filled($this->video_youtube_id)) {
            return 'youtube';
        }
        if (filled($this->video) || filled($this->video_mobile)) {
            return 'video';
        }

        return 'image';
    }

    /**
     * @return array{ratio: string, size: string, note: string}|null
     */
    public function mediaSpec(): ?array
    {
        $spec = config('advertisement_slots.media_specs.'.$this->slug);

        return is_array($spec) ? $spec : null;
    }

    /**
     * @return array{width: int, height: int}|null
     */
    public function mediaSpecDimensions(): ?array
    {
        return ad_media_spec_dimensions($this->mediaSpec());
    }

    public function slotBoxStyle(string $layout = 'strip'): string
    {
        return ad_slot_box_style($this, $layout);
    }

    public function mediaSpecLabel(): ?string
    {
        $spec = $this->mediaSpec();

        if (! $spec) {
            return null;
        }

        return 'রেশিও '.$spec['ratio'].' · '.$spec['size'];
    }
}
