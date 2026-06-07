@extends('admin.layout')

@section('title', 'Manage Role & Access')
@section('header_title', 'Manage Role & Access')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="max-w-5xl mx-auto">
        @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 font-medium">
            {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 font-medium">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.role-permissions.update') }}" method="POST" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-800">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    কোন রোলের কোন পেজ/ফিচারে অ্যাক্সেস থাকবে সেটা নিচের চেকবক্স দিয়ে সেট করুন। Admin এর সব অ্যাক্সেস থাকে; অন্যান্য রোলের জন্য চেক করে সেভ করুন।
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="py-3 px-4 text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Page / Feature</th>
                            @foreach($roles as $roleKey => $roleLabel)
                            <th class="py-3 px-4 text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider text-center">{{ $roleLabel }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($featureKeys as $key => $label)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30">
                            <td class="py-3 px-4 text-sm font-medium text-slate-800 dark:text-slate-200">{{ $label }}</td>
                            @foreach($roles as $roleKey => $roleLabel)
                            <td class="py-3 px-4 text-center">
                                @php
                                    $checked = ($permissions[$roleKey][$key] ?? false) || ($roleKey === 'admin');
                                @endphp
                                <input type="checkbox"
                                       name="permissions[{{ $roleKey }}][{{ $key }}]"
                                       value="1"
                                       {{ $checked ? 'checked' : '' }}
                                       @if($roleKey === 'admin') disabled @endif
                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                @if($roleKey === 'admin')
                                <input type="hidden" name="permissions[{{ $roleKey }}][{{ $key }}]" value="1">
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-slate-200 dark:border-slate-800 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-all shadow-sm text-sm">
                    Save Access
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
