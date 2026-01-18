<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - EEPROM POLINEMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Card Styling */
        .profile-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            padding: 30px;
            margin-top: 20px;
        }
        /* Tab Styling agar sama dengan SS */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 10px 20px;
        }
        .nav-tabs .nav-link.active {
            color: #2b3a8f; /* Biru gelap navigasi */
            background: transparent;
            border-bottom: 3px solid #ff4d00; /* Garis bawah orange sesuai SS */
        }
        /* Form Styling */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }
        .btn-simpan {
            background-color: #0d6efd; /* Biru tombol di SS */
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-simpan:hover {
            background-color: #0b5ed7;
        }
        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2b3a8f;
            margin-bottom: 20px;
        }
        hr {
            border-top: 1px solid #eee;
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="profile-card">
        <h2 class="section-title">Profil Saya</h2>

        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link" id="view-tab" data-bs-toggle="tab" data-bs-target="#view-profile" type="button">View Profile</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button">Edit Profile</button>
            </li>
            <li class="nav-item">
                <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account-settings" type="button">Account Settings</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="profileTabsContent">
            
            <div class="tab-pane fade" id="view-profile" role="tabpanel">
                <p class="text-muted">Halaman tampilan profil anggota.</p>
            </div>

            <div class="tab-pane fade" id="edit-profile" role="tabpanel">
                <p class="text-muted">Halaman pengeditan data members (Nama, Bio, Sosmed, dll).</p>
            </div>

            <div class="tab-pane fade show active" id="account-settings" role="tabpanel">
                <form action="proses_update_akun.php" method="POST">
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="username" class="form-label">Username (NIM)</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="2341720001" placeholder="Masukkan username baru">
                            <small class="text-muted">Username ini digunakan untuk login ke sistem.</small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" 
                                   placeholder="Ketik password lama untuk konfirmasi" required>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <h6 class="mb-3 fw-bold text-danger">Ubah Password (Opsional)</h6>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   placeholder="Kosongkan jika tidak ingin ganti">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" name="update_account" class="btn btn-primary btn-simpan">
                            Simpan Perubahan Akun
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>