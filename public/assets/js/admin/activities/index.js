document.addEventListener('DOMContentLoaded', function() {
    /**
     * Dropdown Toggle Logic
     * Menangani buka/tutup menu bertingkat di sidebar
     */
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling;
            const icon = this.querySelector('.bi-chevron-down');
            
            // Toggle visibility dropdown
            dropdownMenu.classList.toggle('show');
            
            // Animasi rotasi icon panah
            if(icon) {
                const isShown = dropdownMenu.classList.contains('show');
                icon.style.transform = isShown ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
            }
        });
    });

    /**
     * Mobile Sidebar Toggle
     * Menangani penampilan sidebar pada layar kecil/mobile
     */
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if(mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Menutup sidebar jika mengklik di luar area saat mode mobile (Opsional)
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnMobileBtn = mobileBtn.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickOnMobileBtn && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });
});