<script>
    (function() {
        var key = 'admin-color-mode';
        var mode = localStorage.getItem(key) || 'system';
        var isDark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (isDark) {
            document.documentElement.classList.add('dark');
        }
    })();
</script>
