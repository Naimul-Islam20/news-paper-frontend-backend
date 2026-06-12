<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporterController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Reporter::query()
            ->linkedToUser()
            ->with(['creator', 'subEditor'])
            ->latest();

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
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('desk', 'like', '%' . $search . '%');
                });
            }
        }

        $reporters = $query->paginate(10)->withQueryString();

        return view('admin.reporters.index', compact('reporters'));
    }

    public function create()
    {
        $subEditors = User::where('role', 'sub editor')
            ->where('name', '!=', 'Sub Editor')
            ->orderBy('name')
            ->get();
        return view('admin.reporters.create', compact('subEditors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_editor_id' => 'required|exists:users,id',
            'desk' => 'required|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ], [
            'sub_editor_id.required' => 'ইউজার নির্বাচন করুন।',
            'sub_editor_id.exists' => 'অবৈধ ইউজার।',
            'desk.required' => 'রিপোর্টার ধরন/ডেস্ক অবশ্যই লিখতে হবে। পোস্টে রিপোর্টার এই ডেস্ক অনুযায়ী দেখাবে।',
        ]);

        $subEditor = User::findOrFail($request->sub_editor_id);
        $data = [
            'name' => $subEditor->name,
            'email' => $subEditor->email,
            'phone' => $subEditor->phone ?? null,
            'desk' => $request->input('desk'),
            'sub_editor_id' => $subEditor->id,
            'created_by' => auth()->id(),
            'status' => $request->input('status', 'active'),
        ];

        Reporter::create($data);

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter created successfully.');
    }

    public function edit($id)
    {
        $reporter = Reporter::findOrFail($id);
        $subEditors = User::where('role', 'sub editor')
            ->where('name', '!=', 'Sub Editor')
            ->orderBy('name')
            ->get();
        return view('admin.reporters.edit', compact('reporter', 'subEditors'));
    }

    public function update(Request $request, $id)
    {
        $reporter = Reporter::findOrFail($id);

        $request->validate([
            'sub_editor_id' => 'required|exists:users,id',
            'desk' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ], [
            'sub_editor_id.required' => 'ইউজার নির্বাচন করুন। প্রতিটি রিপোর্টার ধরনের সাথে একটি ইউজার লিংক থাকতে হবে।',
            'sub_editor_id.exists' => 'অবৈধ ইউজার।',
            'desk.required' => 'রিপোর্টার ধরন/ডেস্ক অবশ্যই লিখতে হবে। পোস্টে রিপোর্টার এই ডেস্ক অনুযায়ী দেখাবে।',
        ]);

        $subEditor = User::findOrFail($request->sub_editor_id);

        $reporter->update([
            'desk' => $request->input('desk'),
            'sub_editor_id' => $subEditor->id,
            'name' => $subEditor->name,
            'email' => $subEditor->email,
            'phone' => $subEditor->phone ?? null,
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter updated successfully.');
    }

    public function destroy($id)
    {
        $reporter = Reporter::findOrFail($id);
        
        if ($reporter->image) {
            delete_uploaded_media($reporter->image);
        }

        $reporter->delete();

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter deleted successfully.');
    }
}
