document.addEventListener('DOMContentLoaded', function () {
    const nimInput = document.getElementById('nim');
    const emailInput = document.getElementById('email');
    const registerForm = document.getElementById('registerForm');

    // SIMULASI AUTO-FILL EMAIL BERDASARKAN NIM
    // Dalam PHP/Backend nyata, ini bisa menggunakan AJAX ke database recruitment
    nimInput.addEventListener('input', function () {
        const nimValue = this.value;

        // Contoh: Jika NIM diisi 10 digit, simulasikan pencarian data accepted
        if (nimValue.length >= 10) {
            emailInput.value = "mhs_" + nimValue + "@polinema.ac.id";
            emailInput.style.backgroundColor = "#e8f5e9"; // Feedback visual sukses
        } else {
            emailInput.value = "";
            emailInput.style.backgroundColor = "#f1f3f9";
        }
    });

    // Form Submit Logic
    registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm_password').value;
        const email = emailInput.value;

        // Validasi sederhana
        if (!email) {
            alert("NIM tidak ditemukan dalam data kelolosan recruitment kami.");
            return;
        }

        if (password.length < 8) {
            alert("Password harus minimal 8 karakter!");
            return;
        }

        if (password !== confirm) {
            alert("Konfirmasi password tidak cocok!");
            return;
        }

        // Jika valid
        alert("Registrasi Berhasil! Silakan login untuk masuk ke dashboard anggota.");
        window.location.href = "login.php";
    });
});
