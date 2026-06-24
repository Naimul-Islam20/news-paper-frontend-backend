<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-font-preload />
    @php
        $loginSiteName = site_name();
        $loginPageTitle = 'Admin Login - ' . $loginSiteName;
        $loginPageUrl = url()->current();
        $loginSiteHost = share_site_label($loginPageUrl);
    @endphp
    <title>{{ $loginPageTitle }}</title>
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $loginPageUrl }}">
    <meta property="og:title" content="{{ $loginPageTitle }}">
    @if($loginSiteHost !== '')
    <meta property="og:description" content="{{ $loginSiteHost }}">
    @endif
    <meta property="og:site_name" content="{{ $loginSiteName }}">
    @if(!empty(optional($siteMeta)->site_logo))
    <meta property="og:image" content="{{ storage_image_url($siteMeta->site_logo) }}">
    @endif
    @if(!empty(optional($siteMeta)->site_icon))
    <link rel="icon" href="{{ storage_image_url($siteMeta->site_icon) }}" type="image/png">
    @endif
    <style>
        :root { --site-name: "{{ site_name() }}"; }
        #password.password-masked {
            -webkit-text-security: disc;
        }
    </style>
    <x-admin.theme-init />
    @vite(['resources/css/app.css', 'resources/js/admin-theme.js'])
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 flex items-center justify-center px-4 py-10">
    <div class="fixed top-4 right-4 z-50">
        <x-admin.theme-toggle />
    </div>

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

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow border border-slate-200 dark:border-slate-800 px-6 py-7 sm:px-8 sm:py-8 mt-20">
            <div class="text-center mb-6">
                <h1 class="text-lg font-semibold text-slate-800 dark:text-white">Login</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Sign in to manage the newsroom</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 px-4 py-3 text-sm text-rose-700 dark:text-rose-300">
                    <div class="flex items-center gap-2 mb-1 font-semibold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Unable to sign in</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600 dark:text-rose-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-5">
                @csrf

                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="block w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 py-2.5 text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition"
                        placeholder="you@example.com"
                    >
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <div class="relative">
                        <input
                            id="password"
                            type="text"
                            name="password"
                            required
                            autocomplete="current-password"
                            spellcheck="false"
                            autocorrect="off"
                            autocapitalize="off"
                            class="password-masked block w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 py-2.5 pr-11 text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition"
                            placeholder="••••••••"
                        >
                        <button
                            type="button"
                            id="toggle-login-password"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                            aria-label="Show password"
                            title="Show password"
                        >
                            <svg id="login-password-eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <svg id="login-password-eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858 3.05a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-transparent text-sm font-semibold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Sign in</span>
                </button>
            </form>
        </div>
    </div>

    <script>
    (function () {
        var input = document.getElementById('password');
        var btn = document.getElementById('toggle-login-password');
        var eyeOpen = document.getElementById('login-password-eye-open');
        var eyeClosed = document.getElementById('login-password-eye-closed');
        if (!input || !btn) return;

        btn.addEventListener('mousedown', function (e) {
            e.preventDefault();
        });

        btn.addEventListener('click', function () {
            input.classList.toggle('password-masked');
            var isHidden = input.classList.contains('password-masked');

            if (eyeOpen) eyeOpen.classList.toggle('hidden', !isHidden);
            if (eyeClosed) eyeClosed.classList.toggle('hidden', isHidden);
            btn.setAttribute('aria-label', isHidden ? 'Show password' : 'Hide password');
            btn.setAttribute('title', isHidden ? 'Show password' : 'Hide password');
        });
    })();
    </script>
</body>
</html>
