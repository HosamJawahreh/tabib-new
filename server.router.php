<?php

/**
 * Laravel Development Server Router
 * This script handles static file serving including symlinked directories
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Check if requesting a file from assets (which is symlinked)
if (strpos($uri, '/assets/') === 0) {
    // Remove leading /assets/ and check in the actual assets directory
    $assetPath = __DIR__ . $uri;

    // Also check if it's a symlink path
    $symlinkPath = __DIR__ . '/public' . $uri;

    if (file_exists($assetPath) && !is_dir($assetPath)) {
        $filePath = $assetPath;
    } elseif (is_link(__DIR__ . '/public/assets')) {
        // Resolve symlink
        $realAssetsPath = readlink(__DIR__ . '/public/assets');
        $filePath = __DIR__ . '/public/' . $realAssetsPath . substr($uri, 7); // Remove '/assets'

        if (!file_exists($filePath) || is_dir($filePath)) {
            return false; // Let Laravel handle it
        }
    } else {
        return false;
    }

    // Serve the file
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'php' => 'text/css', // For dynamic CSS files like styles.php and font.php
    ];

    $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';

    header('Content-Type: ' . $mimeType);
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    return true;
}

// Check if it's a static file in public directory
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    $filePath = __DIR__ . '/public' . $uri;

    if (is_dir($filePath)) {
        return false;
    }

    // Serve the static file
    return false; // Let PHP's built-in server handle it
}

// Otherwise, let Laravel handle the request
$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once __DIR__ . '/public/index.php';
