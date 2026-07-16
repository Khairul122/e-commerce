<?php
$statusColors = [
    'pending' => 'bg-yellow-100 text-yellow-700',
    'diproses' => 'bg-blue-100 text-blue-700',
    'dikirim' => 'bg-purple-100 text-purple-700',
    'selesai' => 'bg-green-100 text-green-700',
    'dibatalkan' => 'bg-red-100 text-red-700',
];
include APP_PATH . '/views/layouts/admin_header.php';
?>

<form method="GET" action="<?= BASE_URL ?>/admin/laporan" class="flex flex-wrap items-end gap-3 mb-6 bg-white rounded-2xl shadow-sm p-5">
  <div>
    <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
    <input type="date" name="from" value="<?= e($from) ?>" class="rounded-lg border-gray-300 px-3 py-2 text-sm">
  </div>
  <div>
    <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
    <input type="date" name="to" value="<?= e($to) ?>" class="rounded-lg border-gray-300 px-3 py-2 text-sm">
  </div>
  <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-medium">Filter</button>
  <a href="<?= BASE_URL ?>/admin/laporan/csv?from=<?= e($from) ?>&to=<?= e($to) ?>" class="bg-secondary text-white px-5 py-2 rounded-lg text-sm font-medium">
    <i class="fa-solid fa-file-csv mr-1"></i> Export CSV
  </a>
  <a href="<?= BASE_URL ?>/admin/laporan/print?from=<?= e($from) ?>&to=<?= e($to) ?>" target="_blank" class="bg-gray-700 text-white px-5 py-2 rounded-lg text-sm font-medium">
    <i class="fa-solid fa-print mr-1"></i> Export PDF (Print)
  </a>
</form>

<div class="grid grid-cols-2 gap-6 mb-6">
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <p class="text-gray-500 text-sm mb-1">Total Pesanan</p>
    <p class="text-3xl font-extrabold text-primary"><?= $totalOrders ?></p>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <p class="text-gray-500 text-sm mb-1">Pendapatan (Selesai)</p>
    <p class="text-3xl font-extrabold text-primary"><?= rupiah($totalRevenue) ?></p>
  </div>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
  <h2 class="font-bold text-primary mb-4">Tren Pesanan</h2>
  <canvas id="trendChart" height="90"></canvas>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-cream text-left">
      <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Pelanggan</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th></tr>
    </thead>
    <tbody class="divide-y">
      <?php foreach ($orders as $o): ?>
        <tr>
          <td class="px-4 py-3 font-medium"><?= e($o['order_code']) ?></td>
          <td class="px-4 py-3 text-gray-500"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
          <td class="px-4 py-3"><?= e($o['customer_name']) ?></td>
          <td class="px-4 py-3"><?= rupiah($o['total']) ?></td>
          <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs <?= $statusColors[$o['status']] ?? '' ?>"><?= ucfirst(e($o['status'])) ?></span></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($orders)): ?>
        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Tidak ada data pada rentang ini.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('trendChart'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{ label: 'Jumlah Pesanan', data: <?= json_encode($chartValues) ?>, backgroundColor: '#D98324' }],
  },
  options: { responsive: true },
});
</script>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
