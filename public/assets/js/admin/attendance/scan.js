document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('attendanceForm');
    const formCard = document.getElementById('form-card');
    const successOverlay = document.getElementById('success-overlay');
    const nimInput = document.getElementById('nimInput');
    const nameSelect = document.getElementById('nameSelect');

    // Toggle logic: Jika NIM diisi, Dropdown dikosongkan (optional UX)
    nimInput.addEventListener('input', function () {
        if (this.value.length > 0) {
            nameSelect.required = false;
        } else {
            nameSelect.required = true;
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Simulasikan validasi frontend
        const selectedName = nameSelect.options[nameSelect.selectedIndex].text;
        const nim = nimInput.value;
        const finalIdentity = nim ? `NIM: ${nim}` : selectedName;

        // Animasi sederhana transisi ke sukses
        formCard.style.display = 'none';
        successOverlay.style.display = 'block';

        // Update detail sukses
        document.getElementById('res-name').innerText = finalIdentity;

        const now = new Date();
        const timeString = now.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
        document.getElementById('res-time').innerText = timeString + " WIB";
    });
});
