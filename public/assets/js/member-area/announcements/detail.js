document.addEventListener('DOMContentLoaded', function () {
    // Mobile Sidebar Toggle (Matched logic from dashboard.html)
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Optional: Close sidebar when clicking outside on mobile
    window.addEventListener('click', (e) => {
        if (window.innerWidth <= 992 && !sidebar.contains(e.target) && e.target !== mobileBtn && !mobileBtn.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
});
