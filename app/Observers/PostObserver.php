<?php

namespace App\Observers;

use App\Jobs\SendPostPushNotificationJob;
use App\Models\Post;

class PostObserver
{
    public function created(Post $post): void
    {
        if ($post->status === 'published') {
            dispatch(new SendPostPushNotificationJob($post))->afterResponse();
        }
    }

    public function updated(Post $post): void
    {
        if ($post->status === 'published' && $post->wasChanged('status')) {
            dispatch(new SendPostPushNotificationJob($post))->afterResponse();
        }
    }
}
