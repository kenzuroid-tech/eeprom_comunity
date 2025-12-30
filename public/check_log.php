<?php
echo "<h2>PHP Error Log Configuration</h2>";

// 1. Cek lokasi error log
$error_log = ini_get('error_log');
echo "<p><strong>Error Log Location:</strong> " . ($error_log ?: 'Not set (using default)') . "</p>";

// 2. Cek apakah log_errors aktif
$log_errors = ini_get('log_errors');
echo "<p><strong>Log Errors Enabled:</strong> " . ($log_errors ? 'YES' : 'NO') . "</p>";

// 3. Cek display_errors
$display_errors = ini_get('display_errors');
echo "<p><strong>Display Errors:</strong> " . ($display_errors ? 'YES' : 'NO') . "</p>";

// 4. Info lengkap PHP
echo "<h3>Full PHP Info:</h3>";
echo "<p>Check 'error_log' directive in the table below</p>";
phpinfo();