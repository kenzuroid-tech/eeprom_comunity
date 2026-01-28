<?php

/**
 * Fungsi untuk menentukan bobot hierarki jabatan
 * Semakin kecil angkanya, semakin tinggi posisinya
 */
function getJabatanPriority($jabatan)
{
    $jabatan = strtolower(trim($jabatan ?? ''));

    // 1. Pucuk Pimpinan
    if ($jabatan === 'ketua umum') return 1;

    // 2. Badan Pengurus Harian (BPH)
    $bph = ['sekretaris umum', 'sekretaris 1', 'bendahara umum', 'bendahara'];
    if (in_array($jabatan, $bph)) return 2;

    // 3. Kepala Divisi
    if (str_contains($jabatan, 'kepala divisi') || str_contains($jabatan, 'ketua divisi')) return 3;

    // 4. Wakil Kepala Divisi
    if (str_contains($jabatan, 'wakil kepala divisi')) return 4;

    // 5. Anggota dan lainnya
    return 5;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/member/index.css">
    <style>
        /* CSS Tambahan untuk Struktur Hierarki Terang */
        .team-structure-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px;
            padding: 30px 0;
        }

        /* Leader Card Style (White Theme) */
        .leader-container {
            position: relative;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .leader-container::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 50%;
            width: 2px;
            height: 50px;
            background: #E2E8F0;
        }

        /* Staff Grid Style */
        .staff-grid-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            width: 100%;
        }

        @media (max-width: 992px) {
            .staff-grid-wrapper {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .staff-grid-wrapper {
                grid-template-columns: 1fr;
            }
        }

        /* Badge Custom for Hierarchy */
        .badge-prio-1 {
            background: #FFD700;
            color: #000;
        }

        .badge-prio-2 {
            background: var(--primary-blue);
            color: #fff;
        }

        .badge-prio-3 {
            background: var(--accent-orange);
            color: #fff;
        }

        .badge-prio-4 {
            background: #FB8C00;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1 class="section-heading-white">Our Members</h1>
            <div class="header-divider"></div>
            <p class="lead opacity-75">Keluarga besar inovator robotika dari masa ke masa</p>
        </div>
    </header>

    <main class="container mb-5">
        <ul class="nav nav-tabs nav-tabs-custom" id="genTabs" role="tablist">
            <?php foreach ($generations as $index => $gen): ?>
                <?php if ($gen == 0) continue; ?>
                <li class="nav-item">
                    <button class="nav-link <?= $index === 0 ? 'active' : '' ?>"
                        data-bs-toggle="tab" data-bs-target="#gen<?= $gen ?>" type="button">
                        Gen <?= $gen ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" id="genTabsContent">
            <?php foreach ($membersByGen as $gen => $members): ?>
                <?php if ($gen == 0) continue;

                // Sort by Priority
                usort($members, function ($a, $b) {
                    $prioA = getJabatanPriority($a['jabatan']);
                    $prioB = getJabatanPriority($b['jabatan']);
                    return ($prioA === $prioB) ? strcmp($a['nama_lengkap'], $b['nama_lengkap']) : ($prioA <=> $prioB);
                });
                ?>

                <div class="tab-pane fade <?= $gen == max($generations) ? 'show active' : '' ?>" id="gen<?= $gen ?>">
                    <div class="team-structure-wrapper">

                        <?php
                        $leader = null;
                        $staff = [];
                        foreach ($members as $m) {
                            if (getJabatanPriority($m['jabatan']) === 1) $leader = $m;
                            else $staff[] = $m;
                        }
                        ?>

                        <?php if ($leader): ?>
                            <div class="leader-container">
                                <div class="member-card shadow-sm" style="max-width: 350px;">
                                    <span class="badge-status status-active">Active</span>
                                    <div class="member-img-wrapper" style="width: 150px; height: 150px;">
                                        <img src="<?= $leader['foto_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($leader['nama_lengkap']) . '&background=1A237E&color=fff' ?>" alt="Leader">
                                    </div>
                                    <h5 class="member-name"><?= htmlspecialchars($leader['nama_lengkap']) ?></h5>
                                    <span class="badge badge-prio-1 px-3 py-2 rounded-pill mb-3 d-inline-block" style="font-size: 0.75rem; font-weight: 800;">
                                        <?= strtoupper($leader['jabatan']) ?>
                                    </span>
                                    <br>
                                    <a href="/profile?nim=<?= $leader['nim'] ?>" class="btn-profile">View Profile <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="staff-grid-wrapper">
                            <?php foreach ($staff as $s):
                                $prio = getJabatanPriority($s['jabatan']);
                                $statusClass = (strtolower($s['status_keanggotaan']) === 'active') ? 'status-active' : 'status-alumni';
                                $roleDisplay = ($prio < 5) ? $s['jabatan'] : $s['divisi'];
                                $badgeClass = ($prio < 5) ? "badge-prio-" . $prio : "badge-divisi";
                            ?>
                                <div class="member-card shadow-sm text-center">
                                    <span class="badge-status <?= $statusClass ?>"><?= htmlspecialchars($s['status_keanggotaan']) ?></span>
                                    <div class="member-img-wrapper">
                                        <img src="<?= $s['foto_url'] ?: 'https://ui-avatars.com/api/?name=' . urlencode($s['nama_lengkap']) . '&background=1A237E&color=fff' ?>" alt="Staff">
                                    </div>
                                    <h5 class="member-name text-truncate px-2"><?= htmlspecialchars($s['nama_lengkap']) ?></h5>
                                    <span class="member-nim"><?= htmlspecialchars($s['nim']) ?></span>
                                    <span class="badge <?= $badgeClass ?> d-inline-block text-truncate mb-2 px-3 py-2 rounded-pill" style="max-width: 90%; font-size: 0.65rem;">
                                        <?= htmlspecialchars($roleDisplay) ?>
                                    </span>
                                    <br>
                                    <a href="/profile?nim=<?= $s['nim'] ?>" class="btn-profile">View Profile <i class="bi bi-arrow-right ms-1"></i></a>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../../Views/layouts/footer-public.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>