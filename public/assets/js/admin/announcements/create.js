document.addEventListener('DOMContentLoaded', function () {
    // Dropdown Toggle Logic (Fixed)
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const dropdownMenu = this.nextElementSibling;
            const icon = this.querySelector('.bi-chevron-down');

            dropdownMenu.classList.toggle('show');

            if (icon) {
                icon.style.transform = dropdownMenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
                icon.style.transition = 'transform 0.3s ease';
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