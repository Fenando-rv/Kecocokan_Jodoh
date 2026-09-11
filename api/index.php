<?php

/**
 * Vercel Serverless Function Entrypoint for Laravel 12
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Setup writable directories in /tmp
$tmpStorage = '/tmp/storage';
$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/testing',
    $tmpStorage . '/app/public',
    $tmpStorage . '/logs',
    '/tmp/bootstrap/cache',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Ensure SQLite database file exists in /tmp
$sqlitePath = '/tmp/database.sqlite';
if (!file_exists($sqlitePath)) {
    @touch($sqlitePath);
}

// 3. Define serverless environment defaults
$appKey = getenv('APP_KEY') ?: ($_ENV['APP_KEY'] ?? 'base64:6VJ95kM7svpGcVNDiV/yRKosu+dumLT9ZZId+zVO/Kw=');

$defaults = [
    'APP_KEY' => $appKey,
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'true',
    'VIEW_COMPILED_PATH' => $tmpStorage . '/framework/views',
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes.php',
    'SESSION_DRIVER' => 'array',
    'CACHE_STORE' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => $sqlitePath,
    'LOG_CHANNEL' => 'stderr',
];

foreach ($defaults as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 4. Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 5. Bootstrap Application
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 6. Set storage path to /tmp/storage
$app->useStoragePath($tmpStorage);

// 7. Fix LogManager driver() method to prevent ArgumentCountError when logging exceptions
$app->singleton('log', function ($app) {
    return new class($app) extends \Illuminate\Log\LogManager {
        public function driver($driver = null)
        {
            return $this->channel($driver);
        }
    };
});

// 8. Register booting callback to set safe configs
$app->booting(function () {
    config([
        'session.driver' => 'file',
        'cache.default' => 'array',
        'logging.default' => 'single',
        'queue.default' => 'sync',
        'database.default' => 'sqlite',
        'mail.default' => 'log',
        'app.debug' => true,
    ]);
});

// 9. Handle Request
$app->handleRequest(Request::capture());




