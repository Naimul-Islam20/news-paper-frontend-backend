<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submitMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactMessage = \App\Models\ContactMessage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Message submitted successfully!',
            'data' => $contactMessage
        ], 201);
    }
}
