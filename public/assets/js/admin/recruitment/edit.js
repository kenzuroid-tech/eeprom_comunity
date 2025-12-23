document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('timeline-container');
    const addBtn = document.getElementById('add-timeline-btn');

    /**
     * Fungsi untuk memperbarui penomoran step secara otomatis
     */
    function updateStepNumbers() {
        const items = container.querySelectorAll('.timeline-item');
        items.forEach((item, index) => {
            const stepLabel = item.querySelector('span');
            if (stepLabel) {
                stepLabel.innerText = `Step ${index + 1}`;
            }
        });
    }

    /**
     * Handler untuk menambah baris timeline baru
     */
    addBtn.addEventListener('click', function() {
        const newStep = document.createElement('div');
        newStep.className = 'timeline-item';
        newStep.innerHTML = `
            <span class="fw-bold text-primary me-2">Step</span>
            <input type="text" class="form-control" name="timeline[]" placeholder="Nama tahap seleksi...">
            <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-step">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newStep);
        updateStepNumbers();
    });

    /**
     * Handler untuk menghapus baris timeline (menggunakan event delegation)
     */
    container.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-step');
        if (removeBtn) {
            const allItems = container.querySelectorAll('.timeline-item');
            // Mencegah penghapusan jika hanya tersisa 1 step
            if (allItems.length > 1) {
                removeBtn.closest('.timeline-item').remove();
                updateStepNumbers();
            } else {
                alert("Minimal harus ada satu tahap seleksi.");
            }
        }
    });
});