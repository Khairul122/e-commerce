<?php $pageTitle = 'Profil Saya'; include APP_PATH . '/views/layouts/header.php'; ?>

<div class="absolute top-32 right-10 w-72 h-72 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <div class="mb-8" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Akun Saya</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-primary font-outfit mt-3">Profil Saya</h1>
    <p class="text-gray-500 font-light text-sm mt-1">Kelola data diri dan alamat pengiriman Anda.</p>
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

  <div class="grid md:grid-cols-3 gap-6 items-start">

    <!-- Identity card -->
    <div class="md:col-span-1 bg-gradient-to-br from-primary to-primary-dark rounded-[2rem] p-7 text-cream text-center relative overflow-hidden" data-aos="fade-up">
      <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-secondary/15 rounded-full blur-2xl"></div>
      <div class="relative">
        <div class="w-20 h-20 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center text-3xl font-extrabold mx-auto mb-4">
          <?= strtoupper(substr(e($user['name']), 0, 1)) ?>
        </div>
        <p class="font-bold text-lg"><?= e($user['name']) ?></p>
        <p class="text-xs text-cream/60 font-light mt-1 break-all"><?= e($user['email']) ?></p>
        <span class="inline-flex items-center gap-1.5 mt-4 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-[10px] font-bold uppercase tracking-widest">
          <i class="fa-solid fa-user-check text-secondary"></i> Pelanggan
        </span>
      </div>
      <div class="relative mt-6 pt-5 border-t border-white/10 grid grid-cols-2 gap-3 text-left">
        <a href="<?= BASE_URL ?>/pesanan" class="text-xs font-semibold text-cream/80 hover:text-white transition flex items-center gap-1.5">
          <i class="fa-solid fa-bag-shopping text-secondary"></i> Pesanan
        </a>
        <a href="<?= BASE_URL ?>/cart" class="text-xs font-semibold text-cream/80 hover:text-white transition flex items-center gap-1.5">
          <i class="fa-solid fa-cart-shopping text-secondary"></i> Keranjang
        </a>
      </div>
    </div>

    <!-- Edit form -->
    <div class="md:col-span-2 bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-8" data-aos="fade-up" data-aos-delay="60">
      <h2 class="font-bold text-lg text-primary font-outfit mb-5">Informasi Akun</h2>
      <form method="POST" action="<?= BASE_URL ?>/profile" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400"><i class="fa-solid fa-user"></i></span>
            <input type="text" name="name" required value="<?= e($user['name']) ?>"
              class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" disabled value="<?= e($user['email']) ?>"
              class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-400 text-sm">
          </div>
          <p class="text-[11px] text-gray-400 font-light mt-1.5">Email tidak dapat diubah.</p>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nomor HP</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400"><i class="fa-solid fa-phone"></i></span>
            <input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>" placeholder="08xxxxxxxxxx"
              class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Alamat Pengiriman</label>
          <div class="relative">
            <span class="absolute top-3 left-0 pl-4 flex items-center text-gray-400"><i class="fa-solid fa-location-dot"></i></span>
            <textarea name="address" rows="3" placeholder="Alamat lengkap untuk pengiriman..."
              class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm"><?= e($user['address'] ?? '') ?></textarea>
          </div>
        </div>

        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-secondary text-white font-bold px-8 py-3.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10">
          <i class="fa-solid fa-check text-sm"></i> Simpan Perubahan
        </button>
      </form>
    </div>
  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
