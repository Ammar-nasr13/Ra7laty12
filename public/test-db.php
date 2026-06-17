<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

try {
    $db = Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "<h1>Database Connection Diagnostic</h1>";
    echo "<p><strong>Connection Status:</strong> SUCCESS</p>";
    echo "<p><strong>Connection Driver:</strong> " . Illuminate\Support\Facades\DB::connection()->getDriverName() . "</p>";
    
    $tables = Illuminate\Support\Facades\Schema::getTableListing();
    echo "<p><strong>Tables present:</strong></p><pre>";
    print_r($tables);
    echo "</pre>";
    
    if (in_array('admins', $tables)) {
        $adminCount = Illuminate\Support\Facades\DB::table('admins')->count();
        echo "<p><strong>Admins count:</strong> " . $adminCount . "</p>";
        if ($adminCount > 0) {
            $adminEmails = Illuminate\Support\Facades\DB::table('admins')->pluck('email')->toArray();
            echo "<p><strong>Admin Emails:</strong> " . implode(', ', $adminEmails) . "</p>";
        }
    } else {
        echo "<p style='color:red;'><strong>Warning:</strong> 'admins' table is missing!</p>";
    }
    
} catch (\Exception $e) {
    echo "<h1>Database Connection Diagnostic</h1>";
    echo "<p style='color:red;'><strong>Connection Status:</strong> FAILED</p>";
    echo "<p><strong>Error Message:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
