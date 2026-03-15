<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - The Daily News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md mx-auto -mt-32">
        <div class="flex flex-col items-center mb-8">
            @if(!empty(optional($siteMeta)->site_logo))
                <img src="{{ storage_image_url($siteMeta->site_logo) }}"
                     alt="{{ optional($siteMeta)->site_name ?? 'Logo' }}"
                     class="h-10 w-auto object-contain"
                     onerror="this.onerror=null;this.style.display='none';">
            @else
                <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow">
                    <span class="text-sm font-bold italic">DN</span>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow border border-slate-200 px-6 py-7 sm:px-8 sm:py-8 mt-20">
            <div class="text-center mb-6">
                <h1 class="text-lg font-semibold text-slate-800">Login</h1>
                <p class="text-xs text-slate-500 mt-1">Sign in to manage the newsroom</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm text-rose-700">
                    <div class="flex items-center gap-2 mb-1 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Unable to sign in</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition"
                        placeholder="you@example.com"
                    >
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center text-sm text-slate-600">
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span>Remember me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Sign in</span>
                </button>
            </form>
        </div>
    </div>
</body>
</html>
