<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\SiteMeta;
use App\Services\WebPushService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class SendPostPushNotificationJob
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(public Post $post) {}

    public function handle(WebPushService $webPush): void
    {
        if (! $webPush->isEnabled() || $this->post->status !== 'published') {
            return;
        }

        $meta = SiteMeta::get();
        $icon = $meta?->site_icon
            ? storage_image_url($meta->site_icon)
            : asset('logo.svg');

        $webPush->sendToAll(
            site_name_bn() ?: site_name(),
            Str::limit($this->post->title, 140),
            url('/' . ltrim($this->post->slug, '/')),
            $icon,
        );
    }
}
