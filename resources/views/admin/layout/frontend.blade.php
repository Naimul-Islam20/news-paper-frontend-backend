@extends('admin.layout')

@section('title', 'Frontend Layout Settings')
@section('header_title', 'Frontend Layout')
@section('header_subtitle', 'Header ও Footer এ কোন category দেখাবে তা এখান থেকে নির্বাচন করুন')

@section('content')
<div class="space-y-6">
    <form method="POST" action="{{ route('admin.layout.frontend.save') }}" id="layout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- ===== HEADER SLOTS (16) ===== --}}
            <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col h-[750px]">
                <div class="p-6 border-b border-slate-100 bg-indigo-50/50">
                    <div class="flex items-center gap-4">

                        <div>
                            <h2 class="text-base font-bold text-slate-800">Header Navigation</h2>
                            <p class="text-[11px] text-slate-500 font-medium">সিরিয়াল অনুযায়ী ১৬টি স্লট</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                    @for($i = 0; $i < 16; $i++)
                    @php $selectedId = $headerCategoryIds[$i] ?? null; @endphp
                    <div class="flex items-center gap-3">
                        {{-- Serial Number --}}
                        <div class="w-6 shrink-0 text-xs font-black text-slate-900">
                            {{ $i + 1 }}
                        </div>
                        
                        {{-- Custom Select Wrapper --}}
                        <div class="flex-1 relative h-10 border border-slate-200 rounded-xl bg-slate-50/50 overflow-hidden group">
                            {{-- Visual Layer --}}
                            <div class="visual-label absolute inset-0 flex items-center justify-between px-4 pointer-events-none z-10">
                                <span class="text-sm font-black text-slate-900 truncate pr-4">
                                    @php 
                                        $selectedName = '-- empty --';
                                        if($selectedId) {
                                            foreach($categories as $cat) {
                                                if($cat->id == $selectedId) {
                                                    $selectedName = $cat->name;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    {{ $selectedName }}
                                </span>
                                <svg class="w-4 h-4 text-black shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 3px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>

                            {{-- Functional Layer --}}
                            <select name="header_categories[]" 
                                data-column="header"
                                class="slot-select absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                onchange="var span = this.parentElement.querySelector('span'); span.textContent = this.options[this.selectedIndex].text; checkExclusivity(this); enableBtn('header-btn');">
                                <option value="">-- empty --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $selectedId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endfor
                </div>

                {{-- Column Footer with Update Button --}}
                <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                    <button type="submit" id="header-btn"
                        onclick="handleBtnClick(this)"
                        style="background-color: #9ca3af; color: #ffffff; padding: 12px 40px; font-weight: 700; border: none; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.2s; opacity: 0.6; pointer-events: none;">
                        <span class="btn-label">Update Header</span>
                        <div class="btn-spinner" style="display:none; align-items:center; gap:6px;">
                            <svg style="animation: spin 1s linear infinite; height:16px; width:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Updating...</span>
                        </div>
                    </button>
                </div>
            </div>

            {{-- ===== FOOTER NAVIGATION (Combined Col 2 & Col 3) ===== --}}
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden flex flex-col h-[750px]">
                {{-- Header common for both columns --}}
                <div class="p-6 border-b border-slate-100 bg-emerald-50/50">
                    <div class="flex items-center gap-4">

                        <div>
                            <h2 class="text-base font-bold text-slate-800">Footer Navigation</h2>
                            <p class="text-[11px] text-slate-500 font-medium">কলাম অনুযায়ী ক্যাটাগরিগুলো নির্বাচন করুন</p>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-hidden flex">
                    {{-- Column 2 --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 border-r border-slate-100 custom-scrollbar">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Column 2 (12 slots)</h3>
                        @for($i = 0; $i < 12; $i++)
                        @php $selectedId = $footerCol2Ids[$i] ?? null; @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-6 shrink-0 text-xs font-black text-slate-900">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 relative h-10 border border-slate-200 rounded-xl bg-slate-50/50 overflow-hidden group">
                                <div class="visual-label absolute inset-0 flex items-center justify-between px-4 pointer-events-none z-10">
                                    <span class="text-sm font-black text-slate-900 truncate pr-4">
                                        @php 
                                            $selectedName = '-- empty --';
                                            if($selectedId) {
                                                foreach($categories as $cat) {
                                                    if($cat->id == $selectedId) {
                                                        $selectedName = $cat->name;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $selectedName }}
                                    </span>
                                    <svg class="w-4 h-4 text-black shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 3px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>

                                <select name="footer_col2_categories[]" 
                                    data-column="footer"
                                    class="slot-select absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="var span = this.parentElement.querySelector('span'); span.textContent = this.options[this.selectedIndex].text; checkExclusivity(this); enableBtn('footer-btn');">
                                    <option value="">-- empty --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endfor
                    </div>

                    {{-- Column 3 --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Column 3 (6 slots)</h3>
                        @for($i = 0; $i < 6; $i++)
                        @php $selectedId = $footerCol3Ids[$i] ?? null; @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-6 shrink-0 text-xs font-black text-slate-900">
                                {{ $i + 1 }}
                            </div>
                            <div class="flex-1 relative h-10 border border-slate-200 rounded-xl bg-slate-50/50 overflow-hidden group">
                                <div class="visual-label absolute inset-0 flex items-center justify-between px-4 pointer-events-none z-10">
                                    <span class="text-sm font-black text-slate-900 truncate pr-4">
                                        @php 
                                            $selectedName = '-- empty --';
                                            if($selectedId) {
                                                foreach($categories as $cat) {
                                                    if($cat->id == $selectedId) {
                                                        $selectedName = $cat->name;
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        {{ $selectedName }}
                                    </span>
                                    <svg class="w-4 h-4 text-black shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-width: 3px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>

                                <select name="footer_col3_categories[]" 
                                    data-column="footer"
                                    class="slot-select absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                    onchange="var span = this.parentElement.querySelector('span'); span.textContent = this.options[this.selectedIndex].text; checkExclusivity(this); enableBtn('footer-btn');">
                                    <option value="">-- empty --</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedId == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- Combined Column Footer with Update Button --}}
                <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                    <button type="submit" id="footer-btn"
                        onclick="handleBtnClick(this)"
                        style="background-color: #9ca3af; color: #ffffff; padding: 12px 40px; font-weight: 700; border: none; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: all 0.2s; opacity: 0.6; pointer-events: none;">
                        <span class="btn-label">Update Footer</span>
                        <div class="btn-spinner" style="display:none; align-items:center; gap:6px;">
                            <svg style="animation: spin 1s linear infinite; height:16px; width:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle style="opacity:0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path style="opacity:0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Updating...</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        {{-- Floating Save Button - Adjusted for Sidebar Offset --}}
        <div class="fixed bottom-10 left-0 md:left-64 right-0 z-40 flex justify-center pointer-events-none lg:hidden">
            <div class="bg-white/90 backdrop-blur-xl border border-slate-200 p-2.5 rounded-3xl shadow-2xl pointer-events-auto flex items-center gap-3">
                <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-sm font-black shadow-xl shadow-indigo-200 dark:shadow-none transition-all active:scale-95 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
function handleBtnClick(btn) {
    // Don't set disabled=true — it blocks form submit!
    // Just visually show loading state
    btn.style.pointerEvents = 'none';
    btn.style.opacity = '0.8';
    btn.querySelector('.btn-label').style.display = 'none';
    const spinner = btn.querySelector('.btn-spinner');
    spinner.style.display = 'flex';
}

function enableBtn(btnId) {
    const btn = document.getElementById(btnId);
    if (!btn) return;
    btn.style.backgroundColor = '#000000';
    btn.style.cursor = 'pointer';
    btn.style.opacity = '1';
    btn.style.pointerEvents = 'auto';
}

function updateVisualLabel(select) {
    const span = select.parentElement.querySelector('span');
    const selectedOption = select.options[select.selectedIndex];
    if (span) {
        span.textContent = selectedOption.text;
    }
}

function checkExclusivity(currentSelect) {
    const selectedValue = currentSelect.value;
    if (!selectedValue) return;

    const isHeader = currentSelect.name === 'header_categories[]';
    
    // Determine which selects to check against
    let selectsToCheck;
    if (isHeader) {
        // Only check other header selects
        selectsToCheck = document.querySelectorAll('select[name="header_categories[]"]');
    } else {
        // Footer Col 2 and Col 3 are mutual: check both
        selectsToCheck = document.querySelectorAll('select[name="footer_col2_categories[]"], select[name="footer_col3_categories[]"]');
    }

    selectsToCheck.forEach(select => {
        if (select === currentSelect) return;
        if (select.value === selectedValue) {
            select.value = "";
            // Sync visual label for cleared fields
            const span = select.parentElement.querySelector('span');
            if (span) span.textContent = '-- empty --';
            
            // Shake effect
            select.parentElement.classList.add('animate-shake');
            setTimeout(() => select.parentElement.classList.remove('animate-shake'), 500);
        }
    });
}
</script>
<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}
.animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
</style>
@endpush
@endsection
