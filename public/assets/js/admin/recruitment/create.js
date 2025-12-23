document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('timeline-container');
    const addBtn = document.getElementById('add-timeline-btn');

    /**
     * Mengatur ulang nomor langkah (Step 1, Step 2, dst) 
     * setiap kali ada penambahan atau penghapusan.
     */
    function updateStepNumbers() {
        const items = container.querySelectorAll('.timeline-item');
        items.forEach((item, index) => {
            const label = item.querySelector('span');
            if (label) {
                label.innerText = `Step ${index + 1}`;
            }
        });
    }

    // Event penambahan tahap baru
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

    // Event penghapusan tahap (menggunakan event delegation)
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-step')) {
            const items = container.querySelectorAll('.timeline-item');
            if (items.length > 1) {
                e.target.closest('.timeline-item').remove();
                updateStepNumbers();
            } else {
                alert("Minimal harus ada satu tahap seleksi.");
            }
        }
    });
});