<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdvertisementClickController extends Controller
{
    /**
     * ক্লিক রেকর্ড করে টার্গেট URL এ পাঠায়।
     */
    public function __invoke(Request $request, Advertisement $advertisement): RedirectResponse
    {
        $sig = (string) $request->query('s', '');
        $expected = hash_hmac('sha256', (string) $advertisement->id, (string) config('app.key'));
        if ($sig === '' || ! hash_equals($expected, $sig)) {
            abort(404);
        }

        $advertisement->increment('clicks_count');

        $url = $advertisement->link;
        if (! is_string($url) || trim($url) === '') {
            return redirect()->to('/');
        }

        return redirect()->away($url);
    }
}
