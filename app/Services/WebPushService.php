<?php

namespace App\Services;

use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class WebPushService
{
    public function isConfigured(): bool
    {
        return filled(config('webpush.public_key')) && filled(config('webpush.private_key'));
    }

    public function isEnabled(): bool
    {
        return config('webpush.enabled', true) && $this->isConfigured();
    }

    public function publicKey(): ?string
    {
        return config('webpush.public_key');
    }

    public function subscribe(array $payload, ?string $userAgent = null): PushSubscription
    {
        return PushSubscription::updateOrCreate(
            ['endpoint' => $payload['endpoint']],
            [
                'public_key' => $payload['keys']['p256dh'],
                'auth_token' => $payload['keys']['auth'],
                'content_encoding' => $payload['contentEncoding'] ?? 'aesgcm',
                'user_agent' => $userAgent,
            ],
        );
    }

    public function unsubscribe(string $endpoint): void
    {
        PushSubscription::where('endpoint', $endpoint)->delete();
    }

    public function sendToAll(string $title, string $body, ?string $url = null, ?string $icon = null): int
    {
        if (! $this->isEnabled()) {
            return 0;
        }

        $subscriptions = PushSubscription::query()->get();
        if ($subscriptions->isEmpty()) {
            return 0;
        }

        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'url' => $url,
            'icon' => $icon,
        ], JSON_UNESCAPED_UNICODE);

        $webPush = $this->client();
        $sent = 0;

        foreach ($subscriptions as $row) {
            $webPush->queueNotification(
                $this->toSubscription($row),
                $payload,
                ['TTL' => 3600, 'urgency' => 'normal'],
            );
        }

        foreach ($webPush->flush() as $report) {
            if ($report->isSuccess()) {
                $sent++;

                continue;
            }

            $endpoint = (string) $report->getEndpoint();
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $endpoint)->delete();
            }

            Log::warning('webpush: delivery failed', [
                'endpoint' => $endpoint,
                'reason' => $report->getReason(),
            ]);
        }

        return $sent;
    }

    protected function client(): WebPush
    {
        return new WebPush([
            'VAPID' => [
                'subject' => config('webpush.subject'),
                'publicKey' => config('webpush.public_key'),
                'privateKey' => config('webpush.private_key'),
            ],
        ]);
    }

    protected function toSubscription(PushSubscription $row): Subscription
    {
        return Subscription::create([
            'endpoint' => $row->endpoint,
            'publicKey' => $row->public_key,
            'authToken' => $row->auth_token,
            'contentEncoding' => $row->content_encoding ?: 'aesgcm',
        ]);
    }
}
