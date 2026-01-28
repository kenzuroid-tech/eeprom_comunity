<?php
$delegateData = $delegateData ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode Akses — EEPROM Voting</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <style>
        :root {
            --primary-blue: #1A237E;
            --accent-indigo: #3F51B5;
            --glass-white: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f2f5;
            background-image:
                radial-gradient(at 0% 0%, rgba(26, 35, 126, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(102, 126, 234, 0.1) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .code-card {
            max-width: 520px;
            width: 100%;
            background: var(--glass-white);
            border-radius: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(12px);
            overflow: hidden;
            animation: fadeInScale 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .code-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-indigo));
            color: white;
            padding: 3rem 2rem 2.5rem;
            text-align: center;
            position: relative;
        }

        .lock-icon {
            width: 90px;
            height: 90px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .lock-icon i {
            font-size: 2.5rem;
        }

        .code-header h3 {
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.35rem;
            font-size: 1.75rem;
        }

        .code-header p {
            opacity: 0.85;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .step-dot.active {
            width: 24px;
            border-radius: 4px;
            background: white;
        }

        .code-body {
            padding: 2.5rem 2.5rem;
        }

        .user-info-box {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #10b981;
        }

        .user-info-box h6 {
            font-weight: 800;
            color: #1e293b;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .user-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .user-info-item:last-child {
            margin-bottom: 0;
        }

        .user-info-item i {
            color: #10b981;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .user-info-item span {
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.85rem;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
            text-align: center;
            display: block;
        }

        .code-input {
            border: 3px solid #e2e8f0;
            border-radius: 18px;
            padding: 1.25rem;
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            transition: all 0.3s ease;
            background-color: #f8fafc;
            text-align: center;
            letter-spacing: 3px;
            font-family: 'Courier New', monospace;
        }

        .code-input:focus {
            background-color: #fff;
            border-color: var(--accent-indigo);
            box-shadow: 0 0 0 5px rgba(63, 81, 181, 0.15);
            transform: scale(1.02);
        }

        .code-input::placeholder {
            letter-spacing: 2px;
            opacity: 0.4;
        }

        .btn-verify {
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-indigo));
            border: none;
            color: white;
            padding: 1.25rem;
            border-radius: 18px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(26, 35, 126, 0.3);
            font-size: 1.05rem;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: 0 20px 25px -5px rgba(26, 35, 126, 0.4);
        }

        .btn-back {
            background: transparent;
            border: 2px solid #e2e8f0;
            color: #64748b;
            padding: 0.85rem;
            border-radius: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-back:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            color: #475569;
        }

        .alert {
            border: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .help-text {
            text-align: center;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 1rem;
            line-height: 1.6;
        }

        .help-text i {
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <div class="code-card shadow-lg">
        <div class="code-header">
            <div class="lock-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3>Verifikasi Kode Akses</h3>
            <p>Masukkan kode yang diberikan oleh admin</p>
            <div class="step-indicator">
                <div class="step-dot"></div>
                <div class="step-dot active"></div>
            </div>
            <small class="d-block mt-2 opacity-75" style="font-size: 0.75rem;">Langkah 2 dari 2</small>
        </div>

        <div class="code-body">
            <!-- Data User yang Sudah Login -->
            <div class="user-info-box">
                <h6>
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Data Terverifikasi
                </h6>
                <div class="user-info-item">
                    <i class="bi bi-person-fill"></i>
                    <span><?= htmlspecialchars($delegateData['name'] ?? '') ?></span>
                </div>
                <div class="user-info-item">
                    <i class="bi bi-credit-card-fill"></i>
                    <span><?= htmlspecialchars($delegateData['nim'] ?? '') ?></span>
                </div>
                <div class="user-info-item">
                    <i class="bi bi-building"></i>
                    <span><?= htmlspecialchars($delegateData['origin'] ?? '') ?></span>
                </div>
            </div>

            <?php
            $status = $_GET['status'] ?? '';
            $alerts = [
                'empty' => ['warning', 'dash-circle', 'Kode akses tidak boleh kosong!'],
                'invalid' => ['danger', 'x-circle', 'Kode tidak valid atau sudah digunakan!'],
                'name_mismatch' => ['danger', 'exclamation-triangle', 'Kode ini tidak sesuai dengan nama Anda!']
            ];

            if (isset($alerts[$status])):
                $a = $alerts[$status];
            ?>
                <div class="alert alert-<?= $a[0] ?> d-flex align-items-center">
                    <i class="bi bi-<?= $a[1] ?> me-3 fs-5"></i>
                    <div><?= $a[2] ?></div>
                </div>
            <?php endif; ?>

            <!-- <div class="alert alert-info d-flex align-items-center mb-3">
                <i class="bi bi-info-circle-fill me-3 fs-5"></i>
                <div>
                    <strong>Kode Akses Anda:</strong><br>
                    <code class="fs-5 fw-bold"><?= htmlspecialchars($_SESSION['delegate_temp_code'] ?? 'ERROR') ?></code>
                </div>
            </div> -->
            <form action="/delegate/verify-code" method="POST" id="codeForm">
                <label class="form-label">
                    <i class="bi bi-key-fill me-2"></i>
                    Masukkan Kode Akses Voting
                </label>

                <input type="text"
                    class="form-control code-input"
                    id="access_code"
                    name="access_code"
                    placeholder="VOTE-XXX-DEL-XXXX"
                    maxlength="25"
                    required
                    autofocus
                    autocomplete="off">

                <div class="help-text">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Format kode: <strong>VOTE-[XXX]-DEL-[XXXX]</strong><br>
                    Tanyakan ke admin EEPROM jika belum menerima kode
                </div>

                <button type="submit" class="btn btn-verify">
                    <i class="bi bi-unlock-fill me-2"></i>
                    Verifikasi & Mulai Voting
                </button>

                <a href="/delegate/back-to-login" class="btn btn-back">
                    <i class="bi bi-arrow-left me-2"></i>
                    Kembali ke Login
                </a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto uppercase
        const input = document.getElementById('access_code');
        input.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // Form validation
        document.getElementById('codeForm').addEventListener('submit', function(e) {
            const code = input.value.trim();

            if (code.length < 5) {
                e.preventDefault();
                alert('Kode akses terlalu pendek! Format: VOTE-XXX-DEL-XXXX');
                input.focus();
                return false;
            }

            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memverifikasi...';
            btn.classList.add('disabled');
        });

        // Auto focus input
        input.focus();
    </script>
</body>

</html>