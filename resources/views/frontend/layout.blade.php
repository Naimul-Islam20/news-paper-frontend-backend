<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-font-preload />
    <title>@yield('title', 'News Frontend')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php
        $__primary = optional($siteMeta ?? null)->primary_color ?? null;
        $__primaryOk = is_string($__primary) && preg_match('/^#([0-9A-Fa-f]{3}|[0-9A-Fa-f]{6})$/', $__primary);
    @endphp
    @if ($__primaryOk)
    <style>:root { --color-primary: {{ $__primary }} !important; }</style>
    @endif
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="max-w-6xl mx-auto py-4">
        @yield('content')
    </div>
</body>

</html>