<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tulis Notulensi - <?= htmlspecialchars($meeting['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-blue: #1A237E; --accent-orange: #FF5722; }
        body { background-color: #f1f5f9; font-family: 'Poppins', sans-serif; }
        .main-content { margin-left: 300px; padding: 40px; }
        .editor-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="d-flex align-items-center mb-4">
            <a href="/admin/meetings" class="btn btn-outline-secondary border-0 rounded-pill me-3"><i class="bi bi-arrow-left"></i></a>
            <h2 class="fw-bold m-0">Tulis Notulensi Rapat</h2>
        </div>

        <div class="editor-card">
            <div class="mb-4">
                <h4 class="fw-bold text-primary mb-1"><?= htmlspecialchars($meeting['title']) ?></h4>
                <p class="text-muted"><i class="bi bi-calendar-event me-2"></i> <?= date('d M Y', strtotime($meeting['date'])) ?> | <i class="bi bi-geo-alt me-2"></i> <?= htmlspecialchars($meeting['location']) ?></p>
            </div>
            
            <form action="/admin/meetings/notulensi/store" method="POST">
                <input type="hidden" name="id" value="<?= $meeting['id'] ?>">
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Hasil Pembahasan / Notulensi</label>
                    <textarea name="notulensi" class="form-control" rows="15" 
                              placeholder="Tuliskan poin-poin hasil rapat di sini..." required><?= htmlspecialchars($meeting['notulensi'] ?? '') ?></textarea>
                    <div class="form-text mt-2 text-muted">Tips: Gunakan format poin (1, 2, 3) agar mudah dibaca oleh anggota lain.</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" onclick="history.back()">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow">Simpan Notulensi</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>