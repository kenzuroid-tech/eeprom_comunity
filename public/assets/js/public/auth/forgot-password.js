
document.getElementById('forgotForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const submitBtn = document.getElementById('submitBtn');
    const successAlert = document.getElementById('successAlert');

    // Simulasi loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...`;

    // Simulasi proses pengiriman (Frontend Only)
    setTimeout(() => {
        // Tampilkan pesan sukses
        successAlert.style.display = 'block';

        // Reset tombol
        submitBtn.disabled = false;
        submitBtn.innerHTML = `<span>Resend Link</span> <i class="bi bi-arrow-repeat"></i>`;

        // Clear input
        document.getElementById('email').value = '';

        console.log("Reset link requested for: " + email);
    }, 1500);
});
