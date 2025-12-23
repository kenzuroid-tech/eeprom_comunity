document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Dropdown Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
            
            const icon = this.querySelector('.bi-chevron-down');
            if(icon) {
                icon.style.transform = dropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if(mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Menutup sidebar jika mengklik di luar area pada tampilan mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !mobileBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
});