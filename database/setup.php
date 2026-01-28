#!/usr/bin/env php
<?php

echo "╔═══════════════════════════════════════════╗\n";
echo "║      EEPROM Database Setup Script         ║\n";
echo "╚═══════════════════════════════════════════╝\n\n";

echo "Akun Default yang akan dibuat:\n";
echo "1. Superadmin -> (superadmin / password)\n";
echo "2. Admin      -> (admin / password)\n";
echo "3. Anggota    -> (244107020014 / bismillah)\n\n";

echo "⚠️  WARNING: Data lama akan DIHAPUS!\n";
echo "Lanjutkan? (yes/no): ";

$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
fclose($handle);

if (strtolower($line) !== 'yes') {
    echo "\n❌ Setup dibatalkan.\n";
    exit(0);
}

// Jalankan Migrasi (Buat Tabel)
echo "\n🔧 Running migration...\n";
include __DIR__ . '/migrate.php'; 

// Jalankan Seeder (Isi Data)
echo "\n🌱 Running seeder...\n";
include __DIR__ . '/seed.php';

echo "\n✨ Setup Selesai! Silakan login.\n";