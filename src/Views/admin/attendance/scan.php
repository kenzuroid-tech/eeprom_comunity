<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/admin/attendance/scan.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>

    <div class="attendance-container">
        <div class="scan-card" id="form-card">
            <h4 class="fw-bold text-dark mb-1">Presensi Anggota</h4>
            <p class="small text-muted mb-4">Silakan pilih nama Anda untuk konfirmasi kehadiran</p>

            <div class="meeting-info-box">
                <div class="meeting-title"><?= htmlspecialchars($meeting['title']) ?></div>
                <div class="info-item"><i class="bi bi-calendar3"></i> <?= date('d F Y', strtotime($meeting['date'])) ?></div>
                <div class="info-item"><i class="bi bi-clock"></i> <?= substr($meeting['start_time'], 0, 5) ?> WIB</div>
            </div>

            <form id="attendanceForm">
                <input type="hidden" id="meetingId" value="<?= $meeting['id'] ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Lengkap</label>
                    <select class="form-select form-select-lg" id="nameSelect" required>
                        <option value="" disabled selected>Cari nama Anda...</option>
                        <?php foreach ($members as $m): ?>
                            <option value="<?= $m['user_id'] ?>" data-nim="<?= $m['nim'] ?>">
                                <?= htmlspecialchars($m['nama_lengkap']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small text-muted">NIM Terdeteksi:</label>
                    <input type="text" class="form-control bg-light" id="nimInput" readonly placeholder="Pilih nama untuk melihat NIM">
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm py-3 fw-bold" id="btnSubmit">
                    <i class="bi bi-check2-circle me-2"></i> Konfirmasi Kehadiran
                </button>
            </form>
        </div>

        <div class="scan-card" id="success-overlay" style="display: none;">
            <div class="text-center">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                <h3 class="fw-bold mt-3">Berhasil!</h3>
                <p class="text-muted">Kehadiran Anda telah dicatat.</p>
                <div class="alert alert-success text-start">
                    <small class="d-block">Nama: <strong id="res-name"></strong></small>
                    <small class="d-block">Waktu: <span id="res-time"></span></small>
                </div>
                <p class="small text-danger italic">*Anda tidak dapat melakukan absensi ulang untuk rapat ini.</p>
            </div>
        </div>

        <div class="footer-text mt-4 text-center">
            © 2026 EEPROM POLINEMA
        </div>
    </div>

    <script>
        // Update NIM otomatis saat nama dipilih
        document.getElementById('nameSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('nimInput').value = selectedOption.getAttribute('data-nim');
        });

        document.getElementById('attendanceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = document.getElementById('btnSubmit');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

            const payload = {
                user_id: document.getElementById('nameSelect').value,
                meeting_id: document.getElementById('meetingId').value,
                nim: document.getElementById('nimInput').value
            };

            fetch('/admin/attendance/store', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('form-card').style.display = 'none';
                        document.getElementById('success-overlay').style.display = 'block';
                        document.getElementById('res-name').innerText = data.nama;
                        document.getElementById('res-time').innerText = data.waktu;
                    } else {
                        alert(data.message); // Menampilkan pesan "Sudah absen" dari server
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-check2-circle me-2"></i> Konfirmasi Kehadiran';
                    }
                })
                .catch(err => {
                    alert("Terjadi kesalahan koneksi.");
                    btn.disabled = false;
                });
        });
    </script>
    <script src="/assets/js/admin/dashboard.js"></script>

</body>

</html>