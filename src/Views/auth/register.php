<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/public/auth/register.css">
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">
            <div class="logo-wrapper">
                <img src="/assets/images/eeprom logo.png" alt="Logo"
                    onerror="this.src='https://via.placeholder.com/60?text=EEPROM'">
                <!-- <h3>EEPROM<span> POLINEMA</span></h3> -->
            </div>

            <h4 class="text-center fw-bold mb-2" style="color: var(--dark-text);">Pendaftaran Akun</h4>
            <!-- <p class="text-center text-muted small mb-4">Khusus calon anggota yang telah diterima</p> -->

            <div class="info-box">
                <i class="bi bi-info-circle-fill me-2"></i>
                Masukkan NIM Anda. Jika data Anda ada di sistem recruitment kami, Email akan terisi secara otomatis.
            </div>

            <form id="registerForm">
                <div class="mb-3">
                    <label for="nim" class="form-label">NIM (Nomor Induk Mahasiswa)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-card-text text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" id="nim" placeholder="Contoh: 2241720000"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0" id="email"
                            placeholder="email@gmail.com" readonly>
                    </div>
                    <div id="emailHelp" class="form-text" style="font-size: 0.7rem;">Email terkunci sesuai data
                        pendaftaran recruitment.</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Min. 8 karakter"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi</label>
                        <input type="password" class="form-control" id="confirm_password" placeholder="Ulangi password"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-register">Buat Akun Sekarang</button>

                <div class="text-center mt-4 small">
                    Sudah punya akun? <a href="/login" class="login-link">Login di sini</a>
                </div>
            </form>
        </div>

        <div class="footer-text">
            © 2025 EEPROM POLINEMA
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/public/auth/register.js"></script>
</body>

</html>