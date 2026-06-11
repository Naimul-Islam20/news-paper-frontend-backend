<x-layout>
    <x-slot:title>Unicode to Bijoy - Bangla text Converter - {{ site_name() }}</x-slot>

    <div class="py-4 md:py-10 min-h-screen notranslate">
        <div class="container max-w-4xl">

            <div class="mb-6 md:mb-10 text-left">
                <h1 class="text-2xl md:text-3xl font-semibold serif text-title mb-2">
                    Unicode to Bijoy - Bangla text Converter
                </h1>
                <p class="text-slate-600 text-sm md:text-base mb-4">
                    ইউনিকোড ও বিজয় (SutonnyMJ) লেখার মধ্যে সহজে রূপান্তর করুন
                </p>

                <div class="flex items-center gap-1 text-sm font-bold text-slate-500 mb-4 md:mb-6">
                    <a href="{{ front_home_url() }}" class="text-slate-500 hover:text-primary transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="m9 18 6-6-6-6"/></svg>
                    <span class="text-black font-bold">বাংলা কনভার্টার</span>
                </div>

                <div class="w-full border-b border-slate-300 relative mb-4 md:mb-6">
                    <div class="absolute -bottom-[1px] left-0 w-40 h-[2px] bg-primary"></div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                        <label for="unicode-input" class="text-sm font-semibold text-slate-800">ইউনিকোডের লেখা পেস্ট করুন</label>
                        <button type="button" onclick="banglaCopy('unicode')" class="text-xs text-primary hover:underline font-medium">কপি</button>
                    </div>
                    <textarea
                        id="unicode-input"
                        rows="8"
                        placeholder="আপনার ইউনিকোড বাংলা লেখা এখানে পেস্ট করুন..."
                        class="w-full px-4 py-3 text-base md:text-lg leading-relaxed border-0 focus:ring-0 outline-none resize-y min-h-[180px] font-normal"></textarea>
                </div>

                <div class="flex flex-wrap items-center justify-center gap-2 md:gap-3">
                    <button
                        type="button"
                        onclick="banglaUnicodeToBijoy()"
                        class="px-4 py-2 text-sm font-semibold bg-primary text-white hover:opacity-90 transition-opacity rounded-sm">
                        Unicode to Bijoy
                    </button>
                    <button
                        type="button"
                        onclick="banglaBijoyToUnicode()"
                        class="px-4 py-2 text-sm font-semibold bg-slate-800 text-white hover:bg-slate-700 transition-colors rounded-sm">
                        Bijoy to Unicode
                    </button>
                    <button
                        type="button"
                        onclick="banglaFixBroken()"
                        class="px-4 py-2 text-sm font-semibold border border-amber-500 text-amber-700 bg-amber-50 hover:bg-amber-100 transition-colors rounded-sm">
                        Fix Bijoy Broken
                    </button>
                    <button
                        type="button"
                        onclick="banglaClearAll()"
                        class="px-4 py-2 text-sm font-semibold border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition-colors rounded-sm">
                        Clear text
                    </button>
                </div>

                <div class="bg-white border border-slate-200 rounded-sm shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-slate-50 border-b border-slate-200">
                        <label for="bijoy-input" class="text-sm font-semibold text-slate-800">বিজয় লেখা পেস্ট করুন</label>
                        <button type="button" onclick="banglaCopy('bijoy')" class="text-xs text-primary hover:underline font-medium">কপি</button>
                    </div>
                    <textarea
                        id="bijoy-input"
                        rows="8"
                        placeholder="আপনার বিজয় লেখা এখানে পেস্ট করুন..."
                        class="w-full px-4 py-3 text-base md:text-lg leading-relaxed border-0 focus:ring-0 outline-none resize-y min-h-[180px] bijoy-text"></textarea>
                </div>

                <p class="text-xs text-slate-500 text-center pb-4">
                    বিজয় লেখা সঠিকভাবে দেখতে SutonnyMJ, NikoshBAN বা অনুরূপ বিজয় ফন্ট ব্যবহার করুন।
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('js/bangla-converter/base.js') }}"></script>
        <script src="{{ asset('js/bangla-converter/bijoy.js') }}"></script>
        <script src="{{ asset('js/bangla-converter/unicode.js') }}"></script>
        <script src="{{ asset('js/bangla-converter/page.js') }}"></script>
    @endpush
</x-layout>
