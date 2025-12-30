<?php
// TEST DIRECT LOGIN - BYPASS ROUTER
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Direct Login Test</h2>";
echo "<p>Timestamp: " . date('Y-m-d H:i:s') . "</p>";

// Test 1: Cek POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<h3>✅ POST Request Received!</h3>";
    echo "<pre>";
    echo "Username: " . ($_POST['username'] ?? 'NOT SET') . "\n";
    echo "Password: " . ($_POST['password'] ?? 'NOT SET') . "\n";
    echo "Password Length: " . strlen($_POST['password'] ?? '') . "\n";
    echo "</pre>";
    
    // Test 2: Database connection
    echo "<h3>Testing Database Connection...</h3>";
    try {
        require_once __DIR__ . '/../vendor/autoload.php';
        
        $config = require __DIR__ . '/../config/database.php';
        $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['database']}";
        $pdo = new PDO($dsn, $config['username'], $config['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "✅ Database connected!<br>";
        
        // Test 3: Find user
        $identifier = $_POST['username'];
        $password = $_POST['password'];
        
        $stmt = $pdo->prepare("
            SELECT u.*, m.nama_lengkap, m.nim, m.divisi 
            FROM users u
            LEFT JOIN members m ON u.id = m.user_id
            WHERE (u.username = :identifier OR u.email = :identifier) 
            AND u.is_active = TRUE
        ");
        $stmt->execute(['identifier' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            echo "✅ User found in database!<br>";
            echo "<pre>";
            echo "ID: " . $user['id'] . "\n";
            echo "Username: " . $user['username'] . "\n";
            echo "Email: " . $user['email'] . "\n";
            echo "Role: " . $user['role'] . "\n";
            echo "Password Hash: " . substr($user['password'], 0, 30) . "...\n";
            echo "</pre>";
            
            // Test 4: Password verification
            echo "<h3>Testing Password Verification...</h3>";
            $isValid = password_verify($password, $user['password']);
            
            if ($isValid) {
                echo "✅ Password is CORRECT!<br>";
                echo "<h3 style='color: green;'>🎉 LOGIN SHOULD WORK!</h3>";
                
                // Test 5: Session
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = strtolower($user['role']);
                $_SESSION['nama'] = $user['nama_lengkap'] ?? $user['username'];
                
                echo "<h3>Session Created:</h3>";
                echo "<pre>" . print_r($_SESSION, true) . "</pre>";
                
                echo "<p><a href='/member/dashboard'>Go to Dashboard</a></p>";
            } else {
                echo "❌ Password is INCORRECT!<br>";
                echo "<p>Expected hash: " . substr($user['password'], 0, 30) . "...</p>";
                echo "<p>You entered: " . htmlspecialchars($password) . "</p>";
            }
        } else {
            echo "❌ User NOT found in database!<br>";
            echo "<p>Searched for: " . htmlspecialchars($identifier) . "</p>";
        }
        
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    }
    
} else {
    // Show form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Direct Login Test</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center mb-4">Direct Login Test</h3>
                            <p class="alert alert-info">
                                This form submits directly to this file, bypassing all routing.
                            </p>
                            
                            <form method="POST" action="/test_login.php">
                                <div class="mb-3">
                                    <label class="form-label">Username/Email</label>
                                    <input type="text" name="username" class="form-control" 
                                           value="nisho" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" 
                                           value="password123" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">
                                    Test Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}