<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Divisi - EEPROM Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>
<body class="bg-light">
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>
        
        <div class="main-content-area p-4">
            <div class="widget-card-admin bg-white p-4 rounded shadow-sm">
                <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-pencil-square me-2"></i> Edit Divisi</h5>
                
                <form action="/admin/divisions/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $division['id'] ?>">
                    <input type="hidden" name="old_icon" value="<?= $division['icon'] ?>">

                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <label class="form-label d-block fw-bold">Ikon Divisi (Foto)</label>
                            <div class="mb-3 mx-auto border rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background: #f8f9fa;">
                                <?php if(preg_match('/\.(jpg|jpeg|png|webp)$/i', $division['icon'])): ?>
                                    <img src="<?= $division['icon'] ?>" id="previewIcon" style="max-width: 100%; max-height: 100%;">
                                <?php else: ?>
                                    <span id="previewText" class="display-4"><?= $division['icon'] ?></span>
                                <?php endif; ?>
                            </div>
                            <input type="file" name="icon" class="form-control form-control-sm" accept="image/*" onchange="previewFile(this)">
                            <small class="text-muted">Gunakan gambar PNG transparan agar lebih rapi.</small>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Divisi</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($division['name']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($division['description']) ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 border-top pt-3 text-end">
                        <a href="/admin/divisions" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewFile(input) {
            const previewImg = document.getElementById('previewIcon');
            const previewText = document.getElementById('previewText');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (previewImg) {
                        previewImg.src = e.target.result;
                    } else {
                        // Jika sebelumnya emoji, ganti jadi tag img
                        const container = previewText.parentElement;
                        container.innerHTML = `<img src="${e.target.result}" id="previewIcon" style="max-width: 100%; max-height: 100%;">`;
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>