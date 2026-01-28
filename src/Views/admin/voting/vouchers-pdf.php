<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Voucher Voting Robotik - EEPROM</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #1A237E;
            --orange: #FF5722;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 10mm;
        }

        .voucher-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .voucher-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            border: 1px solid #e2e8f0;
            position: relative;
            height: 115px;
            box-sizing: border-box;
        }

        /* Gambar Robot sebagai Watermark */
        .robot-watermark {
            position: absolute;
            right: 100px;
            bottom: -10px;
            width: 70px;
            opacity: 0.30;
            z-index: 0;
            transform: rotate(-15deg);
        }

        .card-accent {
            width: 6px;
            background: linear-gradient(to bottom, var(--navy), var(--orange));
            position: relative;
            z-index: 2;
        }

        .card-main {
            flex: 1;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            position: relative;
            z-index: 1;
        }

        .brand h6 {
            margin: 0;
            color: var(--navy);
            font-weight: 800;
            font-size: 8px;
            letter-spacing: 0.3px;
        }

        .voter-name {
            font-size: 11px;
            font-weight: 800;
            color: #1e293b;
            margin: 3px 0;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-transform: uppercase;
        }

        .type-badge {
            font-size: 6px;
            background: rgba(26, 35, 126, 0.1);
            color: var(--navy);
            padding: 2px 6px;
            border-radius: 8px;
            font-weight: 800;
        }

        .card-right {
            width: 85px;
            background: #f8fafc;
            border-left: 1.5px dashed #cbd5e1;
            padding: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .access-code {
            font-family: 'JetBrains Mono', monospace;
            background: var(--navy);
            color: white;
            padding: 5px 2px;
            border-radius: 5px;
            font-size: 9px;
            width: 100%;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(26, 35, 126, 0.2);
        }

        /* Lingkaran sobekan tiket */
        .voucher-card::before,
        .voucher-card::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: #f1f5f9;
            border-radius: 50%;
            right: 79px;
            z-index: 3;
        }

        .voucher-card::before {
            top: -6px;
        }

        .voucher-card::after {
            bottom: -6px;
        }

        @media print {
            body {
                background: white;
                padding: 1mm;
            }

            .no-print {
                display: none;
            }

            .voucher-card {
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .robot-watermark {
                opacity: 0.30 !important;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: center; padding: 15px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <button onclick="window.print()" style="padding: 10px 30px; background: var(--orange); color: white; border: none; border-radius: 50px; cursor: pointer; font-weight: 800; font-size: 14px;">
        <i class="bi bi-printer-fill"></i> PRINT KODE RAHASIA VOTING EEPROM POLINEMA
        </button>
    </div>

    <div class="voucher-grid">
        <?php foreach ($codes as $c): ?>
            <div class="voucher-card">
                <img src="/assets/images/robot.png" class="robot-watermark" alt="robot">

                <div class="card-accent"></div>
                <div class="card-main">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div class="brand">
                            <h6>EEPROM POLINEMA</h6>
                        </div>
                        <div class="type-badge"><?= $c['user_type'] ?></div>
                    </div>
                    <div>
                        <div style="font-size: 7px; color: #94a3b8; font-weight: 700;">REG. VOTER</div>
                        <span class="voter-name"><?= htmlspecialchars($c['voter_name']) ?></span>
                        <div style="font-size: 6px; color: #64748b;">E-Voting System v2.6</div>
                    </div>
                </div>
                <div class="card-right">
                    <div style="font-size: 6px; font-weight: 800; margin-bottom: 5px; color: #64748b; letter-spacing: 1px;">KODE AKSES</div>
                    <div class="access-code"><?= $c['code'] ?></div>
                    <div style="margin-top: 8px; font-size: 5px; color: #94a3b8;">Ra-ha-si-a</div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>