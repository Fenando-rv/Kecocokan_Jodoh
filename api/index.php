<?php

/**
 * Vercel Serverless Function Entrypoint for Laravel
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Definisikan direktori writable di /tmp Vercel
$tmpStorage = '/tmp/storage';
$directories = [
    $tmpStorage . '/framework/views',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/testing',
    $tmpStorage . '/logs',
    '/tmp/bootstrap/cache',
];

// 2. Buat folder jika belum ada di lingkungan read-only Vercel
foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 3. Set Environment Variable agar Laravel TIDAK butuh Database & menggunakan /tmp
$envVars = [
    'VIEW_COMPILED_PATH' => "{$tmpStorage}/framework/views",
    'APP_SERVICES_CACHE' => '/tmp/bootstrap/cache/services.php',
    'APP_PACKAGES_CACHE' => '/tmp/bootstrap/cache/packages.php',
    'APP_CONFIG_CACHE' => '/tmp/bootstrap/cache/config.php',
    'APP_ROUTES_CACHE' => '/tmp/bootstrap/cache/routes.php',
    'SESSION_DRIVER' => 'file',
    'CACHE_STORE' => 'array',
    'LOG_CHANNEL' => 'stderr',
    'APP_DEBUG' => 'true',
];

foreach ($envVars as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

// 4. Load Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 5. Bootstrap Laravel Application
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 6. Bind storage path ke /tmp/storage
$app->useStoragePath($tmpStorage);

// 7. Handle Request
$app->handleRequest(Request::capture());

