# Transfer of Knowledge: Sistem E-Commerce Dapoer ARC

Dokumen ini ditujukan bagi pengembang masa depan untuk memahami arsitektur, pola desain, alur data, serta struktur visual dari platform e-commerce **Dapoer ARC**.

---

## 1. Arsitektur Framework Custom MVC

Aplikasi ini menggunakan framework MVC (Model-View-Controller) buatan sendiri (*lightweight custom framework*) yang ditulis menggunakan PHP Native. Hal ini menghindari ketergantungan pada library pihak ketiga yang besar dan memastikan kecepatan muat yang maksimal.

### Alur Kerja Utama:
1. **Single Entry Point (`public/index.php`)**:
   Setiap permintaan (request) dari browser diarahkan ke file front controller ini melalui berkas konfigurasi Apache `.htaccess`.
2. **Routing (`app/core/Router.php`)**:
   Router mencocokkan pola URL bersih (misalnya `/produk/brownies-panggang-premium`) dengan controller dan method yang sesuai. Parameter slug atau ID akan diekstrak secara otomatis.
3. **Penyajian Controller (`app/core/Controller.php`)**:
   Semua controller mewarisi class dasar ini. Method `$this->view($path, $data)` digunakan untuk mengirim data array dan memuat file template PHP yang berada di `app/views/`.
4. **Interaksi Model (`app/core/Model.php`)**:
   Model mewakili tabel database. Query dilakukan menggunakan class dasar PDO Singleton (`app/core/Database.php`) untuk menjamin hanya ada satu koneksi database aktif selama siklus hidup request.

---

## 2. Sistem Manajemen Berkas & Keamanan Gambar

Untuk mencegah eksploitasi berkas berbahaya (seperti eksekusi script PHP liar di direktori unggahan), aplikasi ini menerapkan **Sistem Proxy Gambar**:

* **Penyimpanan di Luar Publik**:
  Semua gambar produk asli dan bukti pembayaran disimpan di direktori `/uploads` yang letaknya sejajar dengan root (di luar folder `/public` yang dapat diakses langsung oleh browser). Direktori ini juga dilindungi oleh aturan `.htaccess` (`Deny from all`).
* **Sistem Serve Proxy (`public/uploads.php`)**:
  Untuk memuat gambar ke browser, aplikasi memanggil script proxy pembaca file. Script ini bertugas memeriksa sesi login pengguna, melakukan verifikasi tipe MIME menggunakan ekstensi PHP `fileinfo`, dan mengalirkan data gambar secara aman dengan header yang tepat.
* **Helper URL (`uploadUrl()`)**:
  Fungsi pembantu di **`app/core/helpers.php`** merubah nama file database menjadi URL dinamis yang mengarah pada proxy pembaca file tersebut:
  ```php
  function uploadUrl(string $type, ?string $filename): string {
      if (empty($filename)) return BASE_URL . '/assets/images/placeholder.svg';
      return BASE_URL . '/uploads.php?type=' . urlencode($type) . '&file=' . urlencode($filename);
  }
  ```

---

## 3. Desain Visual & Komponen UI Premium

Antarmuka pengguna mengadopsi prinsip desain modern dengan estetika tinggi (*high-aesthetic glassmorphism*):

* **Frosted Glass Navbar**:
  Navbar dirancang melayang (`fixed`) dengan background semi-transparan `bg-white/20 backdrop-blur-sm border-b border-white/10`. Melalui JavaScript di **`public/assets/js/app.js`**, navbar akan menyusut (*shrink*) dan warnanya memadat (`bg-white/85`) saat halaman di-scroll melewati 30px untuk menjaga keterbacaan teks menu.
* **Pencegahan Overlapping Iframe Peta**:
  Atribusi OpenStreetMap (OSM) di bagian bawah peta sengaja dipotong (*masked*) menggunakan properti CSS kontainer `overflow-hidden` bersanding dengan tinggi iframe `calc(100% + 40px)` dan margin-bottom `-40px`. Hal ini dilakukan untuk menyembunyikan teks lisensi default yang merusak kerapian tata letak visual.
* **Bento Grid Terbatas**:
  Halaman depan menggunakan Bento Grid yang sangat rapi. Jumlah produk dibatasi sebanyak 5 data saja baik di tingkat query controller (`getFeatured(5)`) maupun pemotongan array di tingkat tampilan (`array_slice()`) untuk menjamin simetri kolom layout.

---

## 4. Cara Pengaturan Ulang & Seeding

Jika Anda ingin membersihkan database dan memulai ulang demo dengan data produk asli Dapoer ARC:
```bash
php database/seed.php
```
Script seeding ini secara otomatis akan menjalankan:
```sql
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE product_images;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;
TRUNCATE TABLE banners;
TRUNCATE TABLE testimonials;
SET FOREIGN_KEY_CHECKS = 1;
```
Sehingga tidak ada penumpukan ID kategori atau produk sampah saat Anda melakukan seeding berulang kali.

---

## 📄 Lisensi (Synectra License)
Perangkat lunak ini dilisensikan di bawah **Lisensi Synectra**. Penggunaan komersial maupun pribadi diperbolehkan dengan syarat tetap mempertahankan atribusi hak cipta asli.

*Copyright (c) 2026 Synectra. Hak Cipta Dilindungi.*

---

## 💖 Dukungan Pengembang
Dukung pengembangan berkelanjutan untuk platform e-commerce Dapoer ARC dengan memindai kode QR berikut:

![Dukungan QR](public/assets/images/QR.jpeg)
