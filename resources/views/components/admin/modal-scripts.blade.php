@once
    @push('scripts')
        <script>
            function openModal(modalId, containerId) {
                const modal = document.getElementById(modalId);
                const container = document.getElementById(containerId);
                if (!modal || !container) return;
                modal.classList.remove('hidden');
                setTimeout(function() {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal(modalId, containerId) {
                const modal = document.getElementById(modalId);
                const container = document.getElementById(containerId);
                if (!modal || !container) return;
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(function() {
                    modal.classList.add('hidden');
                }, 300);
            }

            /** মোডালের বাইরে (অর্ধ-স্বচ্ছ এলাকা / প্যাডিং) ক্লিক করলে বন্ধ */
            function modalBackdropClose(event, modalId, containerId) {
                if (event.target === event.currentTarget) {
                    closeModal(modalId, containerId);
                }
            }
        </script>
    @endpush
@endonce
