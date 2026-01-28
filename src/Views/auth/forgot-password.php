<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/auth/forgot-password.css">
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">
            <div class="logo-wrapper">
                <img src="/assets/images/eeprom_logo.png" alt="EEPROM Logo"
                    onerror="this.src='https://ui-avatars.com/api/?name=E&background=1A237E&color=fff'">
                <!-- <h3>EEPROM<span> POLINEMA</span></h3> -->
            </div>

            <h4 class="fw-bold mb-3" style="color: var(--dark-text);">Forgot Password?</h4>

            <p class="info-text">
                Jangan khawatir! Masukkan alamat email yang terdaftar pada akun Anda, dan kami akan mengirimkan tautan
                untuk mengatur ulang kata sandi Anda.
            </p>

            <div id="successAlert" class="alert-success-custom">
                <i class="bi bi-check-circle-fill me-2"></i>
                Link reset password telah dikirim ke email Anda. Silakan cek folder inbox atau spam.
            </div>

            <form id="forgotForm">
                <div class="mb-4">
                    <label for="email" class="form-label">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i
                                class="bi bi-envelope text-muted"></i></span>
                        <input type="email" class="form-control border-start-0" id="email" placeholder="nama@email.com"
                            required>
                    </div>
                </div>

                <button type="submit" class="btn btn-reset" id="submitBtn">
                    <span>Send Reset Link</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="text-center">
                <a href="/login" class="back-to-login">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>

        <div class="footer-text">
            © <?= date("Y"); ?> EEPROM POLINEMA - Developed by Nisho
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/auth/forgot-password.js"></script>
</body>

</html>