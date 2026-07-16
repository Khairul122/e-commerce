<?php
$__currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

function __navActive($path, $current) {
    return $current === $path || str_starts_with($current, $path . '/') ? 'bg-secondary text-white font-bold' : 'text-cream/80 hover:bg-white/10';
}

$isKatalogActive = str_contains($__currentPath, '/admin/produk') || str_contains($__currentPath, '/admin/kategori');
$isTransaksiActive = str_contains($__currentPath, '/admin/pesanan') || str_contains($__currentPath, '/admin/pembayaran') || str_contains($__currentPath, '/admin/pengiriman');
$isKontenActive = str_contains($__currentPath, '/admin/banner') || str_contains($__currentPath, '/admin/testimoni');
?>
<aside id="adminSidebar" class="fixed top-0 left-0 h-full w-64 bg-primary text-white transition-transform duration-300 z-40 overflow-y-auto">
  <div class="p-5 border-b border-white/10">
    <a href="<?= BASE_URL ?>/admin/dashboard" class="text-xl font-extrabold flex items-center gap-2.5">
      <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-8 h-8">
      <span>Panel Admin</span>
    </a>
  </div>
  <nav class="p-3 space-y-2">
    <!-- Dashboard -->
    <a href="<?= BASE_URL ?>/admin/dashboard" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= __navActive('/admin/dashboard', $__currentPath) ?>">
      <i class="fa-solid fa-gauge w-4"></i> Dashboard
    </a>

    <!-- Dropdown Katalog -->
    <details class="group" <?= $isKatalogActive ? 'open' : '' ?>>
      <summary class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition text-cream/80 hover:bg-white/10 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-boxes-stacked w-4 text-cream/70"></i>
          <span>Katalog Produk</span>
        </span>
        <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-open:rotate-180 opacity-60"></i>
      </summary>
      <div class="pl-4 space-y-1 mt-1.5 border-l border-white/10 ml-6">
        <a href="<?= BASE_URL ?>/admin/produk" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/produk', $__currentPath) ?>">
          <i class="fa-solid fa-box w-3.5"></i> Daftar Produk
        </a>
        <a href="<?= BASE_URL ?>/admin/kategori" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/kategori', $__currentPath) ?>">
          <i class="fa-solid fa-tags w-3.5"></i> Kategori
        </a>
      </div>
    </details>

    <!-- Dropdown Transaksi -->
    <details class="group" <?= $isTransaksiActive ? 'open' : '' ?>>
      <summary class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition text-cream/80 hover:bg-white/10 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-receipt w-4 text-cream/70"></i>
          <span>Transaksi</span>
        </span>
        <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-open:rotate-180 opacity-60"></i>
      </summary>
      <div class="pl-4 space-y-1 mt-1.5 border-l border-white/10 ml-6">
        <a href="<?= BASE_URL ?>/admin/pesanan" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/pesanan', $__currentPath) ?>">
          <i class="fa-solid fa-receipt w-3.5"></i> Pesanan
        </a>
        <a href="<?= BASE_URL ?>/admin/pembayaran" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/pembayaran', $__currentPath) ?>">
          <i class="fa-solid fa-money-check-dollar w-3.5"></i> Verifikasi Bayar
        </a>
        <a href="<?= BASE_URL ?>/admin/pengiriman" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/pengiriman', $__currentPath) ?>">
          <i class="fa-solid fa-truck w-3.5"></i> Metode Kirim
        </a>
      </div>
    </details>

    <!-- Dropdown Konten -->
    <details class="group" <?= $isKontenActive ? 'open' : '' ?>>
      <summary class="flex items-center justify-between px-4 py-2.5 rounded-lg text-sm font-medium transition text-cream/80 hover:bg-white/10 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
        <span class="flex items-center gap-3">
          <i class="fa-solid fa-laptop-code w-4 text-cream/70"></i>
          <span>Manajemen Konten</span>
        </span>
        <i class="fa-solid fa-chevron-down text-[10px] transition duration-300 group-open:rotate-180 opacity-60"></i>
      </summary>
      <div class="pl-4 space-y-1 mt-1.5 border-l border-white/10 ml-6">
        <a href="<?= BASE_URL ?>/admin/banner" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/banner', $__currentPath) ?>">
          <i class="fa-solid fa-images w-3.5"></i> Banner
        </a>
        <a href="<?= BASE_URL ?>/admin/testimoni" class="flex items-center gap-3 px-4 py-2 rounded-lg text-xs font-medium transition <?= __navActive('/admin/testimoni', $__currentPath) ?>">
          <i class="fa-solid fa-star w-3.5"></i> Testimoni
        </a>
      </div>
    </details>

    <!-- Manajemen Pembeli -->
    <a href="<?= BASE_URL ?>/admin/pembeli" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= __navActive('/admin/pembeli', $__currentPath) ?>">
      <i class="fa-solid fa-users w-4"></i> Pelanggan / Pembeli
    </a>

    <!-- Laporan -->
    <a href="<?= BASE_URL ?>/admin/laporan" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= __navActive('/admin/laporan', $__currentPath) ?>">
      <i class="fa-solid fa-chart-line w-4"></i> Laporan
    </a>

    <!-- Divider -->
    <hr class="border-white/10 my-4">

    <!-- Back to site -->
    <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-cream/80 hover:bg-white/10 transition">
      <i class="fa-solid fa-arrow-left w-4"></i> Lihat Situs
    </a>

    <!-- Logout -->
    <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-200 hover:bg-white/10 transition">
      <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
    </a>
  </nav>
</aside>
