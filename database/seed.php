<?php
/**
 * Seed data awal untuk demo. Jalankan: php database/seed.php
 * Aman dijalankan berkali-kali (pakai INSERT IGNORE / cek existing).
 */

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../app/core/Database.php';
require __DIR__ . '/../app/core/helpers.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Seeding database...\n";

// ---- Admin user ----
$stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute(['admin@ukmarc.test']);
if (!$stmt->fetch()) {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $db->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)')
        ->execute(['Admin ARC', 'admin@ukmarc.test', $hash, 'admin']);
    echo "- Admin user dibuat (admin@ukmarc.test / admin123)\n";
} else {
    echo "- Admin user sudah ada, dilewati\n";
}

// ---- Contoh customer ----
$stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute(['customer@example.test']);
if (!$stmt->fetch()) {
    $hash = password_hash('customer123', PASSWORD_DEFAULT);
    $db->prepare('INSERT INTO users (name, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)')
        ->execute(['Budi Santoso', 'customer@example.test', $hash, '081234567890', 'Jl. Contoh No. 1, Padang', 'customer']);
    echo "- Customer contoh dibuat (customer@example.test / customer123)\n";
} else {
    echo "- Customer contoh sudah ada, dilewati\n";
}

// ---- Reset tables for clean seeding ----
$db->exec('SET FOREIGN_KEY_CHECKS = 0;');
$db->exec('TRUNCATE TABLE product_images;');
$db->exec('TRUNCATE TABLE products;');
$db->exec('TRUNCATE TABLE categories;');
$db->exec('TRUNCATE TABLE banners;');
$db->exec('TRUNCATE TABLE testimonials;');
$db->exec('SET FOREIGN_KEY_CHECKS = 1;');
echo "- Database cleared for fresh seeding\n";

// ---- Kategori ----
$categories = [
    ['name' => 'Pastry', 'icon' => 'cake-candles'],
    ['name' => 'Nasi Box', 'icon' => 'utensils'],
    ['name' => 'Snack Box', 'icon' => 'cookie'],
    ['name' => 'Makanan Berat', 'icon' => 'bowl-food'],
];

$categoryIds = [];
foreach ($categories as $cat) {
    $slug = slugify($cat['name']);
    $db->prepare('INSERT INTO categories (name, slug, icon) VALUES (?, ?, ?)')
        ->execute([$cat['name'], $slug, $cat['icon']]);
    $categoryIds[$cat['name']] = (int) $db->lastInsertId();
}
echo "- " . count($categoryIds) . " kategori siap\n";

// ---- Produk dummy ----
$products = [
    // Pastry
    ['Pastry', 'Brownies Panggang Premium', 'Brownies panggang cokelat premium dengan tekstur fudgy dan toppings melimpah.', 45000, 25, 1, 'brownies.png'],
    ['Pastry', 'Pizza Kecil', 'Pizza ukuran mini dengan topping sosis, keju mozarella, dan saus bolognese gurih.', 15000, 30, 0, 'pizza_kecil.png'],
    ['Pastry', 'Kue Sus Buah', 'Kue sus dengan vla lembut manis dan hiasan buah segar di atasnya.', 5000, 40, 0, 'kue_sus_buah.png'],

    // Nasi Box
    ['Nasi Box', 'Nasi Ayam Bakar', 'Nasi lengkap dengan ayam bakar bumbu khas Padang, lalapan segar, dan sambal cabai.', 30000, 40, 1, 'nasi_ayam_bakar.png'],
    ['Nasi Box', 'Nasi Box Catering Premium', 'Paket nasi box catering lengkap untuk berbagai acara formal dan informal.', 35000, 50, 1, 'catering.png'],

    // Snack Box
    ['Snack Box', 'Klepon', 'Kue tradisional klepon dengan isian gula merah cair dan taburan kelapa parut gurih.', 2000, 60, 0, 'klepon.png'],
    ['Snack Box', 'Risol', 'Risol renyah dengan isian sayur gurih dan telur, digoreng keemasan.', 3000, 50, 1, 'risol.png'],
    ['Snack Box', 'Snack Box Jajanan Pasar', 'Paket snack box lengkap berisi aneka kue tradisional (klepon, risol, sus) untuk rapat/acara.', 20000, 30, 0, 'snackbox.png'],
    ['Snack Box', 'Jajanan Pasar Campur', 'Piring saji berisi aneka jajanan pasar tradisional khas Ranah Minang yang legit.', 15000, 35, 0, 'jajanan_pasar.png'],

    // Makanan Berat
    ['Makanan Berat', 'Rendang Daging Sapi', 'Rendang daging sapi asli Minang, dimasak perlahan hingga bumbu meresap sempurna.', 55000, 20, 1, 'rendang.png'],
    ['Makanan Berat', 'Ayam Geprek Sambal Korek', 'Ayam goreng tepung renyah dengan ulekan cabai rawit pedas mantap.', 25000, 35, 0, 'ayam_geprek.png'],
    ['Makanan Berat', 'Ikan Cabe Ijo Pete', 'Ikan goreng siram sambal cabai hijau gurih ditambah dengan pete segar.', 25000, 15, 1, 'ikan_cabe_ijo_pete.png'],
    ['Makanan Berat', 'Tumis Kangkung', 'Tumis kangkung segar dengan irisan bawang dan cabai rawit pedas gurih.', 10000, 30, 0, 'kangkung.png'],
];

