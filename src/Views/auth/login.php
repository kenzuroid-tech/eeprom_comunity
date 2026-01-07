<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/public/auth/login.css">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="logo-wrapper">
                <img src="/assets/images/eeprom_logo.png" alt="EEPROM Logo" class="logo-image">
            </div>
            <h4 class="text-center fw-bold mb-4" style="color: var(--dark-text);">Login</h4>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php
                    switch ($error) {
                        case 'empty_fields':
                            echo 'Email/NIM dan Password tidak boleh kosong!';
                            break;
                        case 'invalid_credentials':
                            echo 'Email/NIM atau Password salah!';
                            break;
                        case 'login_failed':
                            echo 'Login gagal. Silakan coba lagi.';
                            break;
                        case 'unauthorized':
                            echo 'Anda tidak memiliki akses ke halaman tersebut.';
                            break;
                        default:
                            echo 'Terjadi kesalahan. Silakan coba lagi.';
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- FORM LANGSUNG SUBMIT KE SERVER TANPA JAVASCRIPT -->
            <form action="/login" method="POST">
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email atau NIM</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person text-muted"></i>
                        </span>
                        <!-- PENTING: name="username" sesuai dengan LoginController -->
                        <input type="text" class="form-control border-start-0" id="identifier" name="username"
                            placeholder="Masukkan NIM atau Email" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-lock text-muted"></i>
                        </span>
                        <input type="password" class="form-control border-start-0" id="password" name="password"
                            placeholder="Masukkan Password" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label small" for="rememberMe">Ingat Saya</label>
                    </div>
                    <a href="/forgot-password" class="forgot-password">Lupa Password?</a>
                </div>

                <button type="submit" class="btn btn-login w-100">Login</button>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="text-center small">
                    Belum punya akun? <a href="/register" class="register-link">Daftar Anggota</a>
                </div>
            </form>
        </div>

        <div class="footer-text">
            &copy; 2025 EEPROM POLINEMA
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JAVASCRIPT login.js DINONAKTIFKAN SEMENTARA UNTUK DEBUG -->
    <!-- <script src="/assets/js/auth/login.js"></script> -->
</body>

</html>