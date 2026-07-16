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

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>

<div class="mb-6 flex gap-2 flex-wrap">
  <a href="<?= BASE_URL ?>/admin/pesanan" class="px-4 py-2 rounded-full text-sm <?= !$statusFilter ? 'bg-primary text-white' : 'bg-white text-gray-600' ?>">Semua</a>
  <?php foreach (['pending','diproses','dikirim','selesai','dibatalkan'] as $s): ?>
    <a href="<?= BASE_URL ?>/admin/pesanan?status=<?= $s ?>" class="px-4 py-2 rounded-full text-sm <?= $statusFilter === $s ? 'bg-primary text-white' : 'bg-white text-gray-600' ?>"><?= ucfirst($s) ?></a>
  <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-cream text-left">
      <tr><th class="px-4 py-3">Kode</th><th class="px-4 py-3">Pelanggan</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Aksi</th></tr>
    </thead>
    <tbody class="divide-y">
      <?php foreach ($orders as $o): ?>
        <tr>
          <td class="px-4 py-3 font-medium"><?= e($o['order_code']) ?></td>
          <td class="px-4 py-3"><?= e($o['customer_name']) ?></td>
          <td class="px-4 py-3 text-gray-500"><?= date('d M Y', strtotime($o['created_at'])) ?></td>
          <td class="px-4 py-3"><?= rupiah($o['total']) ?></td>
          <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs <?= $statusColors[$o['status']] ?? '' ?>"><?= ucfirst(e($o['status'])) ?></span></td>
          <td class="px-4 py-3"><a href="<?= BASE_URL ?>/admin/pesanan/<?= $o['id'] ?>" class="text-blue-600 hover:underline">Detail</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($orders)): ?>
        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada pesanan.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
