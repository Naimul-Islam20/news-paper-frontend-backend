<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Theme bootstrap: read stored preference
        (function () {
            try {
                const stored = localStorage.getItem('theme');
                if (stored === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {
                // ignore
            }
        })();

        // Global toggle function for inline use
        window.toggleTheme = function () {
            const root = document.documentElement;
            const isDark = root.classList.toggle('dark');
            try {
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            } catch (e) {
                // ignore
            }
        };

        window.toggleSubmenu = function (id) {
            const el = document.getElementById(id);
            const arrow = document.getElementById(id + '-arrow');
            const isOpen = el.classList.contains('grid-rows-[1fr]');
            
            // Close all other open submenus
            if (!isOpen) {
                document.querySelectorAll('[id$="-menu"]').forEach(menu => {
                    if (menu.id !== id) {
                        menu.classList.replace('grid-rows-[1fr]', 'grid-rows-[0fr]');
                        const otherArrow = document.getElementById(menu.id + '-arrow');
                        if (otherArrow) otherArrow.classList.remove('rotate-180');
                    }
                });
            }

            // Toggle current submenu
            if (isOpen) {
                el.classList.replace('grid-rows-[1fr]', 'grid-rows-[0fr]');
                if (arrow) arrow.classList.remove('rotate-180');
            } else {
                el.classList.replace('grid-rows-[0fr]', 'grid-rows-[1fr]');
                if (arrow) arrow.classList.add('rotate-180');
            }
        };

        // Heartbeat to keep session alive while working
        setInterval(function() {
            fetch('{{ route('admin.heartbeat') }}')
                .then(response => response.json())
                .catch(error => console.error('Heartbeat failed:', error));
        }, 5 * 60 * 1000); // Ping every 5 minutes
    </script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white border-r border-slate-200 dark:bg-slate-900/90 dark:border-slate-800/80 backdrop-blur fixed top-0 left-0 bottom-0 z-40 h-screen flex flex-col">
            <div class="h-20 flex items-center px-6 border-b border-slate-200 dark:border-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 dark:shadow-none">
                        <span class="text-sm font-black italic">DN</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold tracking-tight text-slate-900 dark:text-white">
                            The Daily News
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-bold tracking-widest">Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <nav class="p-4 space-y-1 text-sm overflow-y-auto flex-1 custom-scrollbar">
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium">Dashboard</span>
                </a>

                {{-- Smooth Dropdown Posts --}}
                <div class="relative">
                    <button 
                        type="button"
                        onclick="toggleSubmenu('posts-menu')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all group"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                            <span class="font-medium">Posts</span>
                        </div>
                        <svg id="posts-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="posts-menu" class="grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">New Post</span>
                                </a>
                                <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Post</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Smooth Dropdown Category --}}
                <div class="relative">
                    <button 
                        type="button"
                        onclick="toggleSubmenu('categories-menu')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all group"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.125 1.125 0 001.591 0l4.454-4.454a1.125 1.125 0 000-1.591L9.706 4.318A2.25 2.25 0 008.25 3h1.318z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6a1 1 0 100 2 1 1 0 000-2z"></path></svg>
                            <span class="font-medium">Categories</span>
                        </div>
                        <svg id="categories-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="categories-menu" class="grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Category</span>
                                </a>
                                <a href="{{ route('admin.sub-categories.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Sub Category</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all">
                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <span class="font-medium">Menus</span>
                </a>

                <div class="mb-1">
                    <button 
                        type="button"
                        onclick="toggleSubmenu('pages-menu')"
                        class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all group"
                    >
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                            <span class="font-medium">Pages</span>
                        </div>
                        <svg id="pages-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="pages-menu" class="grid grid-rows-[0fr] transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.pages.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">New Page</span>
                                </a>
                                <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Pages</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Gallery --}}
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('gallery-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.galleries.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.galleries.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                            <span class="font-medium">Gallery</span>
                        </div>
                        <svg id="gallery-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="gallery-menu" class="{{ request()->routeIs('admin.galleries.*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.galleries.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.galleries.create') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Add Img</span>
                                </a>
                                <a href="{{ route('admin.galleries.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.galleries.index') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Img</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Videos --}}
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('video-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.videos.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.videos.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"></path></svg>
                            <span class="font-medium">Video</span>
                        </div>
                        <svg id="video-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="video-menu" class="{{ request()->routeIs('admin.videos.*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.videos.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.videos.create') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Add Video</span>
                                </a>
                                <a href="{{ route('admin.videos.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.videos.index') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Video</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all">
                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.375a3 3 0 003 3h15a3 3 0 003-3V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v7.125z"></path></svg>
                    <span class="font-medium">Media Library</span>
                </a>



                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200 transition-all">
                    <svg class="w-5 h-5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751A11.959 11.959 0 0112 2.714z"></path></svg>
                    <span class="font-medium">Manage Roles</span>
                </a>


                {{-- Statistics --}}
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('statistics-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->is('admin/statistics*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->is('admin/statistics*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"></path></svg>
                            <span class="font-medium">Statistics</span>
                        </div>
                        <svg id="statistics-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="statistics-menu" class="{{ request()->is('admin/statistics*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.statistics.visitors') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.statistics.visitors') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Visitors</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reporters --}}
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('reporter-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reporters.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.reporters.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 12.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path></svg>
                            <span class="font-medium">Reporters</span>
                        </div>
                        <svg id="reporter-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="reporter-menu" class="{{ request()->routeIs('admin.reporters.*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.reporters.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.reporters.create') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Add Reporter</span>
                                </a>
                                <a href="{{ route('admin.reporters.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.reporters.index') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Reporter</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Advertisement --}}
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('advertisement-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.advertisements.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.advertisements.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.213c-.079-.335.124-.658.468-.741a4.501 4.501/0 01.445-.07m6.751-4.513c-.058-1.089-.138-2.16-.24-3.217h.746a2.25 2.25 0 012.25 2.25v1.936a2.25 2.25 0 01-2.25 2.25h-.746a21.357 21.357 0 01.24-3.219z"></path></svg>
                            <span class="font-medium">Advertisement</span>
                        </div>
                        <svg id="advertisement-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="advertisement-menu" class="{{ request()->routeIs('admin.advertisements.*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.advertisements.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.advertisements.create') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Add Advertisement</span>
                                </a>
                                <a href="{{ route('admin.advertisements.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.advertisements.index') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All Advertisement</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.subscribes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.subscribes.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.subscribes.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                    <span class="font-medium">Subscribers</span>
                </a>

                {{-- Users --}}
                @if(auth()->user()->role !== 'sub editor')
                <div class="space-y-1">
                    <button type="button" onclick="toggleSubmenu('users-menu')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="font-medium">Users</span>
                        </div>
                        <svg id="users-menu-arrow" class="w-3.5 h-3.5 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="users-menu" class="{{ request()->routeIs('admin.users.*') ? 'grid grid-rows-[1fr]' : 'grid grid-rows-[0fr]' }} transition-all duration-300 ease-in-out">
                        <div class="overflow-hidden">
                            <div class="ml-4 pl-0 border-l border-slate-200 dark:border-slate-800 space-y-0 py-1">
                                <a href="{{ route('admin.users.create') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.users.create') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">Add User</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-0 py-2 text-xs font-medium text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400 transition-all group/sub relative {{ request()->routeIs('admin.users.index') ? 'text-indigo-600 dark:text-indigo-400' : '' }}">
                                    {{-- L-shaped connector --}}
                                    <svg class="w-6 h-6 text-slate-200 dark:text-slate-800 -ml-[1px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 12h10m0 0l-4-4m4 4l-4 4"></path></svg>
                                    <span class="ml-1">All User</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif





                <a href="{{ route('admin.meta.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.meta.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.meta.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"></path></svg>
                    <span class="font-medium">SEO & Meta</span>
                </a>

                <a
                    href="{{ route('admin.user-settings.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.user-settings.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-200' }}"
                >
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.user-settings.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="font-medium">User Settings</span>
                </a>
            </nav>
        </aside>

        {{-- Main --}}
        <main class="flex-1 flex flex-col ml-64">
            <header class="h-20 bg-white/80 border-b border-slate-200 dark:bg-slate-950/80 dark:border-slate-800 backdrop-blur-xl sticky top-0 z-30 flex items-center justify-between px-6">
                <div>
                    <h1 class="text-xl font-normal tracking-tight text-slate-900 dark:text-white">
                        @yield('header_title', 'Dashboard')
                    </h1>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                        @yield('header_subtitle')
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        type="button"
                        onclick="window.toggleTheme()"
                        class="p-2.5 rounded-xl text-slate-500 bg-slate-50 border border-slate-200 hover:bg-slate-100 dark:text-slate-400 dark:bg-slate-900 dark:border-slate-800 dark:hover:bg-slate-800 transition-all shadow-sm"
                        title="Toggle Theme"
                    >
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z"></path></svg>
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-1"></div>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-100 dark:text-red-400 dark:bg-red-500/10 dark:border-red-500/20 dark:hover:bg-red-500/20 transition-all"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <section class="p-6 flex-1">
                {{-- Global Alert Messages --}}
                @if(session('success'))
                    <div class="max-w-7xl mx-auto mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 animate-in fade-in slide-in-from-top-4 duration-300">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="max-w-7xl mx-auto mb-6 flex items-center gap-3 px-4 py-3 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 animate-in fade-in slide-in-from-top-4 duration-300">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

