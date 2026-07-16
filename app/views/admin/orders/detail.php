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
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['error']) ?></div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
  <div>
    <h2 class="text-xl font-bold text-primary"><?= e($order['order_code']) ?></h2>
    <p class="text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
  </div>
  <span class="px-4 py-1.5 rounded-full text-sm font-medium <?= $statusColors[$order['status']] ?? '' ?>"><?= ucfirst(e($order['status'])) ?></span>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="font-bold text-primary mb-3">Pelanggan</h3>
    <p class="text-sm"><?= e($order['customer_name']) ?></p>
    <p class="text-sm text-gray-500"><?= e($order['customer_email']) ?></p>
    <p class="text-sm text-gray-500"><?= e($order['customer_phone'] ?? '-') ?></p>
    <p class="text-sm text-gray-500 mt-2"><?= nl2br(e($order['shipping_address'])) ?></p>
    <p class="text-sm text-gray-500 mt-2">Metode: <?= e($order['shipping_name']) ?></p>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <h3 class="font-bold text-primary mb-3">Ubah Status</h3>
    <form method="POST" action="<?= BASE_URL ?>/admin/pesanan/<?= $order['id'] ?>/status" class="flex gap-2">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <select name="status" class="flex-1 rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-3 py-2 text-sm">
        <?php foreach (['pending','diproses','dikirim','selesai','dibatalkan'] as $s): ?>
          <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit" class="bg-primary text-white px-5 py-2 rounded-lg text-sm font-medium">Update</button>
    </form>
    <?php if ($payment): ?>
      <div class="mt-4 pt-4 border-t">
        <p class="text-sm text-gray-500">Status Pembayaran: <span class="font-semibold"><?= ucfirst(e($payment['status'])) ?></span></p>
        <a href="<?= BASE_URL ?>/admin/pembayaran" class="text-blue-600 text-sm hover:underline">Kelola verifikasi &rarr;</a>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="bg-white rounded-2xl shadow-sm p-6">
  <h3 class="font-bold text-primary mb-4">Item Pesanan</h3>
  <div class="divide-y text-sm">
    <?php foreach ($items as $item): ?>
      <div class="flex justify-between py-2">
        <span><?= e($item['product_name']) ?> x<?= $item['quantity'] ?></span>
        <span class="font-medium"><?= rupiah($item['subtotal']) ?></span>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="border-t mt-3 pt-3 space-y-1 text-sm">
    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span><?= rupiah($order['subtotal']) ?></span></div>
    <div class="flex justify-between"><span class="text-gray-500">Ongkir</span><span><?= rupiah($order['shipping_cost']) ?></span></div>
    <div class="flex justify-between font-bold text-lg"><span>Total</span><span class="text-primary"><?= rupiah($order['total']) ?></span></div>
  </div>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
