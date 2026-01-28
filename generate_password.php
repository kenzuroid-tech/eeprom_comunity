<?php

// Daftar NIM yang ingin di-generate passwordnya
$nimList = [
    '0000000001'
];

echo "=== GENERATE PASSWORD HASH DARI NIM ===\n\n";

// Format untuk SQL UPDATE
echo "-- SQL UPDATE STATEMENTS:\n\n";
foreach ($nimList as $nim) {
    $hash = password_hash($nim, PASSWORD_DEFAULT);
    echo "UPDATE users SET password = '$hash' WHERE username = '$nim';\n";
}

echo "\n\n";

// Format untuk CSV
echo "-- FORMAT CSV (NIM, Hash):\n\n";
foreach ($nimList as $nim) {
    $hash = password_hash($nim, PASSWORD_DEFAULT);
    echo "$nim,$hash\n";
}

echo "\n\n";

// Format untuk tabel readable
echo "-- FORMAT TABEL:\n\n";
echo str_pad("NIM", 20) . " | Password Hash\n";
echo str_repeat("-", 100) . "\n";
foreach ($nimList as $nim) {
    $hash = password_hash($nim, PASSWORD_DEFAULT);
    echo str_pad($nim, 20) . " | $hash\n";
}

?>