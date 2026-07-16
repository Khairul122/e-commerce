<?php $pageTitle = 'Halaman Tidak Ditemukan'; include APP_PATH . '/views/layouts/header.php'; ?>
<section class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4">
  <i class="fa-solid fa-face-frown text-6xl text-secondary mb-4"></i>
  <h1 class="text-3xl font-extrabold text-primary mb-2">404 - Halaman Tidak Ditemukan</h1>
  <p class="text-gray-500 mb-6">Halaman yang Anda cari tidak tersedia atau sudah dipindahkan.</p>
  <a href="<?= BASE_URL ?>/" class="bg-primary text-white font-semibold px-6 py-3 rounded-full hover:bg-primary-dark transition">Kembali ke Beranda</a>
</section>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>
