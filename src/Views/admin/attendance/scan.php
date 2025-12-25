<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="/public/assets/images/eeprom logo.png" type="image/png">
    
    <link rel="stylesheet" href="/public/assets/css/admin/attendance/scan.css">
</head>
<body>

    <div class="attendance-container">
        <div class="scan-card" id="form-card">
            <!-- <div class="logo-box">
                <img src="/public/assets/images/eeprom logo.png" alt="EEPROM" width="60">
            </div> -->
            
            <h4 class="fw-bold text-dark mb-1">Presensi Anggota</h4>
            <p class="small text-muted mb-4">Silakan isi data kehadiran Anda</p>

            <div class="meeting-info-box">
                <div class="meeting-title">Rapat Koordinasi Internal Divisi</div>
                <div class="info-item">
                    <i class="bi bi-calendar3"></i> 20 Desember 2025
                </div>
                <div class="info-item">
                    <i class="bi bi-clock"></i> 19:00 - 21:00 WIB
                </div>
                <div class="info-item">
                    <i class="bi bi-geo-alt"></i> Sekretariat EEPROM - Gd. AH Lt. 2
                </div>
            </div>

            <form id="attendanceForm">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <select class="form-select" id="nameSelect" required>
                        <option value="" disabled selected>Pilih nama Anda...</option>
                        <option value="1">Ahmad Zaky</option>
                        <option value="2">Budi Santoso</option>
                        <option value="3">Citra Dewi</option>
                        <option value="4">Dedi Kurniawan</option>
                    </select>
                </div>

                <div class="divider"><span>ATAU</span></div>

                <div class="mb-4">
                    <label class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" class="form-control" id="nimInput" placeholder="Masukkan NIM Anda..." maxlength="10">
                </div>

                <button type="submit" class="btn btn-absen shadow-sm">
                    <i class="bi bi-qr-code-scan me-2"></i> Absen Sekarang
                </button>
            </form>
        </div>

        <div class="scan-card" id="success-overlay">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 class="fw-bold text-dark">Presensi Berhasil!</h3>
            <p class="text-muted mb-4">Terima kasih telah hadir tepat waktu. Kehadiran Anda telah dicatat pada sistem.</p>
            
            <div class="meeting-info-box border-success bg-light text-start">
                <p class="small mb-1 text-uppercase fw-bold text-success">Detail Presensi:</p>
                <div class="info-item"><i class="bi bi-person"></i> <span id="res-name">Budi Santoso</span></div>
                <div class="info-item"><i class="bi bi-clock-history"></i> <span id="res-time">20 Des 2025, 19:05 WIB</span></div>
            </div>

            <button class="btn btn-outline-secondary w-100 rounded-pill mt-3" onclick="location.reload()">
                Kembali
            </button>
        </div>

        <div class="footer-text">
            © 2024 EEPROM POLINEMA <br>
            <span class="text-primary fw-bold">Electronic Education and Programming Robotic Of Malang</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/admin/attendance/scan.js"></script>
    
</body>
</html>