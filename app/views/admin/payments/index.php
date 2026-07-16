<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['error']) ?></div>
<?php endif; ?>

<?php if (empty($payments)): ?>
  <div class="text-center py-20 text-gray-400">
    <i class="fa-solid fa-circle-check text-5xl mb-4"></i>
    <p>Tidak ada pembayaran yang menunggu verifikasi.</p>
  </div>
<?php else: ?>
  <div class="grid md:grid-cols-2 gap-6">
    <?php foreach ($payments as $p): ?>
      <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-3">
          <div>
            <p class="font-bold text-primary"><?= e($p['order_code']) ?></p>
            <p class="text-sm text-gray-500"><?= e($p['customer_name']) ?></p>
          </div>
          <p class="font-semibold"><?= rupiah($p['amount']) ?></p>
        </div>
        <img src="<?= uploadUrl('payment_proofs', $p['payment_proof']) ?>" class="w-full max-h-64 object-contain rounded-lg border mb-4 bg-cream">
        <div class="flex gap-2">
          <form method="POST" action="<?= BASE_URL ?>/admin/pembayaran/<?= $p['id'] ?>/verify" class="flex-1" data-confirm="Verifikasi pembayaran ini? Status pesanan akan berubah menjadi 'diproses'.">
            <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
            <button type="submit" class="w-full bg-green-600 text-white font-medium py-2 rounded-lg hover:bg-green-700 transition text-sm">
              <i class="fa-solid fa-check"></i> Verifikasi
            </button>
          </form>
          <form method="POST" action="<?= BASE_URL ?>/admin/pembayaran/<?= $p['id'] ?>/reject" class="flex-1" data-confirm="Tolak bukti pembayaran ini?">
            <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
            <button type="submit" class="w-full bg-red-500 text-white font-medium py-2 rounded-lg hover:bg-red-600 transition text-sm">
              <i class="fa-solid fa-xmark"></i> Tolak
            </button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
