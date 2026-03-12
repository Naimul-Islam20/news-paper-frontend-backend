<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MetaController extends Controller
{
    /**
     * Display the meta settings page.
     */
    public function index(): View
    {
        return view('admin.meta.index');
    }

    /**
     * Update the meta settings.
     */
    public function update(Request $request)
    {
        // Placeholder for update logic
        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
