<?php

namespace App\Controllers;

class RecruitmentController
{
    private function getConnection()
    {
        $configPath = dirname(__DIR__) . '/config/connection.php';
        return require $configPath;
    }

    public function submit()
    {
        $conn = $this->getConnection();

        // 1. Tangkap Data Teks
        $period_id = $_POST['period_id'];
        $nama      = $_POST['nama_lengkap'];
        $nim       = $_POST['nim'];
        $whatsapp  = $_POST['whatsapp'];
        $email     = $_POST['email'];
        $prodi     = $_POST['prodi']; // Berisi Prodi & Semester
        $angkatan  = $_POST['angkatan'];
        $divisi1   = $_POST['divisi_pilihan_1'];
        $divisi2   = $_POST['divisi_pilihan_2'];
        $alasan    = $_POST['alasan_bergabung'];
        $skills    = $_POST['skills'];

        // 2. Proses Upload Foto (Formal)
        $fotoPath = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $newName = "FOTO_" . $nim . "_" . time() . "." . $ext;
            $target = dirname(__DIR__, 2) . '/public/assets/uploads/applicants/' . $newName;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $fotoPath = '/assets/uploads/applicants/' . $newName;
            }
        }

        // 3. Proses Upload Berkas CV (PDF)
        $cvPath = null;
        if (isset($_FILES['berkas_cv']) && $_FILES['berkas_cv']['error'] == 0) {
            $newName = "CV_" . $nim . "_" . time() . ".pdf";
            $target = dirname(__DIR__, 2) . '/public/assets/uploads/documents/' . $newName;
            if (move_uploaded_file($_FILES['berkas_cv']['tmp_name'], $target)) {
                $cvPath = '/assets/uploads/documents/' . $newName;
            }
        }

        // 4. Simpan ke Database
        $query = "INSERT INTO applicants 
                  (period_id, nama_lengkap, nim, whatsapp, email, prodi, angkatan, 
                   divisi_pilihan_1, divisi_pilihan_2, alasan_bergabung, skills, foto_url, berkas_url) 
                  VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13)";

        $params = [
            $period_id,
            $nama,
            $nim,
            $whatsapp,
            $email,
            $prodi,
            $angkatan,
            $divisi1,
            $divisi2,
            $alasan,
            $skills,
            $fotoPath,
            $cvPath
        ];

        $result = pg_query_params($conn, $query, $params);

        if ($result) {
            header('Location: /form/success');
            exit;
        } else {
            die("Gagal mengirim pendaftaran: " . pg_last_error($conn));
        }
    }

    public function success()
    {
        require_once dirname(__DIR__) . '/Views/recruitment/success.php';
    }
}
