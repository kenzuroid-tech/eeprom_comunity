<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - EEPROM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f8f9fa; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
        }
        .success-card { 
            border-radius: 20px; 
            border: none; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); 
            padding: 40px;
            background: white;
        }
        .icon-box {
            width: 80px;
            height: 80px;
            background: #d4edda;
            color: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 20px;
        }
        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }
        .btn-whatsapp:hover {
            background-color: #128C7E;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }
        .btn-outline-home {
            border: 2px solid #1A237E;
            color: #1A237E;
            border-radius: 50px;
            padding: 10px 25px;
            margin-top: 15px;
            transition: 0.3s;
        }
        .btn-outline-home:hover {
            background-color: #1A237E;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card success-card">
                    <div class="icon-box">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Terima Kasih!</h2>
                    <p class="text-muted mb-4">
                        Data pendaftaran Anda telah berhasil kami terima. Mohon tunggu informasi selanjutnya mengenai jadwal seleksi melalui email atau grup koordinasi.
                    </p>
                    
                    <div class="alert alert-info border-0 bg-light p-4 mb-4" style="border-radius: 15px;">
                        <h6 class="fw-bold text-dark mb-2">Langkah Selanjutnya:</h6>
                        <p class="small mb-3">Silakan bergabung ke grup koordinasi calon anggota melalui tombol di bawah ini:</p>
                        <a href="https://chat.whatsapp.com/LINK_GRUP_ANDA" class="btn-whatsapp">
                            <i class="bi bi-whatsapp me-2"></i> Gabung Grup WhatsApp
                        </a>
                    </div>

                    <a href="/home" class="btn btn-outline-home">
                        <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                    </a>
                </div>
                <p class="text-muted mt-4 small">&copy; 2026 EEPROM Community - Robotika & Otomasi</p>
            </div>
        </div>
    </div>
</body>
</html>