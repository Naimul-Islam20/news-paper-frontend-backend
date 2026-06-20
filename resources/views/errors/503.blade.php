<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>সাইট রক্ষণাবেক্ষণে — {{ config('app.name') }}</title>
    <x-font-preload />
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --color-primary: #2563eb;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6">
        <div class="w-full max-w-lg text-center">
            <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-primary/10 text-primary shadow-sm ring-1 ring-primary/20">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <p class="text-sm font-medium uppercase tracking-widest text-primary">503</p>
            <h1 class="mt-3 text-2xl sm:text-3xl font-bold text-slate-900 leading-tight">
                সাইট সাময়িকভাবে বন্ধ
            </h1>

            @if (! empty($message))
                <p class="mt-4 text-base text-slate-600 leading-relaxed">
                    {{ $message }}
                </p>
            @else
                <p class="mt-4 text-base text-slate-600 leading-relaxed">
                    আমরা সাইট আরও ভালো করার জন্য কাজ করছি। কিছুক্ষণ পর আবার চেষ্টা করুন।
                </p>
            @endif

            @if (isset($retryAfter) && $retryAfter > 0)
                <p class="mt-3 text-sm text-slate-500">
                    আনুমানিক
                    <span id="retry-countdown" class="font-semibold text-slate-700">{{ $retryAfter }}</span>
                    সেকেন্ড পর পুনরায় চেষ্টা করা যাবে।
                </p>
            @endif

            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <button
                    type="button"
                    onclick="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:ring-offset-2"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    পেজ রিফ্রেশ করুন
                </button>
            </div>

            <p class="mt-10 text-xs text-slate-400">
                {{ config('app.name') }}
            </p>
        </div>
    </div>

    @if (isset($retryAfter) && $retryAfter > 0)
        <script>
            (function () {
                var remaining = {{ (int) $retryAfter }};
                var el = document.getElementById('retry-countdown');

                if (!el || remaining <= 0) {
                    return;
                }

                var timer = setInterval(function () {
                    remaining -= 1;

                    if (remaining <= 0) {
                        clearInterval(timer);
                        window.location.reload();
                        return;
                    }

                    el.textContent = remaining;
                }, 1000);
            })();
        </script>
    @endif
</body>
</html>
