<?php
$statusMeta = [
    'pending'    => ['label' => 'Menunggu Pembayaran', 'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200', 'bar' => 'bg-yellow-400', 'icon' => 'fa-hourglass-half'],
    'diproses'   => ['label' => 'Diproses', 'badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'bar' => 'bg-blue-400', 'icon' => 'fa-gear'],
    'dikirim'    => ['label' => 'Dikirim', 'badge' => 'bg-purple-50 text-purple-700 border-purple-200', 'bar' => 'bg-purple-400', 'icon' => 'fa-truck-fast'],
    'selesai'    => ['label' => 'Selesai', 'badge' => 'bg-green-50 text-green-700 border-green-200', 'bar' => 'bg-green-400', 'icon' => 'fa-circle-check'],
    'dibatalkan' => ['label' => 'Dibatalkan', 'badge' => 'bg-red-50 text-red-700 border-red-200', 'bar' => 'bg-red-400', 'icon' => 'fa-circle-xmark'],
];
$pageTitle = 'Pesanan Saya';
include APP_PATH . '/views/layouts/header.php';
?>

<div class="absolute top-32 left-10 w-72 h-72 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>

<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <div class="mb-8" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Riwayat Transaksi</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-primary font-outfit mt-3">Pesanan Saya</h1>
    <p class="text-gray-500 font-light text-sm mt-1">Pantau status pesanan dan riwayat belanja Anda di sini.</p>
  </div>

  <?php if (!empty($orders)): ?>
    <!-- Status Filter Tabs (client-side) -->
    <div class="flex flex-wrap items-center gap-2.5 mb-8 order-filter-tabs" data-aos="fade-up">
      <button type="button" data-filter="all" class="order-tab active px-5 py-2.5 rounded-full border text-xs font-bold uppercase tracking-wider transition-all duration-300 shadow-sm bg-primary border-primary text-white">
        Semua <span class="opacity-70">(<?= count($orders) ?>)</span>
      </button>
      <?php foreach ($statusMeta as $key => $meta):
        $c = count(array_filter($orders, fn($o) => $o['status'] === $key));
        if ($c === 0) continue;
      ?>
        <button type="button" data-filter="<?= $key ?>" class="order-tab px-5 py-2.5 rounded-full border text-xs font-bold uppercase tracking-wider transition-all duration-300 shadow-sm bg-white border-gray-200 text-gray-600 hover:border-primary hover:text-primary">
          <?= e($meta['label']) ?> <span class="opacity-60">(<?= $c ?>)</span>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="space-y-4" id="orderList">
      <?php foreach ($orders as $i => $order):
        $meta = $statusMeta[$order['status']] ?? $statusMeta['pending'];
      ?>
        <a href="<?= BASE_URL ?>/pesanan/<?= e($order['order_code']) ?>" data-status="<?= e($order['status']) ?>"
           class="order-row group flex items-stretch gap-0 bg-white/80 backdrop-blur-sm rounded-3xl border border-white shadow-lg shadow-gray-100/50 hover:shadow-2xl hover:-translate-y-1 hover:shadow-primary/5 transition-all duration-500 overflow-hidden"
           data-aos="fade-up" data-aos-delay="<?= min($i * 50, 250) ?>">
          <span class="w-1.5 flex-shrink-0 <?= $meta['bar'] ?>"></span>
          <div class="flex-1 flex items-center justify-between flex-wrap gap-3 p-5">
            <div class="flex items-center gap-4">
              <span class="w-12 h-12 rounded-2xl bg-cream flex items-center justify-center text-primary text-lg flex-shrink-0 group-hover:bg-gradient-to-tr group-hover:from-primary group-hover:to-secondary group-hover:text-white transition-all duration-500">
                <i class="fa-solid <?= $meta['icon'] ?>"></i>
              </span>
              <div>
                <p class="font-bold text-gray-800 group-hover:text-primary transition text-sm md:text-base"><?= e($order['order_code']) ?></p>
                <p class="text-xs text-gray-400 font-light mt-0.5"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</p>
              </div>
            </div>
            <div class="flex items-center gap-4">
              <p class="font-extrabold text-secondary font-outfit"><?= rupiah($order['total']) ?></p>
              <span class="px-3.5 py-1.5 rounded-full text-xs font-bold border <?= $meta['badge'] ?>"><?= e($meta['label']) ?></span>
              <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-primary group-hover:translate-x-1 transition-all duration-300 hidden sm:block"></i>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>

    <p id="orderEmptyFilter" class="hidden text-center py-16 text-gray-400 text-sm font-light">Tidak ada pesanan dengan status ini.</p>

    <script>
      document.querySelectorAll('.order-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
          document.querySelectorAll('.order-tab').forEach(t => {
            t.classList.remove('active', 'bg-primary', 'border-primary', 'text-white');
            t.classList.add('bg-white', 'border-gray-200', 'text-gray-600');
          });
          tab.classList.add('active', 'bg-primary', 'border-primary', 'text-white');
          tab.classList.remove('bg-white', 'border-gray-200', 'text-gray-600');

          const filter = tab.getAttribute('data-filter');
          let visibleCount = 0;
          document.querySelectorAll('.order-row').forEach(function (row) {
            const match = filter === 'all' || row.getAttribute('data-status') === filter;
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
          });
          document.getElementById('orderEmptyFilter').classList.toggle('hidden', visibleCount > 0);
        });
      });
    </script>
  <?php else: ?>
    <div class="text-center py-24 bg-white/60 backdrop-blur-sm rounded-[2rem] border border-white shadow-sm" data-aos="fade-up">
      <div class="w-24 h-24 bg-cream rounded-full flex items-center justify-center text-primary text-4xl mx-auto mb-5 animate-float-medium">
        <i class="fa-solid fa-receipt"></i>
      </div>
      <h3 class="text-lg font-bold text-gray-800">Belum ada pesanan</h3>
      <p class="text-gray-400 font-light text-sm mt-1 max-w-xs mx-auto">Riwayat pesanan Anda akan muncul di sini setelah checkout pertama.</p>
      <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 mt-6 bg-gradient-to-r from-primary to-secondary text-white font-bold px-8 py-3.5 rounded-full hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
        Mulai Belanja <i class="fa-solid fa-arrow-right text-sm"></i>
      </a>
    </div>
  <?php endif; ?>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
