<x-layout>
    <x-slot:title>Unicode to Bijoy - Bangla text Converter - {{ site_name() }}</x-slot>

    <div class="py-4 md:py-10 min-h-screen notranslate">
        <div class="container max-w-4xl">

            <div class="mb-6 md:mb-10 text-left">
                <h1 class="text-2xl md:text-3xl font-semibold serif text-title mb-2">
                    Unicode to Bijoy - Bangla text Converter
                </h1>

                <div class="flex items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6 mt-4">
                    <a href="{{ front_home_url() }}" class="text-slate-500 hover:text-primary transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="m9 18 6-6-6-6"/></svg>
                    <span class="text-black font-bold">
                        <span class="i18n-bn">বাংলা কনভার্টার</span>
                        <span class="i18n-en">Bangla Converter</span>
                    </span>
                </div>

                <div class="w-full border-b border-slate-300 relative mb-4 md:mb-6">
                    <div class="absolute -bottom-[1px] left-0 w-40 h-[2px] bg-primary"></div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                        <label for="unicode-input" class="text-sm font-semibold text-slate-800">
                            <span class="i18n-bn">ইউনিকোডের লেখা পেস্ট করুন</span>
                            <span class="i18n-en">Paste Unicode text</span>
                        </label>
                        <button type="button" onclick="banglaCopy('unicode')" class="text-xs text-primary hover:underline font-medium">
                            <span class="i18n-bn">কপি</span>
                            <span class="i18n-en">Copy</span>
                        </button>
                    </div>
                    <textarea
                        id="unicode-input"
                        rows="8"
                        placeholder="আপনার ইউনিকোড বাংলা লেখা এখানে পেস্ট করুন..."
                        data-placeholder-en="Paste your Unicode Bangla text here..."
                        class="w-full px-4 py-3 text-base md:text-lg leading-relaxed border-0 focus:ring-0 outline-none resize-y min-h-[180px] font-normal notranslate"></textarea>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-2 md:gap-3">
                    <button
                        type="button"
                        onclick="banglaUnicodeToBijoy()"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-sm"
                        style="background-color:#2563eb">
                        Unicode to Bijoy
                    </button>
                    <button
                        type="button"
                        onclick="banglaBijoyToUnicode()"
                        class="px-4 py-2 text-sm font-semibold text-white rounded-sm"
                        style="background-color:#1e293b">
                        Bijoy to Unicode
                    </button>
                    <button
                        type="button"
                        onclick="banglaFixBroken()"
                        class="px-4 py-2 text-sm font-semibold rounded-sm"
                        style="border:1px solid #f59e0b;color:#b45309;background-color:#fffbeb">
                        Fix Bijoy Broken
                    </button>
                    <button
                        type="button"
                        onclick="banglaClearAll()"
                        class="px-4 py-2 text-sm font-semibold rounded-sm"
                        style="border:1px solid #cbd5e1;color:#334155;background-color:#fff">
                        Clear text
                    </button>
                </div>

                <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                        <label for="bijoy-input" class="text-sm font-semibold text-slate-800">
                            <span class="i18n-bn">বিজয় লেখা পেস্ট করুন</span>
                            <span class="i18n-en">Paste Bijoy text</span>
                        </label>
                        <button type="button" onclick="banglaCopy('bijoy')" class="text-xs text-primary hover:underline font-medium">
                            <span class="i18n-bn">কপি</span>
                            <span class="i18n-en">Copy</span>
                        </button>
                    </div>
                    <textarea
                        id="bijoy-input"
                        rows="8"
                        placeholder="আপনার বিজয় লেখা এখানে পেস্ট করুন..."
                        data-placeholder-en="Paste your Bijoy text here..."
                        class="w-full px-4 py-3 text-base md:text-lg leading-relaxed border-0 focus:ring-0 outline-none resize-y min-h-[180px] bijoy-text notranslate"></textarea>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/bangla-converter/all.js') }}?v=1"></script>
</x-layout>
