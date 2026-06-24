<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use Illuminate\Http\Request;

class ReporterController extends Controller
{
    public function index(Request $request)
    {
        $baseQuery = Reporter::query()
            ->with(['creator'])
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
                      ->orWhere('desk', 'like', '%' . $search . '%');
                });
            }
        }

        $reporters = $query->paginate(10)->withQueryString();

        return view('admin.reporters.index', compact('reporters'));
    }

    public function create()
    {
        return redirect()->route('admin.reporters.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'desk' => 'required|string|max:255',
        ], [
            'desk.required' => 'রিপোর্টার ধরন/ডেস্ক অবশ্যই লিখতে হবে। পোস্টে রিপোর্টার এই ডেস্ক অনুযায়ী দেখাবে।',
        ]);

        $desk = trim($request->input('desk'));

        Reporter::create([
            'name' => $desk,
            'desk' => $desk,
            'created_by' => auth()->id(),
            'status' => 'active',
        ]);

        return redirect()->route('admin.reporters.index')->with('success', 'Reporter created successfully.');
    }

    public function quickStore(Request $request)
    {
        $request->validate([
            'desk' => 'required|string|max:255',
        ], [
            'desk.required' => 'রিপোর্টার ধরন/ডেস্ক অবশ্যই লিখতে হবে।',
        ]);

        $desk = trim($request->input('desk'));

        $reporter = Reporter::create([
            'name' => $desk,
            'desk' => $desk,
            'created_by' => auth()->id(),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'reporter' => [
                'id' => $reporter->id,
                'desk' => $reporter->desk,
                'name' => $reporter->name,
            ],
        ]);
    }

    public function edit($id)
    {
        return redirect()->route('admin.reporters.index');
    }

    public function update(Request $request, $id)
    {
        $reporter = Reporter::findOrFail($id);

        $request->validate([
            'desk' => 'required|string|max:255',
        ], [
            'desk.required' => 'রিপোর্টার ধরন/ডেস্ক অবশ্যই লিখতে হবে। পোস্টে রিপোর্টার এই ডেস্ক অনুযায়ী দেখাবে।',
        ]);

        $desk = trim($request->input('desk'));

        $reporter->update([
            'desk' => $desk,
            'name' => $desk,
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
