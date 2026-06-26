<?php

namespace App\Http\Controllers;

use App\Services\WebPushService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PushSubscriptionController extends Controller
{
    public function config(WebPushService $webPush): JsonResponse
    {
        if (! $webPush->isEnabled()) {
            return response()->json(['enabled' => false]);
        }

        return response()->json([
            'enabled' => true,
            'publicKey' => $webPush->publicKey(),
        ]);
    }

    public function subscribe(Request $request, WebPushService $webPush): JsonResponse
    {
        if (! $webPush->isEnabled()) {
            return response()->json(['message' => 'Push notifications are disabled.'], 503);
        }

        $validated = $request->validate([
            'endpoint' => 'required|url|max:500',
            'keys.auth' => 'required|string|max:255',
            'keys.p256dh' => 'required|string|max:255',
            'contentEncoding' => 'nullable|string|max:32',
        ]);

        $webPush->subscribe($validated, $request->userAgent());

        return response()->json(['ok' => true]);
    }

    public function unsubscribe(Request $request, WebPushService $webPush): JsonResponse
    {
        $validated = $request->validate([
            'endpoint' => 'required|url|max:500',
        ]);

        $webPush->unsubscribe($validated['endpoint']);

        return response()->json(['ok' => true]);
    }
}
