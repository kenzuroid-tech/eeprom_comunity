document.addEventListener('DOMContentLoaded', function () {
    // Dropdown Menu Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            this.nextElementSibling.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if (icon) {
                icon.style.transform = this.nextElementSibling.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }
});