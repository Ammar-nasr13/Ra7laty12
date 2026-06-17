<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Standalone Diagnostic</h1>";

// 1. Read environment variables (either from .env file or OS environment)
$envPath = __DIR__ . '/../.env';
$env = [];

if (file_exists($envPath)) {
    echo "<p>Found .env file. Parsing configuration...</p>";
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $env[trim($parts[0])] = trim($parts[1]);
        }
    }
} else {
    echo "<p style='color:blue;'><strong>Notice:</strong> .env file not found. Reading environment variables from OS (Docker/Dockploy environment)...</p>";
    $keys = ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'APP_KEY', 'APP_ENV', 'APP_DEBUG'];
    foreach ($keys as $key) {
        $val = getenv($key);
        if ($val !== false) {
            $env[$key] = $val;
        } elseif (isset($_ENV[$key])) {
            $env[$key] = $_ENV[$key];
        } elseif (isset($_SERVER[$key])) {
            $env[$key] = $_SERVER[$key];
        }
    }
}

// Print database configuration
$driver = $env['DB_CONNECTION'] ?? 'sqlite';
echo "<h3>Database Settings Detected:</h3>";
echo "<ul>";
echo "<li><strong>DB_CONNECTION:</strong> " . htmlspecialchars($driver) . "</li>";
echo "<li><strong>DB_DATABASE:</strong> " . htmlspecialchars($env['DB_DATABASE'] ?? 'not set') . "</li>";
echo "<li><strong>APP_ENV:</strong> " . htmlspecialchars($env['APP_ENV'] ?? 'not set') . "</li>";
echo "<li><strong>APP_DEBUG:</strong> " . htmlspecialchars($env['APP_DEBUG'] ?? 'not set') . "</li>";
echo "</ul>";

// 2. Attempt Connection
try {
    if ($driver === 'sqlite') {
        $dbPath = $env['DB_DATABASE'] ?? 'database/database.sqlite';
        if (strpos($dbPath, '/') !== 0 && strpos($dbPath, ':') !== 1) {
            $dbPath = __DIR__ . '/../' . $dbPath;
        }
        echo "<p>Attempting connection to SQLite database file at: <code>" . htmlspecialchars($dbPath) . "</code></p>";
        
        $pdo = new PDO("sqlite:" . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p style='color:green;'><strong>SQLite Connection successful!</strong></p>";
        
        // Write Test
        echo "<h3>Testing Write Permissions:</h3>";
        $testTable = "write_test_table_" . time();
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS $testTable (id INTEGER PRIMARY KEY, val TEXT)");
            $pdo->exec("INSERT INTO $testTable (val) VALUES ('test')");
            $pdo->exec("DROP TABLE $testTable");
            echo "<p style='color:green;'><strong>WRITE TEST SUCCESSFUL!</strong> Database is writable.</p>";
        } catch (\Exception $writeEx) {
            echo "<p style='color:red;'><strong>WRITE TEST FAILED!</strong> " . htmlspecialchars($writeEx->getMessage()) . "</p>";
            echo "<p>Please ensure that the database file <code>" . htmlspecialchars($dbPath) . "</code> AND its parent folder <code>" . htmlspecialchars(dirname($dbPath)) . "</code> have write permissions (e.g. <code>chmod 777</code> or owned by web server user).</p>";
        }
        
        // Check tables
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Tables present:</strong> " . implode(', ', $tables) . "</p>";
        
        if (in_array('admins', $tables)) {
            $adminCount = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
            echo "<p><strong>Admins count:</strong> " . $adminCount . "</p>";
            if ($adminCount > 0) {
                $emails = $pdo->query("SELECT email FROM admins")->fetchAll(PDO::FETCH_COLUMN);
                echo "<p><strong>Registered Admin Emails:</strong> " . implode(', ', $emails) . "</p>";
            }
        }
        
    } else {
        $host = $env['DB_HOST'] ?? '127.0.0.1';
        $port = $env['DB_PORT'] ?? '3306';
        $dbname = $env['DB_DATABASE'] ?? '';
        $username = $env['DB_USERNAME'] ?? '';
        $password = $env['DB_PASSWORD'] ?? '';
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "<p style='color:green;'><strong>MySQL Connection successful!</strong></p>";
        
        // Write Test
        echo "<h3>Testing Write Permissions:</h3>";
        $testTable = "write_test_table_" . time();
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS $testTable (id INT AUTO_INCREMENT PRIMARY KEY, val VARCHAR(50))");
            $pdo->exec("INSERT INTO $testTable (val) VALUES ('test')");
            $pdo->exec("DROP TABLE $testTable");
            echo "<p style='color:green;'><strong>WRITE TEST SUCCESSFUL!</strong> Database is writable.</p>";
        } catch (\Exception $writeEx) {
            echo "<p style='color:red;'><strong>WRITE TEST FAILED!</strong> " . htmlspecialchars($writeEx->getMessage()) . "</p>";
        }
    }
    
} catch (\Exception $e) {
    echo "<p style='color:red;'><strong>Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
