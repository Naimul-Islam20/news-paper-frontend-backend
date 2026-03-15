<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * লগইন করা user-এর role চেক করে permission দেওয়া হবে।
     */
    private function checkPermission(string $action, ?User $targetUser = null): bool
    {
        $authUser = auth()->user();

        // Sub Editor কিছুই করতে পারবে না
        if ($authUser->role === 'sub editor') {
            return false;
        }

        // Admin সব কিছু করতে পারবে
        if ($authUser->role === 'admin') {
            return true;
        }

        // Senior Editor - শুধু Sub Editor create/edit করতে পারবে
        if ($authUser->role === 'senior editor') {
            if ($action === 'create') return true;
            if ($action === 'edit' && $targetUser && $targetUser->role === 'sub editor') return true;
            return false;
        }

        return false;
    }

    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $authUser = auth()->user();

        // Sub Editor - কোনো access নেই
        if ($authUser->role === 'sub editor') {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this section.');
        }

        // Senior Editor - শুধু Sub Editor দেখবে
        if ($authUser->role === 'senior editor') {
            $users = User::where('role', 'sub editor')->latest()->paginate(10);
        } else {
            // Admin - সবাইকে দেখবে
            $users = User::latest()->paginate(10);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        if (!$this->checkPermission('create')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to perform this action.');
        }

        $authUser = auth()->user();

        // Admin সব রোল (Reporter ছাড়া); Senior Editor শুধু Sub Editor বানাতে পারবে
        $allowedRoles = $authUser->role === 'admin'
            ? ['admin' => 'Admin', 'senior editor' => 'Senior Editor', 'sub editor' => 'Sub Editor']
            : ['sub editor' => 'Sub Editor'];

        return view('admin.users.create', compact('allowedRoles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        if (!$this->checkPermission('create')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to perform this action.');
        }

        $authUser = auth()->user();
        $allowedRoleValues = $authUser->role === 'admin'
            ? 'admin,senior editor,sub editor'
            : 'sub editor';

        $rules = [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role'     => 'required|in:' . $allowedRoleValues,
            'phone'    => 'nullable',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $request->validate($rules);

        $data = $request->except('password', 'image');
        $data['password'] = Hash::make($request->password);
        $data['status'] = $request->has('status');
        $data['reporter_id'] = null;

        // Admin সবসময় active
        if ($data['role'] === 'admin') {
            $data['status'] = true;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (!$this->checkPermission('edit', $user)) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to edit this user.');
        }

        $authUser = auth()->user();

        $allowedRoles = $authUser->role === 'admin'
            ? ['admin' => 'Admin', 'senior editor' => 'Senior Editor', 'sub editor' => 'Sub Editor']
            : ['sub editor' => 'Sub Editor'];

        return view('admin.users.edit', compact('user', 'allowedRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$this->checkPermission('edit', $user)) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to edit this user.');
        }

        $authUser = auth()->user();
        $allowedRoleValues = $authUser->role === 'admin'
            ? 'admin,senior editor,sub editor'
            : 'sub editor';

        $rules = [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'role'     => 'required|in:' . $allowedRoleValues,
            'phone'    => 'nullable',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $request->validate($rules);

        $data = $request->except('password', 'image');
        $data['reporter_id'] = null;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $data['status'] = $request->has('status');

        // Admin সবসময় active থাকবে
        if (($data['role'] ?? $user->role) === 'admin') {
            $data['status'] = true;
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = $request->file('image')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to perform this action.');
        }

        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
