<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akses Voting - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #1A237E 0%, #3F51B5 100%);
            --accent-gradient: linear-gradient(135deg, #FF5722 0%, #F4511E 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f2f5;
            background-image:
                radial-gradient(at 0% 0%, rgba(26, 35, 126, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(255, 87, 34, 0.1) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .code-card {
            max-width: 500px;
            width: 100%;
            background: var(--glass-bg);
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .code-header {
            background: var(--primary-gradient);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            position: relative;
        }

        /* Dekorasi Lingkaran Halus */
        .code-header::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .code-header .icon-box {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .code-header i {
            font-size: 2.5rem;
            color: #ffffff;
        }

        .code-body {
            padding: 2.5rem 2.5rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 2rem;
        }

        .code-input {
            font-size: 1.25rem;
            text-align: center;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-weight: 700;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.2rem;
            background: #f8fafc;
            color: #1a237e;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .code-input:focus {
            background: white;
            border-color: #3f51b5;
            box-shadow: 0 0 0 4px rgba(63, 81, 181, 0.1);
            transform: translateY(-2px);
        }

        .btn-verify {
            background: var(--primary-gradient);
            border: none;
            padding: 1.1rem;
            border-radius: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-verify:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -5px rgba(26, 35, 126, 0.4);
            filter: brightness(1.1);
        }

        .info-box {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .info-box h6 {
            color: #1e293b;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .alert {
            border-radius: 16px;
            border: none;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .alert-warning {
            background-color: #fffbeb;
            color: #92400e;
        }

        code {
            background: rgba(26, 35, 126, 0.05);
            padding: 2px 6px;
            border-radius: 4px;
            color: #3f51b5;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="code-card">
        <div class="code-header">
            <div class="icon-box">
                <i class="bi bi-fingerprint"></i>
            </div>
            <h4 class="fw-800 mb-2">Autentikasi Pemilih</h4>
            <p class="opacity-75 small mb-0 px-4">
                Demi keamanan, silakan masukkan kode akses unik untuk membuka kotak suara digital Anda.
            </p>
        </div>

        <div class="code-body">
            <?php
            $status = $_GET['status'] ?? '';
            $alerts = [
                'invalid' => ['type' => 'danger', 'icon' => 'x-circle', 'msg' => 'Kode tidak valid atau sudah kadaluarsa.'],
                'not_yours' => ['type' => 'warning', 'icon' => 'exclamation-triangle', 'msg' => 'Kode akses ini tidak terdaftar untuk akun Anda.'],
                'empty' => ['type' => 'warning', 'icon' => 'info-circle', 'msg' => 'Kolom kode akses tidak boleh kosong.'],
                'no_code' => ['type' => 'danger', 'icon' => 'clock-history', 'msg' => 'Sesi verifikasi telah berakhir. Silakan coba lagi.']
            ];

            if (isset($alerts[$status])):
                $curr = $alerts[$status];
            ?>
                <div class="alert alert-<?= $curr['type'] ?> d-flex align-items-center mb-4 shadow-sm" role="alert">
                    <i class="bi bi-<?= $curr['icon'] ?> fs-5 me-3"></i>
                    <div><?= $curr['msg'] ?></div>
                </div>
            <?php endif; ?>

            <form action="/member/voting/verify-code" method="POST" id="codeForm">
                <div class="input-group-custom">
                    <label class="form-label d-block text-center small fw-700 text-uppercase text-muted mb-3" style="letter-spacing: 1px;">
                        Kode Akses Anda
                    </label>
                    <input type="text"
                        name="access_code"
                        id="accessCodeInput"
                        class="form-control code-input shadow-sm"
                        placeholder="VOTE-XXXX-16-XXX"
                        maxlength="25"
                        required
                        autofocus
                        autocomplete="off">
                </div>

                <button type="submit" class="btn btn-verify btn-primary w-100 shadow-sm">
                    Verifikasi Keamanan <i class="bi bi-arrow-right-short ms-2 fs-5"></i>
                </button>
            </form>

            <div class="info-box">
                <h6 class="fw-bold mb-3 d-flex align-items-center">
                    <i class="bi bi-lightbulb-fill text-warning me-2"></i> Petunjuk Penggunaan
                </h6>
                <ul class="list-unstyled small text-secondary mb-0">
                    <li class="mb-2 d-flex">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        <span>Cek kode pada dashboard <strong>Katalog Voting</strong> Anda.</span>
                    </li>
                    <li class="mb-2 d-flex">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        <span>Pastikan format <code>VOTE-XXX-16-XXX</code> tertulis dengan benar.</span>
                    </li>
                    <li class="d-flex">
                        <i class="bi bi-check2-circle text-success me-2"></i>
                        <span>Satu kode hanya berlaku untuk <strong>satu kali</strong> submisi suara.</span>
                    </li>
                </ul>
            </div>

            <div class="text-center mt-4">
                <a href="/member/voting" class="text-muted text-decoration-none small hover-link">
                    <i class="bi bi-chevron-left"></i> Kembali ke Menu Utama
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const input = document.getElementById('accessCodeInput');

        // Auto-uppercase
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.toUpperCase();
        });

        // Form UX
        document.getElementById('codeForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memverifikasi...';
            btn.disabled = true;
        });
    </script>
</body>

</html>