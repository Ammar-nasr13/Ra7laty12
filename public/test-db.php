<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Standalone Diagnostic</h1>";

// 1. Read .env file manually
$envPath = __DIR__ . '/../.env';
if (!file_exists($envPath)) {
    die("<p style='color:red;'><strong>Error:</strong> .env file not found at " . htmlspecialchars($envPath) . "</p>");
}

echo "<p>Found .env file. Parsing configuration...</p>";
$env = [];
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    $parts = explode('=', $line, 2);
    if (count($parts) === 2) {
        $env[trim($parts[0])] = trim($parts[1]);
    }
}

// Print database configuration
$driver = $env['DB_CONNECTION'] ?? 'mysql';
echo "<h3>Database Settings from .env:</h3>";
echo "<ul>";
echo "<li><strong>DB_CONNECTION:</strong> " . htmlspecialchars($driver) . "</li>";
echo "<li><strong>DB_HOST:</strong> " . htmlspecialchars($env['DB_HOST'] ?? 'not set') . "</li>";
echo "<li><strong>DB_PORT:</strong> " . htmlspecialchars($env['DB_PORT'] ?? 'not set') . "</li>";
echo "<li><strong>DB_DATABASE:</strong> " . htmlspecialchars($env['DB_DATABASE'] ?? 'not set') . "</li>";
echo "<li><strong>DB_USERNAME:</strong> " . htmlspecialchars($env['DB_USERNAME'] ?? 'not set') . "</li>";
echo "<li><strong>DB_PASSWORD:</strong> " . (isset($env['DB_PASSWORD']) ? '(hidden)' : 'not set') . "</li>";
echo "</ul>";

// 2. Attempt Connection
try {
    if ($driver === 'sqlite') {
        $dbPath = $env['DB_DATABASE'] ?? (__DIR__ . '/../database/database.sqlite');
        // If it starts with relative path, normalize it
        if (strpos($dbPath, '/') !== 0 && strpos($dbPath, ':') !== 1) {
            $dbPath = __DIR__ . '/../' . $dbPath;
        }
        echo "<p>Attempting connection to SQLite database file at: <code>" . htmlspecialchars($dbPath) . "</code></p>";
        
        if (!file_exists($dbPath)) {
            echo "<p style='color:orange;'><strong>Warning:</strong> SQLite database file does not exist. Creating it...</p>";
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
        echo "<p><strong>Tables present:</strong> " . implode(', ', $tables) . "</p>";
    }
    
} catch (\Exception $e) {
    echo "<p style='color:red;'><strong>Connection Failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>If the connection failed, please verify that your database service is running and the credentials are correct.</p>";
}
