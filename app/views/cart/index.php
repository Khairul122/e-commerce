<?php $pageTitle = 'Keranjang Belanja'; include APP_PATH . '/views/layouts/header.php'; ?>

<div class="absolute top-32 left-10 w-80 h-80 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>
<div class="absolute top-[600px] right-0 w-72 h-72 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-medium z-0"></div>

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <div class="mb-10" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Langkah 1 dari 2</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-primary font-outfit mt-3">Keranjang Belanja</h1>
    <p class="text-gray-500 font-light text-sm mt-1">Periksa kembali pesanan Anda sebelum lanjut ke pembayaran.</p>
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

  <?php if (empty($items)): ?>
    <div class="text-center py-24 bg-white/60 backdrop-blur-sm rounded-[2rem] border border-white shadow-sm" data-aos="fade-up">
      <div class="w-24 h-24 bg-cream rounded-full flex items-center justify-center text-primary text-4xl mx-auto mb-5 animate-float-medium">
        <i class="fa-solid fa-cart-shopping"></i>
      </div>
      <h3 class="text-lg font-bold text-gray-800">Keranjang Anda masih kosong</h3>
      <p class="text-gray-400 font-light text-sm mt-1 max-w-xs mx-auto">Yuk jelajahi katalog kami dan temukan pastry favorit Anda hari ini.</p>
      <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 mt-6 bg-gradient-to-r from-primary to-secondary text-white font-bold px-8 py-3.5 rounded-full hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
        Mulai Belanja <i class="fa-solid fa-arrow-right text-sm"></i>
      </a>
    </div>
  <?php else: ?>
    <div class="grid lg:grid-cols-3 gap-8 items-start">

      <!-- Item List -->
      <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 divide-y divide-gray-100 overflow-hidden" data-aos="fade-up">
        <?php foreach ($items as $i => $item): ?>
          <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-5" data-aos="fade-up" data-aos-delay="<?= min($i * 40, 200) ?>">
            <a href="<?= BASE_URL ?>/produk/<?= e($item['slug']) ?>" class="w-20 h-20 rounded-2xl overflow-hidden bg-cream flex-shrink-0 border border-gray-100">
              <img src="<?= uploadUrl('products', $item['image'] ?? null) ?>" alt="<?= e($item['name']) ?>" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
            </a>

            <div class="flex-1 min-w-0">
              <a href="<?= BASE_URL ?>/produk/<?= e($item['slug']) ?>" class="font-bold text-gray-800 hover:text-primary transition truncate block text-sm md:text-base"><?= e($item['name']) ?></a>
              <p class="text-secondary font-extrabold text-sm mt-0.5"><?= rupiah($item['price']) ?></p>
            </div>

            <form method="POST" action="<?= BASE_URL ?>/cart/update" class="flex items-center gap-3 flex-shrink-0">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
              <div class="qty-group flex items-center gap-1 bg-cream/70 border border-gray-200/80 rounded-2xl px-1.5 py-1">
                <button type="button" class="qty-minus w-8 h-8 rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition duration-300 font-bold text-sm select-none">-</button>
                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" readonly
                       class="qty-input w-10 bg-transparent text-center border-0 focus:ring-0 text-sm font-bold text-gray-800 pointer-events-none">
                <button type="button" class="qty-plus w-8 h-8 rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition duration-300 font-bold text-sm select-none">+</button>
              </div>
              <button type="submit" title="Perbarui jumlah" class="w-9 h-9 rounded-xl bg-primary/10 text-primary hover:bg-primary hover:text-white transition duration-300 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-rotate text-xs"></i>
              </button>
            </form>

            <p class="font-extrabold text-gray-800 text-sm w-full sm:w-24 text-left sm:text-right"><?= rupiah($item['price'] * $item['quantity']) ?></p>

            <form method="POST" action="<?= BASE_URL ?>/cart/remove" data-confirm="Hapus produk ini dari keranjang?">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <input type="hidden" name="cart_item_id" value="<?= $item['cart_item_id'] ?>">
              <button type="submit" title="Hapus" class="w-9 h-9 rounded-xl text-red-400 hover:bg-red-50 hover:text-red-600 transition duration-300 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-trash text-sm"></i>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Sticky Summary -->
      <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 lg:sticky lg:top-28" data-aos="fade-up" data-aos-delay="100">
        <h2 class="font-bold text-lg text-primary font-outfit mb-4">Ringkasan Belanja</h2>
        <div class="space-y-2.5 text-sm border-b border-gray-100 pb-4 mb-4">
          <div class="flex justify-between text-gray-500">
            <span><?= count($items) ?> jenis produk</span>
            <span class="font-medium text-gray-700"><?= rupiah($subtotal) ?></span>
          </div>
          <p class="text-xs text-gray-400 font-light">Ongkos kirim dihitung pada langkah checkout.</p>
        </div>
        <div class="flex justify-between items-center mb-6">
          <span class="text-gray-500 text-sm font-medium">Subtotal</span>
          <span class="text-2xl font-extrabold text-primary font-outfit"><?= rupiah($subtotal) ?></span>
        </div>
        <a href="<?= BASE_URL ?>/checkout" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
          Lanjut Checkout <i class="fa-solid fa-arrow-right text-sm"></i>
        </a>
        <a href="<?= BASE_URL ?>/produk" class="w-full flex items-center justify-center gap-2 text-primary font-semibold text-sm mt-3 hover:underline">
          <i class="fa-solid fa-arrow-left text-xs"></i> Tambah produk lain
        </a>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
