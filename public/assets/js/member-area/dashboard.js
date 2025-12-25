document.addEventListener('DOMContentLoaded', function() {
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if(mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        // Klik di luar sidebar untuk menutup (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992 && 
                !sidebar.contains(e.target) && 
                !mobileBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
});