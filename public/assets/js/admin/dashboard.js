document.addEventListener('DOMContentLoaded', function() {
    // Dropdown Menu Toggle
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling;
            const isOpen = dropdownMenu.classList.contains('show');
            
            // Toggle class show
            dropdownMenu.classList.toggle('show');
            
            // Rotate Chevron Icon
            const icon = this.querySelector('.bi-chevron-down');
            if(icon) {
                icon.style.transition = 'transform 0.3s ease';
                icon.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if(mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 992 && 
                !sidebar.contains(e.target) && 
                !mobileBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
});