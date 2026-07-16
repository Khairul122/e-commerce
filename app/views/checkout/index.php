<?php $pageTitle = 'Checkout'; include APP_PATH . '/views/layouts/header.php'; ?>

<div class="absolute top-32 right-10 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>

<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <div class="mb-10" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Langkah 2 dari 2</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-primary font-outfit mt-3">Selesaikan Pesanan Anda</h1>
    <p class="text-gray-500 font-light text-sm mt-1">Lengkapi alamat dan metode pengiriman sebelum konfirmasi.</p>
  </div>

  <form method="POST" action="<?= BASE_URL ?>/checkout" data-confirm="Buat pesanan sekarang?" class="grid lg:grid-cols-3 gap-8 items-start">
    <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

    <div class="lg:col-span-2 space-y-6">
      <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-7" data-aos="fade-up">
        <div class="flex items-center gap-3 mb-4">
          <span class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary"><i class="fa-solid fa-location-dot"></i></span>
          <h2 class="font-bold text-lg text-primary font-outfit">Alamat Pengiriman</h2>
        </div>
        <textarea name="address" rows="3" required placeholder="Masukkan alamat lengkap termasuk patokan..."
                  class="w-full rounded-2xl border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition px-4 py-3 text-sm"><?= e($user['address'] ?? '') ?></textarea>
      </div>

      <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-7" data-aos="fade-up" data-aos-delay="60">
        <div class="flex items-center gap-3 mb-4">
          <span class="w-9 h-9 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary"><i class="fa-solid fa-truck-fast"></i></span>
          <h2 class="font-bold text-lg text-primary font-outfit">Metode Pengiriman</h2>
        </div>
        <div class="space-y-3">
          <?php foreach ($shippingMethods as $i => $sm): ?>
            <label class="relative flex items-center gap-4 border-2 border-gray-100 rounded-2xl p-4 cursor-pointer hover:border-secondary/50 has-[:checked]:border-secondary has-[:checked]:bg-secondary/5 transition-all duration-300">
              <input type="radio" name="shipping_method_id" value="<?= $sm['id'] ?>" <?= $i === 0 ? 'checked' : '' ?> required class="peer sr-only">
              <span class="w-11 h-11 rounded-xl bg-cream flex items-center justify-center text-primary flex-shrink-0 peer-checked:bg-secondary peer-checked:text-white transition-colors duration-300">
                <i class="fa-solid <?= $sm['cost'] > 0 ? 'fa-motorcycle' : 'fa-store' ?>"></i>
              </span>
              <div class="flex-1 min-w-0">
                <p class="font-bold text-gray-800 text-sm"><?= e($sm['name']) ?></p>
                <p class="text-xs text-gray-500 mt-0.5"><?= e($sm['description']) ?></p>
              </div>
              <p class="font-extrabold text-secondary text-sm flex-shrink-0"><?= $sm['cost'] > 0 ? rupiah($sm['cost']) : 'Gratis' ?></p>
              <span class="absolute top-4 right-4 w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-secondary peer-checked:bg-secondary flex items-center justify-center transition-colors duration-300">
                <i class="fa-solid fa-check text-[9px] text-white opacity-0 peer-checked:opacity-100"></i>
              </span>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-7" data-aos="fade-up" data-aos-delay="120">
        <div class="flex items-center gap-3 mb-4">
          <span class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center text-primary"><i class="fa-solid fa-note-sticky"></i></span>
          <h2 class="font-bold text-lg text-primary font-outfit">Catatan <span class="text-gray-400 font-normal text-sm">(opsional)</span></h2>
        </div>
        <textarea name="notes" rows="2" placeholder="Contoh: tolong dibungkus terpisah..."
                  class="w-full rounded-2xl border-gray-200 focus:ring-2 focus:ring-primary focus:border-transparent transition px-4 py-3 text-sm"></textarea>
      </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 lg:sticky lg:top-28" data-aos="fade-up" data-aos-delay="80">
      <h2 class="font-bold text-lg text-primary font-outfit mb-4">Ringkasan Pesanan</h2>
      <div class="space-y-2.5 text-sm mb-4 max-h-64 overflow-y-auto pr-1">
        <?php foreach ($items as $item): ?>
          <div class="flex justify-between gap-2">
            <span class="text-gray-500 truncate">&times;<?= $item['quantity'] ?> <?= e($item['name']) ?></span>
            <span class="font-semibold text-gray-700 flex-shrink-0"><?= rupiah($item['price'] * $item['quantity']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="border-t border-gray-100 pt-4 space-y-1.5">
        <div class="flex justify-between text-sm text-gray-500">
          <span>Subtotal</span><span><?= rupiah($subtotal) ?></span>
        </div>
        <p class="text-xs text-gray-400 font-light">*Ongkir ditambahkan sesuai metode pengiriman terpilih</p>
      </div>
      <button type="submit" class="w-full mt-6 flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
        Buat Pesanan <i class="fa-solid fa-check text-sm"></i>
      </button>
    </div>
  </form>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
