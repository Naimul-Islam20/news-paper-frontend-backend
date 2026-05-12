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

if (! function_exists('ad_slot')) {
    /**
     * Get ad slot by slug for frontend display.
     * Returns the Advertisement model or null.
     */
    function ad_slot(string $slug): ?\App\Models\Advertisement
    {
        return \App\Models\Advertisement::getBySlug($slug);
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
