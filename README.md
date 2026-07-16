# Sistem Informasi E-Commerce UKM ARC

Website e-commerce single-vendor untuk UKM kuliner ARC (Padang) — PHP Native (MVC), MySQL, Tailwind CSS (CDN).

## Cara Menjalankan (Laragon)

1. Pastikan folder ini berada di `C:\laragon\www\e-commerce` dan Apache + MySQL Laragon aktif.
2. Import skema database:
   ```
   mysql -u root < database/schema.sql
   ```
3. Isi data awal (kategori, produk dummy, admin, testimoni, banner, settings):
   ```
   php database/seed.php
   ```
4. Akses via vhost auto-Laragon: `http://e-commerce.test/`

   > Aplikasi ini didesain untuk diakses dari **document root vhost** (bukan sebagai subfolder `localhost/e-commerce/`), karena router mencocokkan path bersih dari `REQUEST_URI`.

## Akun Default

| Role | Email | Password |
|---|---|---|
| Admin | admin@ukmarc.test | admin123 |
| Customer contoh | customer@example.test | customer123 |

## Struktur Proyek

```
app/
  controllers/     Controller customer + admin/ (namespace App\Controllers, App\Controllers\Admin)
  models/          Model data (namespace App\Models)
  views/           View per modul (landing, auth, products, cart, checkout, orders, admin)
  core/            Router, Database, Controller, Model dasar, UploadHelper, helpers
public/
  index.php        Front controller (single entry point)
  uploads.php      Proxy serving file dari uploads/ (di luar public/)
  assets/          CSS/JS/gambar statis
uploads/           File upload produk & bukti pembayaran (diproteksi, di luar public/)
database/          schema.sql + seed.php
config/config.php  Konfigurasi DB, BASE_URL, timezone
```

## Keamanan

- Semua query lewat PDO prepared statements.
- Password di-hash dengan `password_hash()`.
- CSRF token pada semua form yang mengubah data.
- Upload file divalidasi tipe (MIME via fileinfo), ekstensi, dan ukuran; disimpan di luar `public/` dan diserve lewat proxy `public/uploads.php`.
- Folder `uploads/` diproteksi `.htaccess deny`.

## Batasan (sesuai PRD)

Tanpa payment gateway, tanpa integrasi API kurir, tanpa multi-vendor. Laporan diekspor via CSV native dan halaman print-friendly (tanpa Composer/DomPDF). Fitur lupa password di-skip (butuh SMTP) — gunakan kontak admin.
