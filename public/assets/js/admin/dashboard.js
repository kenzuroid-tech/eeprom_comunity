document.addEventListener('DOMContentLoaded', function() {
    
    // LOGIKA DROPDOWN (Event Delegation)
    document.addEventListener('click', function(e) {
        // Mencari apakah elemen yang diklik adalah .dropdown-btn atau ada di dalamnya
        const btn = e.target.closest('.dropdown-btn');
        
        if (btn) {
            // Mencegah navigasi default
            e.preventDefault();
            e.stopPropagation();

            // Ambil elemen dropdown berikutnya
            const menu = btn.nextElementSibling;
            const icon = btn.querySelector('.bi-chevron-down');
            
            console.log('Button clicked:', btn); // Debug
            console.log('Menu found:', menu); // Debug
            console.log('Icon found:', icon); // Debug
            
            if (menu && menu.classList.contains('nav-dropdown-items')) {
                // Toggle class 'show'
                const isNowOpen = menu.classList.toggle('show');
                
                console.log('Dropdown is now:', isNowOpen ? 'OPEN' : 'CLOSED'); // Debug
                
                // Putar ikon panah 180 derajat
                if (icon) {
                    icon.style.transform = isNowOpen ? 'rotate(180deg)' : 'rotate(0deg)';
                }
                
                // Tambahkan class active pada tombol saat terbuka
                if (isNowOpen) {
                    btn.classList.add('active');
                } else {
                    // Hanya hapus 'active' jika tidak ada sub-menu yang aktif
                    const hasActiveChild = menu.querySelector('.nav-link.active');
                    if (!hasActiveChild) {
                        btn.classList.remove('active');
                    }
                }
            } else {
                console.error('Menu dropdown tidak ditemukan!'); // Debug
            }
        }
    });

    // LOGIKA SIDEBAR MOBILE
    const mobileToggle = document.getElementById('mobile-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            sidebar.classList.toggle('show');
        });
    }

    // Klik di luar sidebar untuk menutup (khusus mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992 && sidebar && sidebar.classList.contains('show')) {
            if (!sidebar.contains(e.target) && e.target !== mobileToggle) {
                sidebar.classList.remove('show');
            }
        }
    });

    // AUTO-ROTATE chevron untuk dropdown yang sudah .show (dari PHP)
    document.querySelectorAll('.nav-dropdown-items.show').forEach(function(menu) {
        const btn = menu.previousElementSibling;
        if (btn && btn.classList.contains('dropdown-btn')) {
            const icon = btn.querySelector('.bi-chevron-down');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    });

    console.log('Dashboard.js loaded successfully!'); // Debug
});