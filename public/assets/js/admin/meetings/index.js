document.addEventListener('DOMContentLoaded', function() {
    // Dropdown Menu Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdownItems = this.nextElementSibling;
            dropdownItems.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if(icon) {
                // Rotasi icon panah
                if (dropdownItems.classList.contains('show')) {
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    icon.style.transform = 'rotate(0deg)';
                }
                icon.style.transition = '0.3s ease';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if(mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Menutup sidebar jika mengklik di luar area sidebar (Mobile mode)
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(event.target) && !mobileBtn.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
});