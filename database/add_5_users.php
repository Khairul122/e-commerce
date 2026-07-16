<?php
/**
 * Script untuk menambahkan 5 user customer baru ke database demo.
 * Jalankan via terminal: php database/add_5_users.php
 */

require __DIR__ . '/../config/config.php';
require __DIR__ . '/../app/core/Database.php';

use App\Core\Database;

$db = Database::getInstance();

echo "Menambahkan 5 user baru...\n";

$newUsers = [
    [
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad@example.test',
        'password' => 'customer123',
        'phone' => '081234567891',
        'address' => 'Jl. Sudirman No. 12, Padang',
        'role' => 'customer'
    ],
    [
        'name' => 'Siti Aminah',
        'email' => 'siti@example.test',
        'password' => 'customer123',
        'phone' => '081234567892',
        'address' => 'Jl. Khatib Sulaiman No. 45, Padang',
        'role' => 'customer'
    ],
    [
        'name' => 'Rudi Hermawan',
        'email' => 'rudi@example.test',
        'password' => 'customer123',
        'phone' => '081234567893',
        'address' => 'Jl. H. Agus Salim No. 8, Padang',
        'role' => 'customer'
    ],
    [
        'name' => 'Indah Permata',
        'email' => 'indah@example.test',
        'password' => 'customer123',
        'phone' => '081234567894',
        'address' => 'Jl. Raden Saleh No. 20, Padang',
        'role' => 'customer'
    ],
    [
        'name' => 'Fajar Nugraha',
        'email' => 'fajar@example.test',
        'password' => 'customer123',
        'phone' => '081234567895',
        'address' => 'Jl. Proklamasi No. 17, Padang',
        'role' => 'customer'
    ]
];

foreach ($newUsers as $u) {
    $stmt = $db->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute([$u['email']]);
    if (!$stmt->fetch()) {
        $hash = password_hash($u['password'], PASSWORD_DEFAULT);
        $db->prepare('INSERT INTO users (name, email, password, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)')
            ->execute([$u['name'], $u['email'], $hash, $u['phone'], $u['address'], $u['role']]);
        echo "- User '{$u['name']}' berhasil dibuat ({$u['email']})\n";
    } else {
        echo "- User '{$u['name']}' ({$u['email']}) sudah terdaftar, dilewati\n";
    }
}

echo "Selesai.\n";
