// Logic untuk mendemonstrasikan mode (frontend only)
function switchMode(mode) {
    document.querySelectorAll('.voting-section').forEach(s => s.classList.add('d-none'));
    document.getElementById('section-' + mode).classList.remove('d-none');
}

// Jalankan mode aktif sebagai default
switchMode('active');

function confirmVote() {
    const selected = document.querySelector('input[name="candidate"]:checked');
    if (!selected) {
        alert("Silakan pilih salah satu kandidat terlebih dahulu!");
        return;
    }
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
}

function submitVote() {
    bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
    switchMode('voted');
}

document.getElementById('mobile-toggle').addEventListener('click', () => {
    document.getElementById('sidebarMenu').classList.toggle('show');
});
