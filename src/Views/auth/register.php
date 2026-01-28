<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Anggota - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/auth/register.css">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm border-0 p-4" style="max-width: 450px; width: 100%;">
            <div class="text-center mb-4">
                <img src="/assets/images/eeprom_logo.png" alt="Logo" width="70">
                <h4 class="fw-bold mt-3">Pendaftaran Akun</h4>
                <p class="text-muted small">Khusus Anggota Baru EEPROM</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger small"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <form id="registerForm" action="/register" method="POST">
                <div class="mb-3">
                    <label class="form-label">NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control" placeholder="Masukkan NIM" required>
                    <div id="nimStatus"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" readonly required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" class="form-control" required>
                </div>

                <button type="submit" id="btnDaftar" class="btn btn-primary w-100" disabled>Aktifkan Akun</button>
            </form>
        </div>
    </div>



    <script>
        document.getElementById('nim').addEventListener('blur', function() {
            const nim = this.value;
            const emailInput = document.getElementById('email');
            const status = document.getElementById('nimStatus');
            const btn = document.getElementById('btnDaftar');

            if (nim.length > 5) {
                fetch(`/check-nim?nim=${nim}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            emailInput.value = data.email;
                            status.innerHTML = `<small class="text-success">Halo, ${data.nama}! Silakan buat password.</small>`;
                            btn.disabled = false;
                        } else {
                            emailInput.value = '';
                            status.innerHTML = `<small class="text-danger">${data.message}</small>`;
                            btn.disabled = true;
                        }
                    });
            }
        });

        // Validasi password sama
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (document.getElementById('password').value !== document.getElementById('confirm_password').value) {
                e.preventDefault();
                alert('Password tidak cocok!');
            }
        });
    </script>
</body>

</html>