document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkBar = document.getElementById('bulkBar');
    const selectedCount = document.getElementById('selectedCount');

    // Fungsi untuk memunculkan/menghilangkan bar aksi massal
    function toggleBulkBar() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkBar.style.display = 'block';
            selectedCount.innerText = checkedCount;
        } else {
            bulkBar.style.display = 'none';
        }
    }

    // Event listener untuk checkbox "Pilih Semua"
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            rowCheckboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            toggleBulkBar();
        });
    }

    // Event listener untuk tiap checkbox di baris tabel
    rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', toggleBulkBar);
    });

    // Simulasi tombol filter (Opsional)
    const filterForm = document.querySelector('form');
    filterForm.addEventListener('submit', function(e) {
        // Logika filter AJAX bisa diletakkan di sini
        console.log('Filtering data...');
    });
});