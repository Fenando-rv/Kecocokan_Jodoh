<?php

/**
 * Vercel Serverless Function Entrypoint for Laravel
 */

// 1. Definisikan struktur direktori writable di /tmp Vercel
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

// 3. Set environment variable secara dinamis agar Laravel menggunakan folder writable /tmp
putenv("VIEW_COMPILED_PATH={$tmpStorage}/framework/views");
putenv("APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php");
putenv("APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php");
putenv("APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php");
putenv("APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php");

$_ENV['VIEW_COMPILED_PATH'] = "{$tmpStorage}/framework/views";
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes.php';

$_SERVER['VIEW_COMPILED_PATH'] = "{$tmpStorage}/framework/views";
$_SERVER['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_SERVER['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_SERVER['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
$_SERVER['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes.php';

// 4. Forward request ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
