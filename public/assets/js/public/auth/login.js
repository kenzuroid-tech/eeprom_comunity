document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const identifier = document.getElementById('identifier').value;
    const password = document.getElementById('password').value; // Dalam realita, cek ke database

    // SIMULASI LOGIKA REDIRECT (FRONTEND ONLY)
    // Ini hanya simulasi untuk menunjukkan cara kerja role-based redirect

    if (identifier === "admin") {
        alert("Login Berhasil sebagai Admin!");
        window.location.href = "/admin/dashboard.php";
    } else if (identifier === "member") {
        alert("Login Berhasil sebagai Anggota!");
        window.location.href = "/member/dashboard.php";
    } else if (identifier.includes("@") || identifier.length > 5) {
        // Simulasi user terdaftar tapi bukan admin/anggota khusus
        alert("Login Berhasil!");
        window.location.href = "/member/dashboard.php";
    } else {
        alert("User tidak terdaftar. Mengalihkan ke halaman publik.");
        window.location.href = "/";
    }
});
