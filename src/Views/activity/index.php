<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity - EEPROM POLINEMA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/activity/index.css">
    <link rel="icon" href="/assets/images/eeprom_logo.png" type="image/png">
</head>

<body>
    <?php include __DIR__ . '/../../Views/layouts/navbar-public.php'; ?>

    <header class="page-header">
        <div class="container">
            <h1 class="fw-bold">Our Activities</h1>
            <div class="header-divider"></div>
            <p class="mt-3 opacity-75">Jelajahi berbagai kegiatan dan inovasi yang kami lakukan di EEPROM POLINEMA</p>
        </div>
    </header>

    <main class="container">
        <section class="filter-container mb-5 shadow-sm">
            <form class="row g-3" method="GET" action="/activity">
                <div class="col-md-5">
                    <label class="form-label fw-bold small text-uppercase text-primary">Search</label>
                    <div class="input-group rounded-pill border overflow-hidden shadow-sm">
                        <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-0 ps-2" placeholder="Ketik judul kegiatan..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase text-primary">Year</label>
                    <select name="year" class="form-select rounded-pill border shadow-sm" onchange="this.form.submit()">
                        <option <?= ($year == 'All Years') ? 'selected' : '' ?>>All Years</option>
                        <?php foreach ($years as $y): ?>
                            <option value="<?= $y ?>" <?= ($year == $y) ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-uppercase text-primary">Category</label>
                    <select name="type" class="form-select rounded-pill border shadow-sm" onchange="this.form.submit()">
                        <option <?= ($type == 'All Categories') ? 'selected' : '' ?>>All Categories</option>
                        <option value="Workshop" <?= ($type == 'Workshop') ? 'selected' : '' ?>>Workshop</option>
                        <option value="Competition" <?= ($type == 'Competition') ? 'selected' : '' ?>>Competition</option>
                        <option value="Meeting" <?= ($type == 'Meeting') ? 'selected' : '' ?>>Meeting</option>
                        <option value="Event" <?= ($type == 'Event') ? 'selected' : '' ?>>Event</option>
                    </select>
                </div>
            </form>
        </section>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($activities)): ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-calendar-x display-1 text-muted"></i>
                    <p class="mt-3 text-muted">Tidak ada kegiatan yang ditemukan.</p>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $act): ?>
                    <div class="col">
                        <article class="activity-card h-100 shadow-sm border-0">
                            <div class="card-img-container">
                                <img src="<?= !empty($act['image_url']) ? $act['image_url'] : '/assets/images/default_activity.jpg' ?>" alt="Activity Image">
                                <span class="category-badge badge"><?= htmlspecialchars($act['type']) ?></span>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <h3 class="h5 fw-bold text-dark mb-2"><?= htmlspecialchars($act['title']) ?></h3>
                                <div class="mb-3 small text-muted">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bi bi-calendar3 text-primary me-2"></i>
                                        <?= date('d M Y', strtotime($act['created_at'])) ?>
                                    </div>
                                    <?php if (!empty($act['location'])): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt text-danger me-2"></i>
                                            <?= htmlspecialchars($act['location']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <p class="small text-muted flex-grow-1">
                                    <?= htmlspecialchars(substr(strip_tags($act['description']), 0, 100)) ?>...
                                </p>
                                <a href="/activity/detail?id=<?= $act['id'] ?>" class="btn btn-read-more-custom rounded-pill mt-3">
                                    Read More <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../../Views/layouts/footer-public.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>