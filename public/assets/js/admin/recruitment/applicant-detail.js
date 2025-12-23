document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk mobile menu toggle
    const sidebar = document.getElementById('sidebarMenu');
    
    // Anda bisa menambahkan logic jika tombol mobile menu diklik (id: mobile-toggle)
    // script ini bersifat placeholder untuk kebutuhan interactivity di masa depan
    console.log("Applicant Detail Loaded");

    // Contoh: Konfirmasi sebelum menghapus aplikasi
    const deleteBtn = document.querySelector('.btn-link.text-danger');
    if(deleteBtn) {
        deleteBtn.addEventListener('click', function(e) {
            if(!confirm('Apakah Anda yakin ingin menghapus data pelamar ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    }
});