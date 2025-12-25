document.addEventListener('DOMContentLoaded', function () {
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            this.nextElementSibling.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if (icon) icon.style.transform = this.nextElementSibling.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    });
    const mobileBtn = document.getElementById('mobile-toggle');
    if (mobileBtn) mobileBtn.addEventListener('click', () => document.getElementById('sidebarMenu').classList.toggle('show'));
});
