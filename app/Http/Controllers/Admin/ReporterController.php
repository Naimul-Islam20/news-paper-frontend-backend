<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Reporter;
use Illuminate\Support\Facades\Storage;

class ReporterController extends Controller
{
    public function index()
    {
        $reporters = Reporter::with('creator')->latest()->paginate(10);
        return view('admin.reporters.index', compact('reporters'));
    }

    public function create()
    {
        return view('admin.reporters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:reporters',
            'phone' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');
        $data['created_by'] = auth()->id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reporters', 'public');
            $data['image'] = $imagePath;
        }

        Reporter::create($data);

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter created successfully.');
    }

    public function edit($id)
    {
        $reporter = Reporter::findOrFail($id);
        return view('admin.reporters.edit', compact('reporter'));
    }

    public function update(Request $request, $id)
    {
        $reporter = Reporter::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:reporters,email,' . $id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($reporter->image) {
                Storage::disk('public')->delete($reporter->image);
            }
            
            $imagePath = $request->file('image')->store('reporters', 'public');
            $data['image'] = $imagePath;
        }

        $reporter->update($data);

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter updated successfully.');
    }

    public function destroy($id)
    {
        $reporter = Reporter::findOrFail($id);
        
        if ($reporter->image) {
            Storage::disk('public')->delete($reporter->image);
        }

        $reporter->delete();

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter deleted successfully.');
    }
}
