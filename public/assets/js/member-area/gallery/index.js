document.addEventListener('DOMContentLoaded', function () {
    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    if (mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 992 && !sidebar.contains(e.target) && !mobileBtn.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
});

// Lightbox Logic
function openLightbox(imgUrl, title) {
    const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
    document.getElementById('lightboxImg').src = imgUrl;
    document.getElementById('lightboxTitle').innerText = title;
    modal.show();
}
