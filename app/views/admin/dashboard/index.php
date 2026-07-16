<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <p class="text-gray-500 text-sm mb-1">Pesanan Hari Ini</p>
    <p class="text-3xl font-extrabold text-primary"><?= $ordersToday ?></p>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <p class="text-gray-500 text-sm mb-1">Pendapatan (Selesai)</p>
    <p class="text-3xl font-extrabold text-primary"><?= rupiah($revenue) ?></p>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <p class="text-gray-500 text-sm mb-1">Menunggu Verifikasi</p>
    <p class="text-3xl font-extrabold text-secondary"><?= $pendingPayments ?></p>
  </div>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">
  <h2 class="font-bold text-primary mb-4">Grafik Pesanan 7 Hari Terakhir</h2>
  <canvas id="ordersChart" height="90"></canvas>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6">
  <h2 class="font-bold text-primary mb-4">Produk Unggulan</h2>
  <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
    <?php foreach ($topProducts as $p): ?>
      <div class="text-center">
        <img src="<?= uploadUrl('products', $p['image'] ?? null) ?>" class="w-full aspect-square object-cover rounded-xl mb-2">
        <p class="text-sm font-medium truncate"><?= e($p['name']) ?></p>
        <p class="text-xs text-secondary"><?= rupiah($p['price']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
const ctx = document.getElementById('ordersChart');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [
      {
        label: 'Jumlah Pesanan',
        data: <?= json_encode($chartOrders) ?>,
        borderColor: '#7A2E1D',
        backgroundColor: 'rgba(122,46,29,0.1)',
        tension: 0.3,
        fill: true,
      },
    ],
  },
  options: { responsive: true, plugins: { legend: { display: true } } },
});
</script>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
