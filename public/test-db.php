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
    // Fallback to getenv()
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
$driver = $env['DB_CONNECTION'] ?? 'sqlite'; // Fallback to sqlite if not set
echo "<h3>Database Settings Detected:</h3>";
echo "<ul>";
echo "<li><strong>DB_CONNECTION:</strong> " . htmlspecialchars($driver) . "</li>";
echo "<li><strong>DB_HOST:</strong> " . htmlspecialchars($env['DB_HOST'] ?? 'not set') . "</li>";
echo "<li><strong>DB_PORT:</strong> " . htmlspecialchars($env['DB_PORT'] ?? 'not set') . "</li>";
echo "<li><strong>DB_DATABASE:</strong> " . htmlspecialchars($env['DB_DATABASE'] ?? 'not set') . "</li>";
echo "<li><strong>DB_USERNAME:</strong> " . htmlspecialchars($env['DB_USERNAME'] ?? 'not set') . "</li>";
echo "<li><strong>DB_PASSWORD:</strong> " . (isset($env['DB_PASSWORD']) ? '(hidden)' : 'not set') . "</li>";
echo "<li><strong>APP_KEY:</strong> " . (isset($env['APP_KEY']) ? '(present)' : '<span style="color:red;">MISSING (Required for Laravel Sessions!)</span>') . "</li>";
echo "<li><strong>APP_ENV:</strong> " . htmlspecialchars($env['APP_ENV'] ?? 'not set') . "</li>";
echo "<li><strong>APP_DEBUG:</strong> " . htmlspecialchars($env['APP_DEBUG'] ?? 'not set') . "</li>";
echo "</ul>";

// 2. Attempt Connection
try {
    if ($driver === 'sqlite') {
        // In SQLite, default database path is database/database.sqlite
        $dbPath = $env['DB_DATABASE'] ?? 'database/database.sqlite';
        // If it starts with relative path, normalize it
        if (strpos($dbPath, '/') !== 0 && strpos($dbPath, ':') !== 1) {
            $dbPath = __DIR__ . '/../' . $dbPath;
        }
        echo "<p>Attempting connection to SQLite database file at: <code>" . htmlspecialchars($dbPath) . "</code></p>";
        
        if (!file_exists($dbPath)) {
            echo "<p style='color:orange;'><strong>Warning:</strong> SQLite database file does not exist. Creating it...</p>";
            // Check if parent directory is writable
            $dir = dirname($dbPath);
            if (!is_writable($dir)) {
                echo "<p style='color:red;'><strong>Error:</strong> Directory <code>" . htmlspecialchars($dir) . "</code> is NOT writable!</p>";
            }
            touch($dbPath);
            chmod($dbPath, 0777);
        }
        
        $pdo = new PDO("sqlite:" . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "<p style='color:green;'><strong>SQLite Connection successful!</strong></p>";
        
        // Check tables
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Tables present:</strong> " . implode(', ', $tables) . "</p>";
        
    } else {
        $host = $env['DB_HOST'] ?? '127.0.0.1';
        $port = $env['DB_PORT'] ?? '3306';
        $dbname = $env['DB_DATABASE'] ?? '';
        $username = $env['DB_USERNAME'] ?? '';
        $password = $env['DB_PASSWORD'] ?? '';
        
        echo "<p>Attempting connection to MySQL: <code>host=$host;port=$port;dbname=$dbname</code> as user <code>$username</code>...</p>";
        
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_TIMEOUT => 5, // 5 seconds timeout
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        echo "<p style='color:green;'><strong>MySQL Connection successful!</strong></p>";
        
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p><strong>Tables present:</strong> " . (count($tables) > 0 ? implode(', ', $tables) : 'None (Need to run migrations!)') . "</p>";
    }
    
} catch (\Exception $e) {
    echo "<p style='color:red;'><strong>Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Please ensure your database settings in the Dockploy Dashboard environment variables are configured correctly.</p>";
}
