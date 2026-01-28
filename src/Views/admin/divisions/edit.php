<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Divisi - EEPROM Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

                            <div class="mb-3 mx-auto border rounded d-flex align-items-center justify-content-center position-relative"
                                style="width: 150px; height: 150px; background: #f8f9fa; overflow: hidden; border-style: dashed !important;">

                                <?php
                                $icon = $division['icon'] ?? '';
                                // Cek apakah ini path gambar (upload-an) atau emoji
                                $isImage = (!empty($icon) && (strpos($icon, '/') !== false || strpos($icon, '.') !== false));
                                ?>

                                <img src="<?= $isImage ? $icon : '' ?>"
                                    id="previewIcon"
                                    alt="Preview"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; <?= $isImage ? '' : 'display: none;' ?>">

                                <span id="placeholderEmoji"
                                    class="display-4"
                                    style="<?= $isImage ? 'display: none;' : '' ?>"><?= !empty($icon) && !$isImage ? htmlspecialchars($icon) : '📁' ?></span>
                            </div>

                            <input type="file" name="icon" id="iconInput" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, atau WEBP. Maks 2MB.</small>
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
        // Fungsi untuk Preview Gambar sebelum diupload
        function previewImage(input) {
            const preview = document.getElementById('previewIcon');
            const placeholder = document.getElementById('placeholderEmoji');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>