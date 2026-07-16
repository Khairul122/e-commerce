<?php
$statusMeta = [
    'pending'    => ['label' => 'Menunggu Pembayaran', 'badge' => 'bg-yellow-50 text-yellow-700 border-yellow-200'],
    'diproses'   => ['label' => 'Diproses', 'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
    'dikirim'    => ['label' => 'Dikirim', 'badge' => 'bg-purple-50 text-purple-700 border-purple-200'],
    'selesai'    => ['label' => 'Selesai', 'badge' => 'bg-green-50 text-green-700 border-green-200'],
    'dibatalkan' => ['label' => 'Dibatalkan', 'badge' => 'bg-red-50 text-red-700 border-red-200'],
];
$meta = $statusMeta[$order['status']] ?? $statusMeta['pending'];

$steps = [
    ['key' => 'pending', 'label' => 'Pesanan Dibuat', 'icon' => 'fa-receipt'],
    ['key' => 'diproses', 'label' => 'Diproses', 'icon' => 'fa-gear'],
    ['key' => 'dikirim', 'label' => 'Dikirim', 'icon' => 'fa-truck-fast'],
    ['key' => 'selesai', 'label' => 'Selesai', 'icon' => 'fa-circle-check'],
];
$stepIndex = array_search($order['status'], array_column($steps, 'key'));
$stepIndex = $stepIndex === false ? 0 : $stepIndex;

$pageTitle = 'Pesanan ' . $order['order_code'];
include APP_PATH . '/views/layouts/header.php';
?>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <a href="<?= BASE_URL ?>/pesanan" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-primary transition mb-6 font-medium" data-aos="fade-up">
    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Pesanan Saya
  </a>

  <div class="flex items-center justify-between mb-8 flex-wrap gap-3" data-aos="fade-up">
    <div>
      <h1 class="text-2xl md:text-3xl font-extrabold text-primary font-outfit"><?= e($order['order_code']) ?></h1>
      <p class="text-sm text-gray-400 font-light mt-1"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</p>
    </div>
    <span class="px-4 py-1.5 rounded-full text-sm font-bold border <?= $meta['badge'] ?>"><?= e($meta['label']) ?></span>
  </div>

  <?php if (!empty($flash['success'])): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-2xl p-4 mb-6 flex items-center gap-2" data-aos="fade-up">
      <i class="fa-solid fa-circle-check"></i><?= e($flash['success']) ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($flash['error'])): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-2xl p-4 mb-6 flex items-center gap-2" data-aos="fade-up">
      <i class="fa-solid fa-circle-exclamation"></i><?= e($flash['error']) ?>
    </div>
  <?php endif; ?>

  <!-- Status Timeline -->
  <?php if ($order['status'] === 'dibatalkan'): ?>
    <div class="bg-red-50 border border-red-100 rounded-[2rem] p-6 mb-8 flex items-center gap-4" data-aos="fade-up">
      <span class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-circle-xmark"></i></span>
      <div>
        <p class="font-bold text-red-700">Pesanan ini telah dibatalkan</p>
        <p class="text-sm text-red-500/80 mt-0.5">Hubungi kami via WhatsApp jika ini bukan permintaan Anda.</p>
      </div>
    </div>
  <?php else: ?>
    <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-8 mb-8" data-aos="fade-up">
      <div class="flex items-center">
        <?php foreach ($steps as $i => $step): ?>
          <div class="flex items-center <?= $i < count($steps) - 1 ? 'flex-1' : '' ?>">
            <div class="flex flex-col items-center gap-2 flex-shrink-0">
              <span class="w-10 h-10 md:w-12 md:h-12 rounded-2xl flex items-center justify-center text-sm md:text-base transition-colors duration-500 <?= $i <= $stepIndex ? 'bg-gradient-to-tr from-primary to-secondary text-white shadow-md' : 'bg-cream text-gray-300' ?>">
                <i class="fa-solid <?= $step['icon'] ?>"></i>
              </span>
              <span class="text-[10px] md:text-xs font-bold text-center <?= $i <= $stepIndex ? 'text-primary' : 'text-gray-300' ?> max-w-[70px] leading-tight"><?= $step['label'] ?></span>
            </div>
            <?php if ($i < count($steps) - 1): ?>
              <div class="h-1 flex-1 mx-1 md:mx-2 rounded-full -mt-6 <?= $i < $stepIndex ? 'bg-gradient-to-r from-primary to-secondary' : 'bg-cream' ?> transition-colors duration-500"></div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="grid md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-lg shadow-gray-100/50 p-6" data-aos="fade-up">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary"><i class="fa-solid fa-location-dot"></i></span>
        <h2 class="font-bold text-primary font-outfit">Detail Pengiriman</h2>
      </div>
      <p class="text-sm font-bold text-gray-800 mb-1"><?= e($order['customer_name']) ?></p>
      <p class="text-sm text-gray-500 mb-2"><?= e($order['customer_phone'] ?? '-') ?></p>
      <p class="text-sm text-gray-600 leading-relaxed mb-3"><?= nl2br(e($order['shipping_address'])) ?></p>
      <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Metode: <span class="text-gray-600 normal-case font-semibold"><?= e($order['shipping_name']) ?></span></p>
      <?php if (!empty($order['notes'])): ?>
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mt-1.5">Catatan: <span class="text-gray-600 normal-case font-semibold"><?= e($order['notes']) ?></span></p>
      <?php endif; ?>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-lg shadow-gray-100/50 p-6" data-aos="fade-up" data-aos-delay="60">
      <div class="flex items-center gap-3 mb-4">
        <span class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary"><i class="fa-solid fa-receipt"></i></span>
        <h2 class="font-bold text-primary font-outfit">Ringkasan Pembayaran</h2>
      </div>
      <div class="space-y-2 text-sm">
        <div class="flex justify-between text-gray-500"><span>Subtotal</span><span class="font-medium text-gray-700"><?= rupiah($order['subtotal']) ?></span></div>
        <div class="flex justify-between text-gray-500"><span>Ongkos Kirim</span><span class="font-medium text-gray-700"><?= rupiah($order['shipping_cost']) ?></span></div>
        <div class="flex justify-between font-extrabold text-lg border-t border-gray-100 pt-3 mt-2"><span class="text-gray-800">Total</span><span class="text-primary font-outfit"><?= rupiah($order['total']) ?></span></div>
      </div>
    </div>
  </div>

  <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-lg shadow-gray-100/50 p-6 mb-6" data-aos="fade-up">
    <div class="flex items-center gap-3 mb-4">
      <span class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary"><i class="fa-solid fa-bag-shopping"></i></span>
      <h2 class="font-bold text-primary font-outfit">Item Pesanan</h2>
    </div>
    <div class="divide-y divide-gray-100">
      <?php foreach ($items as $item): ?>
        <div class="flex justify-between py-2.5 text-sm">
          <span class="text-gray-600">&times;<?= $item['quantity'] ?> <?= e($item['product_name']) ?></span>
          <span class="font-bold text-gray-800"><?= rupiah($item['subtotal']) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-lg shadow-gray-100/50 p-6" data-aos="fade-up">
    <div class="flex items-center gap-3 mb-4">
      <span class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary"><i class="fa-solid fa-money-check-dollar"></i></span>
      <h2 class="font-bold text-primary font-outfit">Pembayaran</h2>
    </div>

    <div class="bg-cream rounded-2xl p-5 mb-5 text-sm flex items-center gap-4">
      <span class="w-11 h-11 rounded-xl bg-white flex items-center justify-center text-primary text-lg flex-shrink-0 shadow-sm"><i class="fa-solid fa-building-columns"></i></span>
      <div>
        <p class="font-bold text-gray-800"><?= e($settings['bank_name'] ?? '-') ?> &middot; <?= e($settings['bank_account_number'] ?? '-') ?></p>
        <p class="text-gray-500 text-xs mt-0.5">a.n. <?= e($settings['bank_account_name'] ?? '-') ?></p>
      </div>
    </div>

    <?php if ($payment): ?>
      <div class="mb-5 flex items-start gap-4 flex-wrap">
        <img src="<?= uploadUrl('payment_proofs', $payment['payment_proof']) ?>" class="w-32 h-32 object-cover rounded-2xl border border-gray-200 shadow-sm">
        <div>
          <p class="text-xs text-gray-400 font-semibold uppercase tracking-wide mb-1">Status Verifikasi</p>
          <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border
            <?= $payment['status'] === 'verified' ? 'bg-green-50 text-green-700 border-green-200' : ($payment['status'] === 'rejected' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200') ?>">
            <i class="fa-solid <?= $payment['status'] === 'verified' ? 'fa-circle-check' : ($payment['status'] === 'rejected' ? 'fa-circle-xmark' : 'fa-clock') ?>"></i>
            <?= ucfirst(e($payment['status'])) ?>
          </span>
          <?php if ($payment['status'] === 'rejected'): ?>
            <p class="text-xs text-red-500 mt-2 max-w-xs">Bukti transfer ditolak. Silakan unggah ulang bukti transfer yang valid.</p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!$payment || $payment['status'] === 'rejected'): ?>
      <form method="POST" action="<?= BASE_URL ?>/pesanan/<?= e($order['order_code']) ?>/bayar" enctype="multipart/form-data" class="space-y-3">
        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
        <label class="dropzone relative flex flex-col items-center justify-center gap-2 border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center cursor-pointer hover:border-secondary/50 transition-colors duration-300">
          <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" required class="dropzone-input absolute inset-0 opacity-0 cursor-pointer">
          <span class="w-12 h-12 rounded-2xl bg-cream flex items-center justify-center text-primary text-xl"><i class="fa-solid fa-cloud-arrow-up"></i></span>
          <span class="dropzone-label text-sm font-semibold text-gray-600">Klik atau seret file bukti transfer ke sini</span>
          <span class="text-xs text-gray-400 font-light">Format JPG, PNG, atau PDF &middot; maksimal 2MB</span>
        </label>
        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
          <i class="fa-solid fa-paper-plane text-sm"></i> Unggah Bukti Transfer
        </button>
      </form>
    <?php endif; ?>
  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
