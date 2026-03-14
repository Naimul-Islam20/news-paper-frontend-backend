<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MetaController extends Controller
{
    /**
     * Display the meta settings page.
     */
    public function index(): View
    {
        $meta = SiteMeta::first() ?? new SiteMeta();
        return view('admin.meta.index', compact('meta'));
    }

    /**
     * Update the meta settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name'        => ['nullable', 'string', 'max:255'],
            'site_title'       => ['nullable', 'string', 'max:255'],
            'site_keywords'    => ['nullable', 'string', 'max:500'],
            'site_email'       => ['nullable', 'email', 'max:255'],
            'site_number'      => ['nullable', 'string', 'max:50'],
            'site_logo'        => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,webp,svg', 'max:2048'],
            'site_icon'        => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,ico,webp,svg', 'max:1024'],
            'site_description' => ['nullable', 'string'],
            'facebook_link'    => ['nullable', 'string', 'max:500'],
            'twitter_link'     => ['nullable', 'string', 'max:500'],
            'instagram_link'   => ['nullable', 'string', 'max:500'],
            'youtube_link'     => ['nullable', 'string', 'max:500'],
            'extra_social_links' => ['nullable', 'array'],
            'extra_social_links.*' => ['nullable', 'string', 'max:500'],
            'map_link'         => ['nullable', 'string', 'max:500'],
            'map_desc'         => ['nullable', 'string', 'max:255'],
            'address_1'        => ['nullable', 'string'],
            'editor_name'      => ['nullable', 'string', 'max:255'],
            'publisher_name'   => ['nullable', 'string', 'max:255'],
        ]);

        $meta = SiteMeta::first();

        if ($request->hasFile('site_logo')) {
            if ($meta && $meta->site_logo) {
                Storage::disk('public')->delete($meta->site_logo);
            }
            $validated['site_logo'] = $request->file('site_logo')->store('meta', 'public');
        } else {
            unset($validated['site_logo']);
        }

        if ($request->hasFile('site_icon')) {
            if ($meta && $meta->site_icon) {
                Storage::disk('public')->delete($meta->site_icon);
            }
            $validated['site_icon'] = $request->file('site_icon')->store('meta', 'public');
        } else {
            unset($validated['site_icon']);
        }

        if (isset($validated['extra_social_links'])) {
            $validated['extra_social_links'] = array_values(array_filter($validated['extra_social_links']));
        }

        if ($meta) {
            $meta->update($validated);
        } else {
            SiteMeta::create($validated);
        }

        return redirect()->route('admin.meta.index')->with('success', 'Settings updated successfully!');
    }
}
