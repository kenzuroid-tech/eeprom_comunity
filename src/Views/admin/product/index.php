<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - EEPROM ADMIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
</head>

<body>
    <div class="dashboard-wrapper">
        <?php include_once __DIR__ . '/../includes/sidebar.php'; ?>

        <main id="mainContentWrapper" class="admin-main-content">
            <nav class="navbar-top-admin shadow-sm mb-4 px-4 py-3 bg-white rounded-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary border-0 me-3 d-lg-none" onclick="toggleSidebar()">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                    <div>
                        <h4 class="m-0 fw-bold text-dark">Manajemen Produk</h4>
                        <p class="m-0 small text-muted d-none d-md-block">Kelola katalog robot dan sparepart EEPROM.</p>
                    </div>
                </div>

                <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" onclick="openAddModal()">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </button>
            </nav>

            <div class="admin-widget-card shadow-sm p-4 bg-white rounded-4">
                <div class="table-responsive rounded-4 border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3 py-3">Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Media</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allProducts)): ?>
                                <?php foreach ($allProducts as $p):
                                    // Decode JSON foto, ambil index pertama sebagai thumbnail
                                    $photos = json_decode($p['photos'] ?? '[]', true);
                                    $thumbnail = !empty($photos) ? $photos[0] : '/assets/images/default_robot.png';
                                ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= htmlspecialchars($thumbnail) ?>" class="rounded-3 me-3" width="55" height="55" style="object-fit: cover; border: 1px solid #eee;">
                                                <div>
                                                    <span class="fw-bold text-dark d-block"><?= htmlspecialchars($p['name']) ?></span>
                                                    <small class="text-muted"><?= htmlspecialchars(substr($p['description'], 0, 40)) ?>...</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3"><?= htmlspecialchars($p['category']) ?></span></td>
                                        <td class="fw-bold text-dark">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <small class="badge bg-light text-dark border"><i class="bi bi-image me-1"></i><?= count($photos) ?></small>
                                                <?php if (!empty($p['video_url'])): ?>
                                                    <small class="badge bg-light text-danger border"><i class="bi bi-play-circle me-1"></i>Video</small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group shadow-sm border rounded-3 overflow-hidden">
                                                <button class="btn btn-sm btn-white border-0" onclick="openEdit(<?= $p['id'] ?>)">
                                                    <i class="bi bi-pencil text-primary"></i>
                                                </button>
                                                <button class="btn btn-sm btn-white border-0 text-danger" onclick="confirmDelete(<?= $p['id'] ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="mb-3"><i class="bi bi-box2" style="font-size: 3rem; opacity: 0.2;"></i></div>
                                        <p class="fw-bold mb-0">Belum ada produk yang ditemukan.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="productForm" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalTitle">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id" id="form_id">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Robot / Produk</label>
                        <input type="text" name="name" id="form_name" class="form-control rounded-3" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="category" id="form_category" class="form-select rounded-3">
                                <option value="Line Follower">Line Follower</option>
                                <option value="Rescue Robot">Rescue Robot</option>
                                <option value="Transporter">Transporter</option>
                                <option value="Drone">Drone</option>
                                <option value="Spareparts">Spareparts</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Harga (Rp)</label>
                            <input type="number" name="price" id="form_price" class="form-control rounded-3" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi Produk</label>
                        <textarea name="description" id="form_description" class="form-control rounded-3" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Upload Foto (Bisa banyak)</label>
                        <input type="file" name="photos[]" class="form-control rounded-3" multiple accept="image/*">
                        <div id="edit_info_photos" class="small text-primary mt-1 d-none">
                            *Upload foto baru akan menambahkan koleksi foto lama.
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Upload Video Produk</label>
                        <input type="file" name="video" class="form-control rounded-3" accept="video/*">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const productModal = new bootstrap.Modal(document.getElementById('productModal'));

        // Fungsi Buka Modal Tambah
        function openAddModal() {
            document.getElementById('productForm').reset();
            document.getElementById('form_id').value = '';
            document.getElementById('modalTitle').innerText = 'Tambah Produk Baru';
            document.getElementById('productForm').action = '/admin/products/store';
            document.getElementById('edit_info_photos').classList.add('d-none');
            productModal.show();
        }

        // Fungsi Buka Modal Edit (Fetch Data via AJAX)
        function openEdit(id) {
            fetch('/admin/products/edit?id=' + id)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modalTitle').innerText = 'Edit Produk';
                    document.getElementById('productForm').action = '/admin/products/update';
                    document.getElementById('form_id').value = data.id;
                    document.getElementById('form_name').value = data.name;
                    document.getElementById('form_price').value = data.price;
                    document.getElementById('form_category').value = data.category;
                    document.getElementById('form_description').value = data.description;
                    document.getElementById('edit_info_photos').classList.remove('d-none');
                    productModal.show();
                })
                .catch(err => alert("Gagal mengambil data: " + err));
        }

        // Konfirmasi Hapus
        function confirmDelete(id) {
            if (confirm('Hapus produk ini secara permanen?')) {
                window.location.href = '/admin/products/delete?id=' + id;
            }
        }
    </script>
</body>

</html>