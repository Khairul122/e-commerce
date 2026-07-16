<?php

require __DIR__ . '/../config/config.php';

spl_autoload_register(function ($class) {
    $map = [
        'App\\Core\\' => APP_PATH . '/core/',
        'App\\Models\\' => APP_PATH . '/models/',
        'App\\Controllers\\Admin\\' => APP_PATH . '/controllers/admin/',
        'App\\Controllers\\' => APP_PATH . '/controllers/',
    ];

    foreach ($map as $prefix => $dir) {
        if (str_starts_with($class, $prefix)) {
            $relative = substr($class, strlen($prefix));
            $file = $dir . str_replace('\\', '/', $relative) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});

require APP_PATH . '/core/helpers.php';

use App\Core\Router;

$router = new Router();

// ===== Public: Landing & Auth =====
$router->get('/', 'HomeController@index');
$router->get('/register', 'AuthController@showRegister');
$router->post('/register', 'AuthController@register');
$router->get('/login', 'AuthController@showLogin');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/profile', 'AuthController@showProfile', ['auth']);
$router->post('/profile', 'AuthController@updateProfile', ['auth']);

// ===== Public: Katalog =====
$router->get('/produk', 'ProductController@index');
$router->get('/produk/{slug}', 'ProductController@show');

// ===== Customer: Cart =====
$router->get('/cart', 'CartController@index', ['auth']);
$router->post('/cart/add', 'CartController@add', ['auth']);
$router->post('/cart/update', 'CartController@update', ['auth']);
$router->post('/cart/remove', 'CartController@remove', ['auth']);

// ===== Customer: Checkout =====
$router->get('/checkout', 'CheckoutController@index', ['auth']);
$router->post('/checkout', 'CheckoutController@store', ['auth']);

// ===== Customer: Orders =====
$router->get('/pesanan', 'OrderController@myOrders', ['auth']);
$router->get('/pesanan/{code}', 'OrderController@detail', ['auth']);
$router->post('/pesanan/{code}/bayar', 'OrderController@uploadPayment', ['auth']);

// ===== Admin =====
$router->get('/admin', 'Admin\\DashboardController@index', ['admin']);
$router->get('/admin/dashboard', 'Admin\\DashboardController@index', ['admin']);

$router->get('/admin/produk', 'Admin\\ProductController@index', ['admin']);
$router->get('/admin/produk/tambah', 'Admin\\ProductController@create', ['admin']);
$router->post('/admin/produk/tambah', 'Admin\\ProductController@store', ['admin']);
$router->get('/admin/produk/{id}/edit', 'Admin\\ProductController@edit', ['admin']);
$router->post('/admin/produk/{id}/edit', 'Admin\\ProductController@update', ['admin']);
$router->post('/admin/produk/{id}/hapus', 'Admin\\ProductController@destroy', ['admin']);

$router->get('/admin/kategori', 'Admin\\CategoryController@index', ['admin']);
$router->post('/admin/kategori/tambah', 'Admin\\CategoryController@store', ['admin']);
$router->post('/admin/kategori/{id}/edit', 'Admin\\CategoryController@update', ['admin']);
$router->post('/admin/kategori/{id}/hapus', 'Admin\\CategoryController@destroy', ['admin']);

$router->get('/admin/pesanan', 'Admin\\OrderController@index', ['admin']);
$router->get('/admin/pesanan/{id}', 'Admin\\OrderController@detail', ['admin']);
$router->post('/admin/pesanan/{id}/status', 'Admin\\OrderController@updateStatus', ['admin']);

$router->get('/admin/pembayaran', 'Admin\\PaymentController@index', ['admin']);
$router->post('/admin/pembayaran/{id}/verify', 'Admin\\PaymentController@verify', ['admin']);
$router->post('/admin/pembayaran/{id}/reject', 'Admin\\PaymentController@reject', ['admin']);

$router->get('/admin/pengiriman', 'Admin\\ShippingController@index', ['admin']);
$router->post('/admin/pengiriman/tambah', 'Admin\\ShippingController@store', ['admin']);
$router->post('/admin/pengiriman/{id}/edit', 'Admin\\ShippingController@update', ['admin']);
$router->post('/admin/pengiriman/{id}/hapus', 'Admin\\ShippingController@destroy', ['admin']);

$router->get('/admin/banner', 'Admin\\BannerController@index', ['admin']);
$router->post('/admin/banner/tambah', 'Admin\\BannerController@store', ['admin']);
$router->post('/admin/banner/{id}/edit', 'Admin\\BannerController@update', ['admin']);
$router->post('/admin/banner/{id}/hapus', 'Admin\\BannerController@destroy', ['admin']);

$router->get('/admin/testimoni', 'Admin\\TestimonialController@index', ['admin']);
$router->post('/admin/testimoni/tambah', 'Admin\\TestimonialController@store', ['admin']);
$router->post('/admin/testimoni/{id}/edit', 'Admin\\TestimonialController@update', ['admin']);
$router->post('/admin/testimoni/{id}/hapus', 'Admin\\TestimonialController@destroy', ['admin']);

$router->get('/admin/laporan', 'Admin\\ReportController@index', ['admin']);
$router->get('/admin/laporan/csv', 'Admin\\ReportController@exportCsv', ['admin']);
$router->get('/admin/laporan/print', 'Admin\\ReportController@printView', ['admin']);

$uri = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$router->dispatch($uri, $method);
