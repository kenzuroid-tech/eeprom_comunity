document.addEventListener('DOMContentLoaded', function () {
    /**
     * 1. Dropdown Menu Toggle
     * Menangani navigasi yang memiliki sub-menu di sidebar
     */
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const dropdownItems = this.nextElementSibling;
            const chevron = this.querySelector('.bi-chevron-down');
            
            // Toggle visibility sub-menu
            dropdownItems.classList.toggle('show');
            
            // Putar icon panah (chevron)
            if (chevron) {
                if (dropdownItems.classList.contains('show')) {
                    chevron.style.transform = 'rotate(180deg)';
                } else {
                    chevron.style.transform = 'rotate(0deg)';
                }
                chevron.style.transition = 'transform 0.3s ease';
            }
        });
    });

    /**
     * 2. Mobile Sidebar Toggle
     * Menangani tombol menu (hamburger) pada layar HP/Tablet
     */
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if (mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', function (e) {
            e.stopPropagation(); // Mencegah event bubbling
            sidebar.classList.toggle('show');
        });

        // Klik di luar sidebar untuk menutup sidebar (khusus mobile)
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(e.target) && !mobileBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }

    /**
     * 3. Checkbox Bulk Action (Khusus Halaman Member)
     * Menangani fitur "Select All" dan tombol hapus massal
     */
    const checkAll = document.getElementById('checkAll');
    const itemChecks = document.querySelectorAll('.item-check');
    const bulkDelete = document.getElementById('bulkDelete');
    const bulkAlumni = document.getElementById('bulkAlumni');

    if (checkAll) {
        // Event saat checkbox "Master" diklik
        checkAll.addEventListener('change', function () {
            itemChecks.forEach(check => {
                check.checked = this.checked;
            });
            updateBulkButtons();
        });

        // Event saat salah satu checkbox anggota diklik
        itemChecks.forEach(check => {
            check.addEventListener('change', function() {
                // Jika satu checkbox dilepas, uncheck "Master"
                if (!this.checked) {
                    checkAll.checked = false;
                }
                // Jika semua checkbox terpilih manual, check "Master"
                const allChecked = Array.from(itemChecks).every(c => c.checked);
                if (allChecked) checkAll.checked = true;
                
                updateBulkButtons();
            });
        });
    }

    // Fungsi untuk mengaktifkan/mematikan tombol bulk action
    function updateBulkButtons() {
        if (bulkDelete && bulkAlumni) {
            const checkedCount = Array.from(itemChecks).filter(c => c.checked).length;
            const isAnyChecked = checkedCount > 0;
            
            bulkDelete.disabled = !isAnyChecked;
            bulkAlumni.disabled = !isAnyChecked;
        }
    }
});