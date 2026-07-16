<?php
$__currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
function __navActive($path, $current) {
    return $current === $path || str_starts_with($current, $path . '/') ? 'bg-secondary text-white' : 'text-cream/80 hover:bg-white/10';
}
$menu = [
    ['/admin/dashboard', 'fa-gauge', 'Dashboard'],
    ['/admin/produk', 'fa-box', 'Produk'],
    ['/admin/kategori', 'fa-tags', 'Kategori'],
    ['/admin/pesanan', 'fa-receipt', 'Pesanan'],
    ['/admin/pembayaran', 'fa-money-check-dollar', 'Verifikasi Pembayaran'],
    ['/admin/pengiriman', 'fa-truck', 'Metode Pengiriman'],
    ['/admin/banner', 'fa-images', 'Banner'],
    ['/admin/testimoni', 'fa-star', 'Testimoni'],
    ['/admin/laporan', 'fa-chart-line', 'Laporan'],
];
?>
<aside id="adminSidebar" class="fixed top-0 left-0 h-full w-64 bg-primary text-white transition-transform duration-300 z-40 overflow-y-auto">
  <div class="p-5 border-b border-white/10">
    <a href="<?= BASE_URL ?>/admin/dashboard" class="text-xl font-extrabold flex items-center gap-2.5">
      <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-8 h-8">
      <span>UKM ARC Admin</span>
    </a>
  </div>
  <nav class="p-3 space-y-1">
    <?php foreach ($menu as [$path, $icon, $label]): ?>
      <a href="<?= BASE_URL . $path ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition <?= __navActive($path, $__currentPath) ?>">
        <i class="fa-solid <?= $icon ?> w-4"></i> <?= e($label) ?>
      </a>
    <?php endforeach; ?>
    <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-cream/80 hover:bg-white/10 transition">
      <i class="fa-solid fa-arrow-left w-4"></i> Lihat Situs
    </a>
    <a href="<?= BASE_URL ?>/logout" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-200 hover:bg-white/10 transition">
      <i class="fa-solid fa-right-from-bracket w-4"></i> Keluar
    </a>
  </nav>
</aside>
