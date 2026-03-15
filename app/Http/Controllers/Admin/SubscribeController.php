<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscribeController extends Controller
{
    /**
     * Display the subscribe management page.
     */
    public function index(): View
    {
        $subscribers = Subscriber::query()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.subscribes.index', [
            'subscribers' => $subscribers,
        ]);
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
