<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Serverless database TLS certificate
|--------------------------------------------------------------------------
|
| Vercel runs the application from a read-only container filesystem. Database
| providers that use a private CA hand out a certificate file that normally
| lives on disk. Accept it as a base64 encoded environment variable and
| materialise it in the writable temporary directory instead.
|
*/

if ($caCertificate = getenv('DB_SSL_CA_BASE64')) {
    $caPath = sys_get_temp_dir().'/batika-db-ca.pem';

    if (! is_file($caPath) && ($decoded = base64_decode($caCertificate, true)) !== false) {
        file_put_contents($caPath, $decoded);
    }

    if (is_file($caPath)) {
        putenv('MYSQL_ATTR_SSL_CA='.$caPath);
        $_ENV['MYSQL_ATTR_SSL_CA'] = $caPath;
        $_SERVER['MYSQL_ATTR_SSL_CA'] = $caPath;
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