foreach ($products as [$catName, $name, $desc, $price, $stock, $featured, $image]) {
    $slug = slugify($name);
    $db->prepare('INSERT INTO products (category_id, name, slug, description, price, stock, image, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')
        ->execute([$categoryIds[$catName], $name, $slug, $desc, $price, $stock, $image, $featured, 'active']);
}
echo "- " . count($products) . " produk siap\n";

// ---- Testimoni ----
$testimonials = [
    ['Siti Rahma', 'Kuenya enak banget dan selalu fresh! Langganan tiap minggu.', 5],
    ['Andi Wijaya', 'Nasi box-nya porsinya pas dan rasanya autentik Padang banget.', 5],
    ['Dewi Lestari', 'Pelayanan ramah, pesan online jadi lebih gampang sekarang.', 4],
    ['Rian Pratama', 'Rendang kemasannya cocok buat oleh-oleh keluar kota.', 5],
];
$stmt = $db->query('SELECT COUNT(*) as total FROM testimonials');
if ((int) $stmt->fetch()['total'] === 0) {
    foreach ($testimonials as [$name, $msg, $rating]) {
        $db->prepare('INSERT INTO testimonials (customer_name, message, rating) VALUES (?, ?, ?)')
            ->execute([$name, $msg, $rating]);
    }
    echo "- " . count($testimonials) . " testimoni dummy siap\n";
} else {
    echo "- Testimoni sudah ada, dilewati\n";
}

// ---- Banner ----
$stmt = $db->query('SELECT COUNT(*) as total FROM banners');
if ((int) $stmt->fetch()['total'] === 0) {
    $banners = [
        ['Promo Spesial Pastry Homemade', 'banner_1.png', 1],
        ['Nasi Box Favorit, Cocok untuk Acara', 'banner_2.png', 2],
        ['Kelezatan Tradisional Minangkabau', 'banner_3.png', 3]
    ];
    foreach ($banners as [$title, $image, $order]) {
        $db->prepare('INSERT INTO banners (title, image, is_active, sort_order) VALUES (?, ?, 1, ?)')
            ->execute([$title, $image, $order]);
    }
    echo "- 3 banner dummy siap\n";
} else {
    echo "- Banner sudah ada, dilewati\n";
}

// ---- Settings ----
$stmt = $db->query('SELECT COUNT(*) as total FROM settings');
if ((int) $stmt->fetch()['total'] === 0) {
    $db->prepare('INSERT INTO settings (site_name, address, phone, email, whatsapp, about_text, bank_name, bank_account_number, bank_account_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')
        ->execute([
            'UKM ARC',
            'Jl. Kuliner Raya No. 10, Padang, Sumatera Barat',
            '0751-1234567',
            'info@ukmarc.test',
            '081234500000',
            'UKM ARC adalah usaha kuliner rumahan di Padang yang memproduksi pastry, kue, dan makanan siap saji dengan bahan berkualitas, higienis, dan tanpa pengawet.',
            'Bank BRI',
            '1234-5678-9012',
            'UKM ARC',
        ]);
    echo "- Settings toko siap\n";
} else {
    echo "- Settings sudah ada, dilewati\n";
}

echo "Selesai.\n";
