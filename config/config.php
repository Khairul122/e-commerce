<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'db_arc_ecommerce');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('UPLOAD_PATH', ROOT_PATH . '/uploads');

// APP_ENV: 'development' menampilkan error PHP, 'production' menyembunyikannya
define('APP_ENV', 'development');

if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

date_default_timezone_set('Asia/Jakarta');

// BASE_PATH: prefix subfolder tempat aplikasi diakses, mis. '/e-commerce' jika dibuka
// lewat http://localhost/e-commerce/. Kosongkan ('') jika diakses lewat vhost root
// (mis. http://e-commerce.test/). Router memakai nilai ini untuk melepas prefix dari
// REQUEST_URI sebelum mencocokkan rute.
define('BASE_PATH', '/e-commerce');

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $scheme . '://' . $host . BASE_PATH);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
