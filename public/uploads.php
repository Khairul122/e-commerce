<?php

require __DIR__ . '/../config/config.php';

$type = $_GET['type'] ?? '';
$file = $_GET['file'] ?? '';

$allowedTypes = ['products', 'payment_proofs', 'banners', 'testimonials'];

if (!in_array($type, $allowedTypes, true) || $file === '') {
    http_response_code(404);
    exit('Not found');
}

// basename() mencegah path traversal (../../)
$safeFile = basename($file);
$path = UPLOAD_PATH . '/' . $type . '/' . $safeFile;

if (!is_file($path)) {
    http_response_code(404);
    exit('Not found');
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $path);
finfo_close($finfo);

$allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
if (!in_array($mime, $allowedMimes, true)) {
    http_response_code(403);
    exit('Forbidden');
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . filesize($path));
header('Cache-Control: public, max-age=86400');
readfile($path);
