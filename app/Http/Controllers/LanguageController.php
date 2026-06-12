<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $response = redirect()->back();

        if ($locale === 'en') {
            return $response->withCookie(cookie('googtrans', '/bn/en', 60 * 24 * 365, '/', null, false, false));
        }

        return $response->withCookie(cookie()->forget('googtrans'));
    }
}
