<?php

namespace App\Http\Controllers;

use App\Models\AdvertisementQueueItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdvertisementQueueClickController extends Controller
{
    public function __invoke(Request $request, AdvertisementQueueItem $queueItem): RedirectResponse
    {
        $sig = (string) $request->query('s', '');
        $expected = hash_hmac('sha256', 'queue:'.(string) $queueItem->id, (string) config('app.key'));
        if ($sig === '' || ! hash_equals($expected, $sig)) {
            abort(404);
        }

        $queueItem->increment('clicks_count');

        $url = $queueItem->link;
        if (! is_string($url) || trim($url) === '') {
            return redirect()->to('/');
        }

        return redirect()->away($url);
    }
}
