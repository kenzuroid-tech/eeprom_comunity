document.addEventListener('DOMContentLoaded', function () {
    // Dropdown Menu Toggle (Identik Dashboard)
    const dropdownBtns = document.querySelectorAll('.dropdown-btn');
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const dropdownItems = this.nextElementSibling;
            dropdownItems.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if (icon) {
                icon.style.transform = dropdownItems.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });
    });

    // Mobile Sidebar Toggle
    document.getElementById('mobile-toggle').addEventListener('click', () => {
        document.getElementById('sidebarMenu').classList.toggle('show');
    });

    // Eligible Voters Logic
    const allActiveCheck = document.getElementById('allActiveMembers');
    const genCheckboxes = document.querySelectorAll('#generasiFilterGroup input');

    allActiveCheck.addEventListener('change', function () {
        genCheckboxes.forEach(cb => {
            cb.disabled = this.checked;
            if (this.checked) cb.checked = false;
        });
    });
    allActiveCheck.dispatchEvent(new Event('change'));

    // Form Submit Simulation
    document.getElementById('electionForm').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Sesi pemilihan berhasil dibuat (Simulasi Frontend).');
    });
});
