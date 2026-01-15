<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.

// Check if the requested file exists in the public directory
$publicPath = __DIR__.'/public'.$uri;

// For static asset files (CSS, JS, images, fonts), serve them directly
if ($uri !== '/' && file_exists($publicPath)) {
    // Get file extension
    $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

    // If it's a PHP file in assets directory, execute it
    if ($extension === 'php' && strpos($uri, '/assets/') === 0) {
        // Change to public directory
        chdir(__DIR__.'/public');
        // Include and execute the PHP file
        include $publicPath;
        return true;
    }

    // Set proper MIME types for common file types
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
    ];

    if (isset($mimeTypes[$extension])) {
        header('Content-Type: ' . $mimeTypes[$extension]);
    }

    // Return false to let PHP's built-in server serve the file
    return false;
}

require_once __DIR__.'/public/index.php';
