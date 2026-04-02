<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscribeController extends Controller
{
    /**
     * Display the subscribe management page.
     */
    public function index(Request $request): View
    {
        $baseQuery = Subscriber::query()
            ->orderByDesc('created_at');

        $query = clone $baseQuery;

        if ($request->filled('search')) {
            $search = trim($request->search);

            if ($search !== '' && ctype_digit($search)) {
                $serial = (int) $search;

                if ($serial > 0) {
                    $target = (clone $baseQuery)
                        ->skip($serial - 1)
                        ->take(1)
                        ->first();

                    if ($target) {
                        $query->whereKey($target->id);
                    } else {
                        $query->whereRaw('1 = 0');
                    }
                }
            } else {
                $query->where('email', 'like', '%' . $search . '%');
            }
        }

        $subscribers = $query->paginate(20)->withQueryString();

        return view('admin.subscribes.index', [
            'subscribers' => $subscribers,
        ]);
    }

    /**
     * Store (send) the subscription email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'link'    => 'nullable|url'
        ]);

        $subscribers = Subscriber::all();
        
        foreach($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterMail(
                $request->subject, 
                $request->message, 
                $request->link
            ));
        }

        return back()->with('success', 'Email sent to all ' . $subscribers->count() . ' subscribers successfully!');
    }
}
