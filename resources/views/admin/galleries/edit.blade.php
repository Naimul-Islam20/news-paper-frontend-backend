@extends('admin.layout')

@section('title', 'Edit Gallery')
@section('header_title', 'Edit Gallery')

@section('content')
<div class="py-1 w-full mx-auto">
    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="max-w-4xl mx-auto space-y-6">
            {{-- Section 1: Gallery Info --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Gallery Information
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Gallery Title <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" required value="{{ old('title', $gallery->title) }}" placeholder="Enter gallery title..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black">
                                @error('title') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Gallery Description</label>
                                <textarea name="description" rows="4" placeholder="Enter gallery description..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none">{{ old('description', $gallery->description) }}</textarea>
                                @error('description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Category <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                        <option value="" disabled>Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $gallery->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('category_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Reporter ধরন/ডেস্ক <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <select name="reporter_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                        <option value="">-- Reporter ধরন / ডেস্ক নির্বাচন করুন --</option>
                                        @foreach($reporters as $reporter)
                                        <option value="{{ $reporter->id }}" {{ old('reporter_id', $gallery->reporter_id) == $reporter->id ? 'selected' : '' }}>{{ $reporter->desk ?: $reporter->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('reporter_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-normal text-black mb-1 ml-0.5 uppercase tracking-wide">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none appearance-none font-medium cursor-pointer text-black">
                                        <option value="active" {{ old('status', $gallery->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $gallery->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section 2: Existing Images – একইভাবে ইমেজ ও বর্ণনা পরিবর্তন করা যাবে --}}
            @if($gallery->images->count() > 0)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Existing Images ({{ $gallery->images->count() }}) – ইমেজ বা বর্ণনা পরিবর্তন করুন
                </h3>
                <div class="space-y-4">
                    @foreach($gallery->images as $img)
                    <div class="relative group rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 bg-slate-50/50 dark:bg-slate-950/30">
                        <div class="absolute z-10 opacity-0 group-hover:opacity-100 transition-opacity" style="top: 0.75rem; right: 0.75rem; left: auto; direction: ltr;">
                            <form action="{{ route('admin.galleries.images.destroy', $img->id) }}" method="POST" class="inline-block delete-existing-image-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="p-1.5 bg-rose-500 text-white rounded-full shadow-md hover:bg-rose-600 transition-colors delete-existing-image-btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                            <div class="md:col-span-4">
                                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image (পরিবর্তন করতে নতুন ছবি চয়ন করুন)</label>
                                <div class="relative h-32 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col items-center justify-center gap-1.5 overflow-hidden shadow-inner">
                                    <input type="file" name="existing_image[{{ $img->id }}]" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewExistingImage(this, {{ $img->id }})">
                                    <img id="existing-preview-{{ $img->id }}" src="{{ Storage::url($img->image) }}" class="absolute inset-0 w-full h-full object-cover" alt="">
                                    <div id="existing-placeholder-{{ $img->id }}" class="hidden absolute inset-0 flex flex-col items-center justify-center gap-1.5 bg-slate-100 text-slate-500 text-[10px] uppercase">
                                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Choose Image</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-8 flex flex-col justify-center">
                                <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image Description</label>
                                <textarea name="existing_image_desc[{{ $img->id }}]" rows="4" placeholder="ছবির বর্ণনা (খালি রাখতে পারেন)..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none h-[128px]">{{ old('existing_image_desc.'.$img->id, $img->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Section 3: Add More Images --}}
            <div id="image-list" class="space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 relative group">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Add New Images</h3>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                        <div class="md:col-span-4">
                            <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image</label>
                            <div class="relative h-32 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1.5 group/box hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px]">
                                <input type="file" name="images[]" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                                <img src="" class="absolute inset-0 w-full h-full object-cover hidden preview-img">
                                <div class="placeholder flex flex-col items-center justify-center gap-1.5">
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Choose Image</span>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-8 flex flex-col justify-center">
                            <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image Description</label>
                            <textarea name="image_desc[]" rows="4" placeholder="Enter image description..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none h-[128px]"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Add More Button --}}
            <div class="flex justify-center">
                <button type="button" onclick="addImageRow()" class="flex items-center gap-2 px-6 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-indigo-600 dark:text-indigo-400 font-bold text-xs uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                    <svg class="w-4 h-4 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Another Image & Desc
                </button>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 pt-6 pb-12">
                <a href="{{ route('admin.galleries.index') }}" class="px-8 py-2.5 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 font-bold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all text-sm">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-100 dark:shadow-none text-sm">
                    Update Gallery
                </button>
            </div>
        </div>
    </form>

    {{-- Delete row confirmation modal --}}
    <div id="deleteRowModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 p-4" aria-hidden="true">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-md w-full p-6 text-center">
            <p class="text-lg font-semibold text-slate-800 dark:text-white mb-2">আপনি কি সত্যিই মুছতে চান?</p>
            <p class="text-sm text-slate-600 dark:text-slate-300 mb-6">এই ইমেজ ও বর্ণনা রিমুভ হয়ে যাবে।</p>
            <div class="flex gap-3 justify-center">
                <button type="button" onclick="closeDeleteRowModal()" class="px-5 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl text-slate-700 dark:text-slate-200 font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition">বাতিল</button>
                <button type="button" id="confirmDeleteRowBtn" class="px-5 py-2.5 bg-rose-600 text-white rounded-xl font-medium hover:bg-rose-700 transition">হ্যাঁ, মুছুন</button>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const parent = input.closest('.relative');
                const preview = parent.querySelector('.preview-img');
                const placeholder = parent.querySelector('.placeholder');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewExistingImage(input, id) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('existing-preview-' + id);
                const placeholder = document.getElementById('existing-placeholder-' + id);
                if (preview) {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function addImageRow() {
        const container = document.getElementById('image-list');
        const newRow = document.createElement('div');
        newRow.className = "bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 relative group animate-in fade-in zoom-in duration-300";

        newRow.innerHTML = `
            <div class="absolute z-10 opacity-0 group-hover:opacity-100 transition-all" style="top: 0; right: 0.5rem; left: auto; direction: ltr;">
                <button type="button" class="p-1.5 bg-rose-500 text-white rounded-full shadow-lg hover:bg-rose-600 transition-colors delete-row-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <div class="md:col-span-4">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image</label>
                    <div class="relative h-32 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex flex-col items-center justify-center gap-1.5 group/box hover:bg-slate-100 transition-all cursor-pointer overflow-hidden shadow-inner font-normal text-black uppercase tracking-widest text-[10px]">
                        <input type="file" name="images[]" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this)">
                        <img src="" class="absolute inset-0 w-full h-full object-cover hidden preview-img">
                        <div class="placeholder flex flex-col items-center justify-center gap-1.5">
                            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Choose Image</span>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-8 flex flex-col justify-center">
                    <label class="block text-[10px] font-bold text-slate-400 mb-1.5 uppercase tracking-widest ml-1 text-black">Image Description</label>
                    <textarea name="image_desc[]" rows="4" placeholder="Enter image description..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-sm focus:ring-2 focus:ring-indigo-500 transition-all outline-none font-normal text-black resize-none h-[128px]"></textarea>
                </div>
            </div>
        `;
        container.appendChild(newRow);
        var btn = newRow.querySelector('.delete-row-btn');
        if (btn) btn.addEventListener('click', function() {
            showDeleteRowModal(newRow);
        });
    }

    var rowToDelete = null;
    var formToDelete = null;

    function showDeleteRowModal(row) {
        rowToDelete = row;
        formToDelete = null;
        var modal = document.getElementById('deleteRowModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function showDeleteExistingImageModal(form) {
        formToDelete = form;
        rowToDelete = null;
        var modal = document.getElementById('deleteRowModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeDeleteRowModal() {
        rowToDelete = null;
        formToDelete = null;
        var modal = document.getElementById('deleteRowModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    document.getElementById('confirmDeleteRowBtn').addEventListener('click', function() {
        if (rowToDelete) rowToDelete.remove();
        if (formToDelete) formToDelete.submit();
        closeDeleteRowModal();
    });
    document.querySelectorAll('.delete-existing-image-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            showDeleteExistingImageModal(this.closest('form'));
        });
    });
</script>
@endsection