<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscribeController extends Controller
{
    /**
     * Display the subscribe management page.
     */
    public function index(): View
    {
        return view('admin.subscribes.index');
    }

    /**
     * Store (send) the subscription email.
     */
    public function store(Request $request)
    {
        // This is a placeholder for actual email sending logic
        return back()->with('success', 'Email sent to subscribers successfully!');
    }
}
