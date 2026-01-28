<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Anggota Baru - EEPROM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .form-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-eeprom {
            background-color: #1A237E;
            color: white;
            border-radius: 50px;
            padding: 12px 40px;
            border: none;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-primary-eeprom:hover {
            background-color: #3F51B5;
            transform: translateY(-2px);
        }

        .preview-container {
            width: 130px;
            height: 170px;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #fff;
            margin: 0 auto;
        }

        .preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1A237E;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card form-card p-4 p-md-5">
                    <div class="text-center mb-5">
                        <img src="/assets/images/eeprom_logo.png" width="80" alt="Logo">
                        <h2 class="fw-bold mt-3"><?= htmlspecialchars($period['nama_periode']) ?></h2>
                        <p class="text-muted">Lengkapi data pendaftaran Anda dengan benar sesuai berkas asli.</p>
                    </div>

                    <form action="/form/submit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="period_id" value="<?= $period['id'] ?>">

                        <div class="section-title"><i class="bi bi-person-badge"></i> Data Pribadi</div>
                        <div class="row mb-4">
                            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                                <label class="form-label d-block fw-bold small text-muted">Foto Formal (Merah/Biru)</label>
                                <div class="preview-container mb-2" id="imagePreview">
                                    <i class="bi bi-person-bounding-box fs-1 text-light"></i>
                                    <img src="" alt="Pratinjau Foto">
                                </div>
                                <input type="file" name="foto" class="form-control form-control-sm" id="fotoInput" accept="image/*" required>
                                <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Maks: 2MB (JPG/PNG)</small>
                            </div>
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-600 small">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" required placeholder="Sesuai KTP/KTM">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-600 small">NIM</label>
                                        <input type="text" name="nim" class="form-control" required placeholder="Contoh: 244109xxxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-600 small">WhatsApp</label>
                                        <input type="text" name="whatsapp" class="form-control" required placeholder="0821xxxxxxxx">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-600 small">Email</label>
                                        <input type="email" name="email" class="form-control" required placeholder="user@gmail.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Prodi & Semester</label>
                                <input type="text" name="prodi" class="form-control" required placeholder="D4 Teknik Elektronika - Semester 1">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Angkatan</label>
                                <input type="number" name="angkatan" class="form-control" required placeholder="Contoh: 2024">
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-rocket-takeoff"></i> Divisi & Motivasi</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Divisi Pilihan 1</label>
                                <select name="divisi_pilihan_1" class="form-select" required>
                                    <option value="">Pilih Divisi</option>
                                    <option value="Software">Software</option>
                                    <option value="Elektrik">Elektrik</option>
                                    <option value="Mekanik">Mekanik</option>
                                    <option value="Humas">Humas</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-600 small">Divisi Pilihan 2</label>
                                <select name="divisi_pilihan_2" class="form-select" required>
                                    <option value="">Pilih Divisi</option>
                                    <option value="Software">Software</option>
                                    <option value="Elektrik">Elektrik</option>
                                    <option value="Mekanik">Mekanik</option>
                                    <option value="Humas">Humas</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small">Alasan Bergabung</label>
                                <textarea name="alasan_bergabung" class="form-control" rows="3" placeholder="Jelaskan motivasi Anda bergabung di EEPROM..."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-600 small">Skills</label>
                                <textarea name="skills" class="form-control" rows="2" placeholder="Contoh: Arduino, C++, Desain PCB, Public Speaking, dll."></textarea>
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-file-earmark-pdf"></i> Dokumen & Portfolio</div>
                        <div class="mb-4">
                            <label class="form-label fw-600 small">CV / Resume (PDF)</label>
                            <input type="file" name="berkas_cv" class="form-control" accept="application/pdf" required>
                            <small class="text-muted">Unggah berkas CV terbaru dalam format PDF (Maks: 5MB).</small>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn-primary-eeprom">
                                <i class="bi bi-send me-2"></i> Kirim Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fotoInput = document.getElementById('fotoInput');
        const previewContainer = document.getElementById('imagePreview');
        const previewImage = previewContainer.querySelector('img');
        const previewIcon = previewContainer.querySelector('i');

        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert("Ukuran foto terlalu besar! Maksimal 2MB.");
                    this.value = "";
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    previewIcon.style.display = 'none';
                    previewContainer.style.borderStyle = 'solid';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>