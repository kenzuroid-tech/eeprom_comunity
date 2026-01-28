<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Delegasi — EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            --accent-color: #FF5722;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f2f5;
            /* Latar belakang dengan aksen cahaya lembut */
            background-image:
                radial-gradient(at 0% 0%, rgba(26, 35, 126, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 87, 34, 0.05) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            max-width: 480px;
            width: 100%;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }

        /* Dekorasi lingkaran halus pada header */
        .login-header::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .header-icon-box {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-header h3 {
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 14px;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #fff;
            border-color: #3F51B5;
            box-shadow: 0 0 0 4px rgba(63, 81, 181, 0.1);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 16px;
            padding: 1rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(26, 35, 126, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(26, 35, 126, 0.4);
            filter: brightness(1.1);
        }

        .alert {
            border: none;
            border-radius: 18px;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-box {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 1.25rem;
            margin-top: 1.5rem;
            border: 1px dashed #cbd5e1;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <div class="header-icon-box">
                <i class="bi bi-person-vcard fs-1"></i>
            </div>
            <h3>Voting Delegasi</h3>
            <p class="mb-0 opacity-75 small fw-medium">Verifikasi data diri Anda untuk membuka surat suara</p>
        </div>

        <div class="p-4 p-md-5">
            <?php if (isset($_GET['status'])): ?>
                <?php
                $statusMap = [
                    'empty' => ['warning', 'exclamation-triangle', 'Semua kolom wajib diisi!'],
                    'no_election' => ['danger', 'x-circle', 'Tidak ada pemilihan aktif.'],
                    'logged_out' => ['success', 'check-circle', 'Logout berhasil dilakukan.']
                ];
                $s = $statusMap[$_GET['status']] ?? null;
                if ($s): ?>
                    <div class="alert alert-<?= $s[0] ?> mb-4 shadow-sm d-flex align-items-center">
                        <i class="bi bi-<?= $s[1] ?> me-3 fs-5"></i>
                        <div><?= $s[2] ?></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <form action="/delegate/process-login" method="POST">
                <div class="mb-4">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" placeholder="Sesuai kartu identitas" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nomor Identitas (NIM/ID)</label>
                    <input type="text" name="nim" class="form-control" placeholder="Contoh: 244101010101" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Asal Instansi</label>
                    <input type="text" name="origin" class="form-control" placeholder="Contoh: HME, HMTI, WSEC, WRI" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-4">
                    Verifikasi & Mulai Memilih <i class="bi bi-arrow-right-short ms-1 fs-5"></i>
                </button>
            </form>

            <div class="info-box">
                <div class="d-flex align-items-start">
                    <i class="bi bi-shield-lock-fill text-primary fs-4 me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-bold text-dark" style="font-size: 0.9rem;">Privasi Terjamin</h6>
                        <p class="mb-0 text-muted small">Data Anda dienkripsi dan hanya digunakan untuk validasi kehadiran pemilih delegasi secara anonim.</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/" class="text-decoration-none text-muted small fw-bold">
                    <i class="bi bi-chevron-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>