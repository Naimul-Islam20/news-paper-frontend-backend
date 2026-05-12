<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('front_home_url')) {
    /**
     * ফ্রন্ট হোমপেজের সম্পূর্ণ URL (সাবডিরেক্টরি যেমন …/public/ সহ)।
     * ওয়েব রিকোয়েস্টে `url('/')` — URL::forceRootUrl() থাকলে লোগো/লিংক ব্রাউজারের হোস্টের সাথে মিলবে।
     * কনসোলে config('app.url') প্রাধান্য।
     */
    function front_home_url(): string
    {
        if (! app()->runningInConsole()) {
            try {
                return rtrim((string) url('/'), '/').'/';
            } catch (\Throwable) {
                // fall through
            }
        }

        $configured = rtrim((string) config('app.url', ''), '/');
        if ($configured !== '') {
            return $configured.'/';
        }

        if (! app()->runningInConsole()) {
            try {
                $root = request()->root();
                if (is_string($root) && $root !== '') {
                    return rtrim($root, '/').'/';
                }
            } catch (\Throwable) {
                // fall through
            }
        }

        try {
            return rtrim((string) url('/'), '/').'/';
        } catch (\Throwable) {
            return '/';
        }
    }
}

if (! function_exists('storage_image_url')) {
    /**
     * ইমেজ URL: নতুন আপলোড public/posts ইত্যাদিতে; পুরনো storage/app/public → /storage/...
     * শুধু is_file() নির্ভর না — কিছু সার্ভারে false হলেও ফাইল public এ থাকে, তখন ভুলে /storage/ চলে যেত।
     */
    function storage_image_url(?string $path): string
    {
        if (! $path) {
            return '';
        }
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $path = ltrim($path, '/');

        $directPublicPrefixes = ['posts/', 'videos/', 'galleries/', 'users/', 'advertisements/', 'pages/', 'meta/'];
        $isManagedUploadPath = false;
        foreach ($directPublicPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                $isManagedUploadPath = true;
                break;
            }
        }

        if ($isManagedUploadPath && is_file(public_path($path))) {
            return asset($path);
        }

        if (Storage::disk('public')->exists($path)) {
            return asset('storage/'.$path);
        }

        if ($isManagedUploadPath) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }
}

if (! function_exists('store_public_upload')) {
    /**
     * আপলোড ফাইল public/{directory}/ এ সেভ করে DB তে রাখার জন্য রিলেটিভ পাথ রিটার্ন করে।
     */
    function store_public_upload(UploadedFile $file, string $directory): string
    {
        $directory = trim($directory, '/');
        $targetDir = public_path($directory);
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $filename = $file->hashName();
        $file->move($targetDir, $filename);

        return $directory.'/'.$filename;
    }
}

if (! function_exists('delete_uploaded_media')) {
    /**
     * public/ বা পুরনো storage disk — যেখানে ফাইল আছে সেখান থেকে মুছে দেয়।
     */
    function delete_uploaded_media(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }
        $path = ltrim($path, '/');
        $full = public_path($path);
        if (is_file($full)) {
            @unlink($full);

            return;
        }
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}

if (! function_exists('published_at')) {
    /**
     * Format published date/time for detail pages. Database এ যে মান সেভ আছে সেটাই দেখায় (কোনো টাইমজোন পরিবর্তন নেই).
     * $date null হলে খালি স্ট্রিং রিটার্ন করে।
     */
    function published_at($date, string $format = 'd M Y, H:i'): string
    {
        if (! $date) {
            return '';
        }

        return $date->format($format);
    }
}

if (! function_exists('category_url')) {
    /**
     * Build category listing page URL (parent or child category).
     */
    function category_url($category): string
    {
        if (! $category || ! $category->slug) {
            return url('/');
        }
        if ($category->parent_id && $category->relationLoaded('parent') && $category->parent) {
            return route('category.show.child', [$category->parent->slug, $category->slug]);
        }

        return route('category.show', $category->slug);
    }
}

if (! function_exists('ad_queue_display_get')) {
    function ad_queue_display_get(?\App\Models\Advertisement $ad): ?int
    {
        if (! $ad) {
            return null;
        }
        if (! isset($GLOBALS['__adQueueDisplayMap']) || ! is_array($GLOBALS['__adQueueDisplayMap'])) {
            $GLOBALS['__adQueueDisplayMap'] = [];
        }

        return $GLOBALS['__adQueueDisplayMap'][spl_object_id($ad)] ?? null;
    }
}

if (! function_exists('ad_queue_display_set')) {
    function ad_queue_display_set(\App\Models\Advertisement $ad, int $queueItemId): void
    {
        if (! isset($GLOBALS['__adQueueDisplayMap']) || ! is_array($GLOBALS['__adQueueDisplayMap'])) {
            $GLOBALS['__adQueueDisplayMap'] = [];
        }
        $GLOBALS['__adQueueDisplayMap'][spl_object_id($ad)] = $queueItemId;
    }
}

