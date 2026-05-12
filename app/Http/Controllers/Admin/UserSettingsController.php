<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserSettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('admin.user-settings', [
            'user' => $user,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (! empty($validated['remove_image']) && $user->image) {
            delete_uploaded_media($user->image);
            $user->image = null;
        } elseif ($request->hasFile('image')) {
            delete_uploaded_media($user->image);
            $user->image = store_public_upload($request->file('image'), 'users');
        }

        $user->save();

        return redirect()
            ->route('admin.user-settings.edit')
            ->with('status', 'User settings updated successfully.');
    }
}

