@extends('admin.layout')

@section('title', 'Gallery')
@section('header_title', 'Gallery')

@section('content')
<div class="py-1 w-full mx-auto">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-4">
        <div class="flex items-center justify-between pb-6 border-b border-slate-100 dark:border-slate-800 mb-8">
            <div class="relative w-full max-w-sm flex items-center">
                <input type="text" placeholder="Search gallery..." class="w-full pl-10 pr-10 py-2 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black dark:text-white">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <button type="button" class="absolute right-2 p-1 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors rounded-lg hover:bg-slate-200 dark:hover:bg-slate-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-normal rounded-xl transition-all shadow-sm text-sm shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Img
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse border-x border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                    <tr class="border-y border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Name</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Image</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Category</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider">Date/Time</th>
                        <th class="py-3 px-4 text-[11px] font-bold text-black dark:text-slate-300 uppercase tracking-wider text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    {{-- Placeholder Row 1 --}}
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors">Election Banner 2024</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="h-12 w-20 rounded-lg bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden relative">
                                <svg class="w-6 h-6 text-slate-400 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-xs font-normal text-black dark:text-slate-400">Politics</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-xs font-normal text-black dark:text-slate-400">24 Oct 2023</div>
                            <div class="text-[10px] font-normal text-slate-400">11:45 AM</div>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.galleries.edit') }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    {{-- Placeholder Row 2 --}}
                    <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors border-b border-slate-200 dark:border-slate-700 divide-x divide-slate-200 dark:divide-slate-700">
                        <td class="py-3 px-4">
                            <div class="text-sm font-normal text-black dark:text-white group-hover:text-indigo-600 transition-colors">World Cup Opening</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="h-12 w-20 rounded-lg bg-slate-100 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden relative">
                                <svg class="w-6 h-6 text-slate-400 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="text-xs font-normal text-black dark:text-slate-400">Sports</span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                Inactive
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-xs font-normal text-black dark:text-slate-400">01 Nov 2023</div>
                            <div class="text-[10px] font-normal text-slate-400">06:00 PM</div>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.galleries.edit') }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

{{-- Edit Gallery Modal --}}
<div id="editGalleryModal" class="fixed inset-0 z-50 hidden">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>
    
    {{-- Modal Content --}}
    <div class="fixed inset-0 flex items-center justify-center p-4" onclick="if(event.target === this) closeEditModal()">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 transition-all scale-95 opacity-0 duration-300" id="editModalContainer">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Edit Gallery Information</h3>
                    <p class="text-[11px] text-slate-500 mt-0.5 uppercase tracking-wider font-normal">Update the gallery basic details.</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <form action="#" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-widest text-black">Gallery Title</label>
                    <input type="text" value="Election Banner 2024" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none text-black font-normal">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-widest text-black">Category</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                <option value="politics" selected>Politics</option>
                                <option value="sports">Sports</option>
                                <option value="entertainment">Entertainment</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-700 dark:text-slate-300 mb-2 uppercase tracking-widest text-black">Status</label>
                        <div class="relative">
                            <select class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeEditModal()" class="flex-1 px-5 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-[10px] uppercase tracking-widest text-black">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-[10px] uppercase tracking-widest leading-none">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalId, containerId, action) {
        const modal = document.getElementById(modalId);
        const container = document.getElementById(containerId);
        if(!modal || !container) return;
        
        if (action === 'open') {
            modal.classList.remove('hidden');
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            container.classList.remove('scale-100', 'opacity-100');
            container.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    function openEditModal() { toggleModal('editGalleryModal', 'editModalContainer', 'open'); }
    function closeEditModal() { toggleModal('editGalleryModal', 'editModalContainer', 'close'); }
</script>
@endsection