if (! function_exists('advertisement_bump_view_once')) {
    /**
     * একই HTTP রিকোয়েস্টে একই অ্যাড আইডিতে একবারই views_count বাড়ে।
     */
    function advertisement_bump_view_once(?\App\Models\Advertisement $ad): void
    {
        if (! $ad || app()->runningInConsole()) {
            return;
        }
        $visible = filled($ad->image) || filled($ad->video_youtube_id);
        if (! $visible) {
            return;
        }
        try {
            $req = request();
        } catch (\Throwable) {
            return;
        }
        if (! $req) {
            return;
        }
        $queueId = ad_queue_display_get($ad);
        $key = $queueId !== null ? 'q:'.$queueId : 'a:'.$ad->id;
        $keys = $req->attributes->get('advertisement_view_bumped_keys', []);
        if (! is_array($keys)) {
            $keys = [];
        }
        if (in_array($key, $keys, true)) {
            return;
        }
        $req->attributes->set('advertisement_view_bumped_keys', array_merge($keys, [$key]));
        if ($queueId !== null) {
            \App\Models\AdvertisementQueueItem::query()->whereKey($queueId)->increment('views_count');
        } else {
            \App\Models\Advertisement::query()->whereKey($ad->id)->increment('views_count');
        }
    }
}

if (! function_exists('advertisement_record_views_for_models')) {
    /**
     * @param  iterable<\App\Models\Advertisement>  $advertisements
     */
    function advertisement_record_views_for_models(iterable $advertisements): void
    {
        foreach ($advertisements as $ad) {
            if ($ad instanceof \App\Models\Advertisement) {
                advertisement_bump_view_once($ad);
            }
        }
    }
}

if (! function_exists('advertisement_click_url')) {
    /**
     * ফ্রন্টে অ্যাড ক্লিক ট্র্যাকিং URL (রিলেটিভ)। টার্গেট লিংক খালি হলেও ক্লিক কাউন্ট হবে; রিডাইরেক্ট হোমে।
     */
    function advertisement_click_url(?\App\Models\Advertisement $ad): string
    {
        if (! $ad || ! $ad->id) {
            return '#';
        }
        $queueId = ad_queue_display_get($ad);
        if ($queueId !== null) {
            $sig = hash_hmac('sha256', 'queue:'.(string) $queueId, (string) config('app.key'));

            return route('advertisement.queue-click', ['queueItem' => $queueId, 's' => $sig], false);
        }
        $sig = hash_hmac('sha256', (string) $ad->id, (string) config('app.key'));

        return route('advertisement.click', ['advertisement' => $ad->id, 's' => $sig], false);
    }
}

if (! function_exists('ad_slot')) {
    /**
     * Get ad slot by frontend slug for display.
     * Returns the Advertisement model or null.
     */
    function ad_slot(string $slug): ?\App\Models\Advertisement
    {
        $ad = \App\Models\Advertisement::getBySlug($slug);
        advertisement_bump_view_once($ad);

        return $ad;
    }
}

if (! function_exists('inject_post_detail_ads_between_paragraphs')) {
    /**
     * মোবাইল ইনলাইন অ্যাড: প্রথম অ্যাড প্রথম ও দ্বিতীয় প্যারার মাঝের ফাঁকে, দ্বিতীয়টা শেষের আগের ফাঁকে
     * (কমপক্ষে দুটি `</p>` থাকলে) — একদম শুরু বা একদম শেষে নয়।
     *
     * @param  string  $html  WYSIWYG বিবরণ HTML
     * @param  string  $adBlock1  রেন্ডার করা HTML (খালি হলে বসবে না)
     * @param  string  $adBlock2  রেন্ডার করা HTML
     */
    function inject_post_detail_ads_between_paragraphs(string $html, string $adBlock1, string $adBlock2): string
    {
        $adBlock1 = $adBlock1 !== '' ? $adBlock1 : '';
        $adBlock2 = $adBlock2 !== '' ? $adBlock2 : '';
        if ($adBlock1 === '' && $adBlock2 === '') {
            return $html;
        }

        if (! preg_match_all('/<\/p\s*>/i', $html, $matches, PREG_OFFSET_CAPTURE)) {
            return $html;
        }

        $tagMatches = $matches[0];
        $n = count($tagMatches);
        if ($n < 2) {
            return $html;
        }

        $endAfter = static function (array $m): int {
            return $m[1] + strlen($m[0]);
        };

        /** @var array<int, string> */
        $at = [];

        if ($adBlock1 !== '') {
            $pos = $endAfter($tagMatches[0]);
            $at[$pos] = ($at[$pos] ?? '').$adBlock1;
        }

        if ($adBlock2 !== '') {
            if ($n === 2) {
                $pos = $endAfter($tagMatches[0]);
                $at[$pos] = ($at[$pos] ?? '').$adBlock2;
            } else {
                $idx = $n - 2;
                $pos = $endAfter($tagMatches[$idx]);
                $at[$pos] = ($at[$pos] ?? '').$adBlock2;
            }
        }

        krsort($at, SORT_NUMERIC);
        foreach ($at as $offset => $fragment) {
            $html = substr($html, 0, $offset).$fragment.substr($html, $offset);
        }

        return $html;
    }
}

if (! function_exists('news_url')) {
    /**
     * Build simple news post URL (/{slug}).
     */
    function news_url($post): string
    {
        if (! $post || ! $post->slug) {
            return url('/');
        }

        return route('news.show', [$post->slug]);
    }
}
