<?php

if (!function_exists('storage_image_url')) {
    /**
     * Public URL for files stored on the public disk (post/gallery/video images).
     * Database এ path যেমন 'posts/xyz.jpg' সেভ থাকে, এটা দিয়ে সঠিক URL বের করে।
     */
    function storage_image_url(?string $path): string
    {
        if (! $path) {
            return '';
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    }
}

if (!function_exists('published_at')) {
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

if (!function_exists('category_url')) {
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

if (!function_exists('ad_slot')) {
    /**
     * Get ad slot by slug for frontend display.
     * Returns the Advertisement model or null.
     */
    function ad_slot(string $slug): ?\App\Models\Advertisement
    {
        return \App\Models\Advertisement::getBySlug($slug);
    }
}

if (!function_exists('news_url')) {
    /**
     * Build news post URL from category slugs, or fallback to home when missing.
     */
    function news_url($post): string
    {
        if (!$post || !$post->slug) {
            return url('/');
        }
        $primaryCategory = $post->categories->first();
        if (!$primaryCategory) {
            return url('/');
        }
        $parentCategory = $primaryCategory->parent;
        $categorySlug = $parentCategory ? $parentCategory->slug : $primaryCategory->slug;
        $subCategorySlug = $parentCategory ? $primaryCategory->slug : null;
        if (!$categorySlug) {
            return url('/');
        }
        return $subCategorySlug
            ? route('news.show.sub', [$categorySlug, $subCategorySlug, $post->slug])
            : route('news.show', [$categorySlug, $post->slug]);
    }
}
