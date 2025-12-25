document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Dropdown Toggle (Identik Dashboard)
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const dropdown = this.nextElementSibling;
            dropdown.classList.toggle('show');
            const icon = this.querySelector('.bi-chevron-down');
            if (icon) icon.style.transform = dropdown.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    });

    // Mobile Toggle
    document.getElementById('mobile-toggle').addEventListener('click', () => {
        document.getElementById('sidebarMenu').classList.toggle('show');
    });

    // Simulasi Kondisi Guardrail (Ada Votes Masuk)
    const isVoted = true;
    if (isVoted) {
        document.getElementById('votedWarning').style.display = 'inline-block';
        document.getElementById('startWarning').style.display = 'block';

        // Kunci field yang tidak boleh diedit
        document.getElementById('electionName').readOnly = true;
        document.getElementById('electionDescription').readOnly = true;
        document.getElementById('startDate').disabled = true;
        document.getElementById('status').disabled = true;
        document.getElementById('allActiveMembers').disabled = true;
        document.querySelectorAll('.generasi-checkbox').forEach(cb => cb.disabled = true);

        // End date tetap aktif untuk perpanjangan
        document.getElementById('endDate').classList.add('border-warning');
    }

    // Eligible Voters Logic
    const allActiveCheck = document.getElementById('allActiveMembers');
    const genCheckboxes = document.querySelectorAll('.generasi-checkbox');
    allActiveCheck.addEventListener('change', function () {
        genCheckboxes.forEach(cb => {
            cb.disabled = this.checked;
            if (this.checked) cb.checked = false;
        });
    });

    // Submit Handling
    document.getElementById('electionForm').addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Update berhasil disimpan (Simulasi Frontend).');
    });
});
