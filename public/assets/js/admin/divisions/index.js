document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobile-toggle');
    const sidebar = document.getElementById('sidebarMenu');
    
    if(mobileBtn && sidebar) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }

    // 2. Slug Generator
    // Berguna untuk otomatis membuat URL friendly dari input nama divisi
    const nameInput = document.getElementById('nameIn');
    const slugInput = document.getElementById('slugIn');
    
    if(nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/ /g, '-')             // Spasi jadi dash
                .replace(/[^\w-]+/g, '')        // Hapus karakter non-alnum
                .replace(/-+/g, '-');           // Hapus dash ganda
            slugInput.value = slug;
        });
    }

    // 3. Dynamic Mission Fields (Opsional)
    // Menambahkan field input misi secara dinamis di modal
    const addMisiBtn = document.querySelector('[onclick="addMisiField()"]'); // Jika Anda menambahkan onclick
    // Anda bisa menambahkan logika tambah field input di sini jika diperlukan.

});