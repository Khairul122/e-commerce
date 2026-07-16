<?php include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Decorative Floating Blobs in Background -->
<div class="absolute top-40 left-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>
<div class="absolute top-[800px] right-10 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-medium z-0"></div>

<!-- HERO -->
<section class="relative z-10 overflow-hidden">
  <div class="hero-swiper swiper h-[92vh] min-h-[560px] w-full -mt-20">
    <div class="swiper-wrapper">
      <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $banner): ?>
          <div class="swiper-slide relative overflow-hidden group">
            <img src="<?= uploadUrl('banners', $banner['image']) ?>" alt="<?= e($banner['title'] ?? '') ?>" class="w-full h-full object-cover transform scale-105 group-hover:scale-100 transition-transform duration-[6000ms]">
            <div class="absolute inset-0 bg-gradient-to-t from-dark/85 via-dark/30 to-dark/10"></div>
            <div class="absolute inset-0 grain-overlay pointer-events-none"></div>
            <div class="absolute inset-0 flex items-end pb-28 md:pb-32">
              <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 w-full">
                <div class="max-w-2xl text-white" data-aos="fade-up" data-aos-duration="900">
                  <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-secondary text-xs font-bold uppercase tracking-widest backdrop-blur-sm border border-white/15 mb-5">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span> Kuliner Rumahan Padang
                  </span>
                  <h1 class="font-display italic text-5xl md:text-7xl font-medium leading-[0.95] tracking-tight drop-shadow-sm">
                    <?= e($banner['title'] ?? 'Pastry & Makanan Siap Saji') ?>
                  </h1>
                  <p class="text-white/75 text-sm md:text-base font-light leading-relaxed max-w-md mt-5">
                    Higienis, tanpa pengawet, dan selalu segar setiap hari — dipesan langsung dari dapur UKM ARC.
                  </p>
                  <div class="pt-7 flex items-center gap-4">
                    <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 bg-gradient-to-r from-secondary to-orange-500 text-white font-bold px-8 py-3.5 rounded-full hover:brightness-110 transition duration-300 shadow-lg shadow-secondary/25 hover:shadow-xl hover:shadow-secondary/35 active:scale-95 transform">
                      Pesan Sekarang <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#tentang" class="inline-flex items-center gap-2 text-white/80 hover:text-white font-semibold text-sm transition">
                      <span class="w-9 h-9 rounded-full border border-white/30 flex items-center justify-center"><i class="fa-solid fa-chevron-down text-xs"></i></span>
                      Kenali kami
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="swiper-slide relative bg-gradient-to-br from-primary via-primary-dark to-dark text-white flex items-end pb-28 md:pb-32">
          <div class="absolute inset-0 grain-overlay pointer-events-none"></div>
          <div class="max-w-7xl mx-auto px-6 sm:px-12 lg:px-16 w-full">
            <div class="max-w-2xl">
              <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-secondary text-xs font-bold uppercase tracking-widest backdrop-blur-sm border border-white/15 mb-5">
                <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span> Kuliner Rumahan Padang
              </span>
              <h1 class="font-display italic text-5xl md:text-7xl font-medium leading-[0.95]">Pastry & Makanan Siap Saji Khas Padang</h1>
              <p class="text-white/75 font-light max-w-md mt-5">Pesan langsung tanpa ribet, kami antar sampai tujuan dengan kemasan aman dan higienis.</p>
              <div class="pt-7">
                <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 bg-secondary text-white font-bold px-8 py-3.5 rounded-full hover:bg-secondary-dark transition duration-300 shadow-md">
                  Pesan Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="swiper-pagination"></div>
  </div>

  <!-- Marquee tag ticker overlapping hero bottom edge -->
  <div class="relative z-20 -mt-8 md:-mt-9">
    <div class="bg-gradient-to-r from-primary to-primary-dark py-3.5 overflow-hidden whitespace-nowrap shadow-xl">
      <div class="marquee-track inline-flex items-center gap-10 text-cream/90 text-xs md:text-sm font-bold uppercase tracking-widest">
        <?php for ($r = 0; $r < 2; $r++): ?>
          <span class="inline-flex items-center gap-10">
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-leaf text-secondary"></i> Tanpa Pengawet</span>
            <span class="opacity-30">&bull;</span>
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-hand-sparkles text-secondary"></i> Higienis &amp; Segar</span>
            <span class="opacity-30">&bull;</span>
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-truck-fast text-secondary"></i> Antar Dalam Kota Padang</span>
            <span class="opacity-30">&bull;</span>
            <span class="inline-flex items-center gap-2"><i class="fa-solid fa-bowl-food text-secondary"></i> Dibuat Fresh Setiap Hari</span>
            <span class="opacity-30">&bull;</span>
          </span>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>

<!-- KATEGORI -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 relative z-10">
  <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12" data-aos="fade-up">
    <div class="max-w-md">
      <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Kategori Menu</span>
      <h2 class="font-display italic text-3xl md:text-5xl font-medium text-primary mt-4 leading-tight">Pilih kategori favorit Anda</h2>
    </div>
    <p class="text-gray-500 max-w-xs text-sm font-light md:text-right">Geser untuk menjelajahi sajian lezat kami berdasarkan kategori pilihan terbaik.</p>
  </div>

  <div class="flex md:grid md:grid-cols-4 gap-6 overflow-x-auto md:overflow-visible pb-6 md:pb-0 -mx-4 md:mx-0 px-4 md:px-0 snap-x snap-mandatory scrollbar-none" style="scrollbar-width: none;">
    <?php foreach ($categories as $i => $cat): ?>
      <?php
        // Category specific colors for premium look
        $colorThemes = [
          'Pastry' => [
            'bg' => 'from-pink-50 to-rose-50',
            'iconBg' => 'bg-pink-50 text-pink-600',
            'activeIcon' => 'from-pink-500 to-rose-500',
            'border' => 'group-hover:border-pink-200',
            'glow' => 'hover:shadow-pink-100',
          ],
          'Nasi Box' => [
            'bg' => 'from-amber-50 to-orange-50',
            'iconBg' => 'bg-amber-50 text-amber-600',
            'activeIcon' => 'from-amber-500 to-orange-500',
            'border' => 'group-hover:border-amber-200',
            'glow' => 'hover:shadow-amber-100',
          ],
          'Snack Box' => [
            'bg' => 'from-yellow-50 to-amber-50',
            'iconBg' => 'bg-yellow-50 text-amber-800',
            'activeIcon' => 'from-yellow-500 to-amber-500',
            'border' => 'group-hover:border-yellow-200',
            'glow' => 'hover:shadow-yellow-100',
          ],
          'Makanan Berat' => [
            'bg' => 'from-rose-50 to-orange-50',
            'iconBg' => 'bg-rose-50 text-rose-600',
            'activeIcon' => 'from-rose-500 to-orange-500',
            'border' => 'group-hover:border-rose-200',
            'glow' => 'hover:shadow-rose-100',
          ]
        ];
        
        $theme = $colorThemes[$cat['name']] ?? [
          'bg' => 'from-cream to-white',
          'iconBg' => 'bg-cream text-primary',
          'activeIcon' => 'from-primary to-secondary',
          'border' => 'group-hover:border-primary/20',
          'glow' => 'hover:shadow-primary/5',
        ];
      ?>
      <a href="<?= BASE_URL ?>/produk?category=<?= $cat['id'] ?>"
         class="group relative flex-shrink-0 w-64 md:w-auto snap-start overflow-hidden bg-white/80 backdrop-blur-md rounded-[2.25rem] p-8 flex flex-col items-start gap-6 border border-gray-100/80 shadow-sm hover:shadow-2xl <?= $theme['glow'] ?> hover:border-transparent hover:-translate-y-3 transition-all duration-500 ease-out <?= $i % 2 === 1 ? 'md:translate-y-4' : '' ?>"
         data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
        
        <!-- Decorative subtle colored gradient backdrop on hover -->
        <div class="absolute inset-0 bg-gradient-to-br <?= $theme['bg'] ?> opacity-0 group-hover:opacity-40 transition-opacity duration-500"></div>

        <!-- Big Card Index Number -->
        <div class="flex justify-between items-center w-full relative z-10">
          <span class="font-outfit text-5xl font-black text-gray-100 group-hover:text-primary/10 transition-colors duration-500 leading-none">
            <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?>
          </span>
          <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-white group-hover:text-primary group-hover:rotate-45 transition-all duration-500 shadow-sm">
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </div>
        </div>

        <!-- Animated Icon Container -->
        <div class="w-16 h-16 rounded-[1.25rem] <?= $theme['iconBg'] ?> flex items-center justify-center text-3xl group-hover:bg-gradient-to-tr group-hover:<?= $theme['activeIcon'] ?> group-hover:text-white group-hover:rotate-12 group-hover:scale-110 transition-all duration-500 shadow-sm relative z-10">
          <i class="fa-solid fa-<?= e($cat['icon'] ?: 'utensils') ?>"></i>
        </div>

        <!-- Content -->
        <div class="space-y-2 relative z-10 w-full">
          <h3 class="font-bold text-gray-800 text-lg group-hover:text-primary transition duration-300 tracking-wide leading-snug"><?= e($cat['name']) ?></h3>
          <p class="text-xs text-gray-400 leading-relaxed font-light group-hover:text-gray-600 transition-colors duration-300">
            <?php
              if ($cat['name'] === 'Pastry') echo 'Aneka cake, roti, dan kue manis dipanggang segar.';
              elseif ($cat['name'] === 'Nasi Box') echo 'Pilihan menu nasi kotak praktis, higienis & lezat.';
              elseif ($cat['name'] === 'Snack Box') echo 'Kudapan kue asin dan manis untuk berbagai acara.';
              elseif ($cat['name'] === 'Makanan Berat') echo 'Lauk pauk siap saji praktis khas cita rasa Minang.';
              else echo 'Jelajahi kelezatan menu pilihan dari dapur kami.';
            ?>
          </p>
        </div>

        <!-- Call to action link -->
        <span class="inline-flex items-center gap-1.5 text-xs text-secondary font-bold tracking-wider uppercase group-hover:text-primary transition-colors duration-300 relative z-10 mt-2">
          Lihat Menu 
          <i class="fa-solid fa-chevron-right text-[9px] group-hover:translate-x-1 transition-transform duration-300"></i>
        </span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- PRODUK UNGGULAN (bento) -->
<section class="bg-white/60 backdrop-blur-md border-y border-white py-20 relative z-10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14" data-aos="fade-up">
      <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Rekomendasi Utama</span>
      <h2 class="font-display italic text-3xl md:text-5xl font-medium text-primary mt-4">Produk unggulan terlaris</h2>
      <p class="text-gray-500 mt-3 max-w-md mx-auto font-light text-sm">Produk premium buatan rumah yang paling banyak dicari dan dinikmati pelanggan.</p>
    </div>

    <?php if (!empty($featuredProducts)): ?>
      <?php 
        $featuredProducts = array_slice($featuredProducts, 0, 5);
        $__first = $featuredProducts[0]; 
        $__rest = array_slice($featuredProducts, 1); 
      ?>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6 auto-rows-[1fr]">
        <!-- Hero bento card: first featured product -->
        <a href="<?= BASE_URL ?>/produk/<?= e($__first['slug']) ?>"
           class="group relative col-span-2 row-span-2 rounded-[2rem] overflow-hidden shadow-xl shadow-gray-200/60 hover:shadow-2xl transition-all duration-500 min-h-[320px] md:min-h-[420px]"
           data-aos="fade-up">
          <img src="<?= uploadUrl('products', $__first['image'] ?? null) ?>" alt="<?= e($__first['name']) ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-dark/20 to-transparent"></div>
          <span class="absolute top-6 left-6 px-3.5 py-1.5 rounded-full bg-secondary text-white text-[10px] font-bold uppercase tracking-widest shadow-md">Paling Laris</span>
          <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white">
            <?php if (!empty($__first['category_name'])): ?>
              <span class="text-xs text-white/70 font-medium tracking-wide"><?= e($__first['category_name']) ?></span>
            <?php endif; ?>
            <h3 class="font-display italic text-2xl md:text-3xl font-medium mt-1 leading-snug"><?= e($__first['name']) ?></h3>
            <div class="flex items-center justify-between mt-4">
              <p class="text-secondary font-extrabold text-xl font-outfit"><?= rupiah($__first['price']) ?></p>
              <span class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur-sm flex items-center justify-center group-hover:bg-secondary transition-colors duration-500">
                <i class="fa-solid fa-arrow-right text-sm group-hover:translate-x-0.5 transition-transform"></i>
              </span>
            </div>
          </div>
        </a>

        <?php foreach ($__rest as $i => $product): ?>
          <div data-aos="fade-up" data-aos-delay="<?= $i * 60 ?>">
            <?php include APP_PATH . '/views/products/_card.php'; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="text-center mt-14" data-aos="fade-up">
      <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 border-2 border-primary text-primary hover:bg-primary hover:text-cream font-bold px-8 py-3 rounded-full hover:shadow-lg active:scale-98 transition duration-300">
        Lihat Semua Produk <i class="fa-solid fa-store text-sm"></i>
      </a>
    </div>
  </div>
</section>

<!-- TENTANG KAMI -->
<section id="tentang" class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 overflow-hidden z-10">
  <!-- Floating decoration -->
  <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-medium"></div>

  <div class="grid md:grid-cols-2 gap-16 items-center">
    <div class="relative" data-aos="fade-right">
      <div class="absolute inset-0 bg-gradient-to-tr from-primary to-secondary rounded-3xl transform rotate-3 scale-98 opacity-10"></div>
      <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white transition hover:scale-102 duration-500">
        <img src="<?= BASE_URL ?>/assets/images/about_us.png" alt="Tentang UKM ARC" class="w-full object-cover aspect-[4/3]">
        <div class="absolute inset-0 bg-gradient-to-t from-dark/60 via-transparent to-transparent"></div>
      </div>
      <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl border border-gray-100 p-5 hidden md:flex items-center gap-3 max-w-[220px]">
        <span class="w-11 h-11 rounded-xl bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white flex-shrink-0"><i class="fa-solid fa-heart"></i></span>
        <p class="text-xs font-semibold text-gray-600 leading-snug">Diracik dengan resep turun-temurun khas Ranah Minang</p>
      </div>
    </div>
    <div data-aos="fade-left" class="space-y-6">
      <span class="px-4 py-1.5 rounded-full bg-cream text-primary text-xs font-bold uppercase tracking-wider">Mengenal Kami</span>
      <h2 class="font-display italic text-3xl md:text-5xl font-medium text-primary leading-tight">Kelezatan autentik dapur UKM ARC</h2>
      <p class="text-gray-600 leading-relaxed text-sm md:text-base font-light"><?= e($settings['about_text'] ?? '') ?></p>

      <div class="grid grid-cols-2 gap-5 pt-4">
        <div class="bg-white/60 backdrop-blur-sm border border-white/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300">
          <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-3">
            <i class="fa-solid fa-leaf text-xl"></i>
          </div>
          <h4 class="font-bold text-gray-800 text-sm mb-1">100% Bahan Pilihan</h4>
          <p class="text-xs text-gray-500 leading-relaxed">Tanpa bahan pengawet buatan, higienis, dan sehat.</p>
        </div>
        <div class="bg-white/60 backdrop-blur-sm border border-white/80 rounded-2xl p-5 shadow-sm hover:shadow-md transition duration-300">
          <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary mb-3">
            <i class="fa-solid fa-hand-sparkles text-xl"></i>
          </div>
          <h4 class="font-bold text-gray-800 text-sm mb-1">Higienis & Segar</h4>
          <p class="text-xs text-gray-500 leading-relaxed">Dibuat fresh setiap hari dengan standar kebersihan tinggi.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TESTIMONI -->
<?php if (!empty($testimonials)): ?>
<section class="bg-gradient-to-b from-white to-cream/35 py-20 relative overflow-hidden z-10">
  <div class="absolute top-10 left-10 w-60 h-60 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-14" data-aos="fade-up">
      <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Ulasan Pelanggan</span>
      <h2 class="font-display italic text-3xl md:text-5xl font-medium text-primary mt-4">Kata mereka yang menikmati</h2>
    </div>

    <div class="testi-swiper swiper pb-16">
      <div class="swiper-wrapper">
        <?php foreach ($testimonials as $t): ?>
          <div class="swiper-slide">
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-100/50 flex flex-col justify-between h-full hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
              <div>
                <div class="flex justify-between items-center mb-5">
                  <div class="text-secondary flex gap-1">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                      <i class="fa-solid fa-star text-sm <?= $i < $t['rating'] ? 'text-amber-400' : 'text-gray-200' ?>"></i>
                    <?php endfor; ?>
                  </div>
                  <i class="fa-solid fa-quote-right text-3xl text-primary/10"></i>
                </div>
                <p class="text-gray-600 italic text-sm md:text-base leading-relaxed mb-6">"<?= e($t['message']) ?>"</p>
              </div>
              <div class="flex items-center gap-3 border-t border-gray-100 pt-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-primary to-secondary flex items-center justify-center text-white font-bold text-sm">
                  <?= strtoupper(substr(e($t['customer_name']), 0, 1)) ?>
                </div>
                <div>
                  <p class="font-bold text-primary text-sm"><?= e($t['customer_name']) ?></p>
                  <p class="text-[10px] text-gray-400">Pelanggan Terverifikasi</p>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- KONTAK & MAPS -->
<section class="relative z-10 w-full overflow-hidden border-t border-gray-200/50 bg-white/60 backdrop-blur-md">
  <div class="grid md:grid-cols-12 gap-0 min-h-[500px]">
    <!-- Left Column (Contact Cards) -->
    <div class="md:col-span-7 p-8 md:p-12 lg:p-16 xl:p-20 flex flex-col justify-between" data-aos="fade-right">
      <div class="space-y-8">
        <div>
          <span class="px-4 py-1.5 rounded-full bg-cream text-primary text-xs font-bold uppercase tracking-wider">Kunjungi Kami</span>
          <h2 class="font-display italic text-3xl md:text-5xl font-medium text-primary mt-4 mb-4">Mari berkunjung</h2>
          <p class="text-gray-500 font-light text-sm max-w-sm">Pintu dapur kami selalu terbuka. Silakan hubungi kami untuk info ketersediaan menu harian.</p>
        </div>

        <div class="space-y-4">
          <!-- Alamat Card -->
          <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/85 border border-gray-100 shadow-sm hover:shadow-md hover:border-primary/20 transition-all duration-300 group/item" data-aos="fade-up" data-aos-delay="50">
            <span class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary flex-shrink-0 group-hover/item:bg-primary group-hover/item:text-white group-hover/item:scale-105 transition-all duration-300">
              <i class="fa-solid fa-location-dot text-lg"></i>
            </span>
            <div>
              <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Alamat</p>
              <p class="text-sm font-semibold text-gray-700 mt-1 leading-relaxed"><?= e($settings['address'] ?? '') ?></p>
            </div>
          </div>
          
          <!-- Telepon Card -->
          <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/85 border border-gray-100 shadow-sm hover:shadow-md hover:border-secondary/20 transition-all duration-300 group/item" data-aos="fade-up" data-aos-delay="100">
            <span class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0 group-hover/item:bg-secondary group-hover/item:text-white group-hover/item:scale-105 transition-all duration-300">
              <i class="fa-solid fa-phone text-lg"></i>
            </span>
            <div>
              <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Telepon / WhatsApp</p>
              <p class="text-sm font-semibold text-gray-700 mt-1"><?= e($settings['phone'] ?? '') ?> / <?= e($settings['whatsapp'] ?? '') ?></p>
            </div>
          </div>
          
          <!-- Jam Buka Card -->
          <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/85 border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all duration-300 group/item" data-aos="fade-up" data-aos-delay="150">
            <span class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover/item:bg-emerald-600 group-hover/item:text-white group-hover/item:scale-105 transition-all duration-300">
              <i class="fa-solid fa-clock text-lg"></i>
            </span>
            <div>
              <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Jam Buka</p>
              <p class="text-sm font-semibold text-gray-700 mt-1">Senin - Sabtu, 08.00 - 18.00 WIB</p>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-8 md:pt-6" data-aos="fade-up" data-aos-delay="200">
        <a href="https://wa.me/<?= e($settings['whatsapp'] ?? '') ?>" target="_blank" 
           class="group/btn inline-flex items-center gap-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold px-8 py-4 rounded-2xl hover:brightness-105 hover:-translate-y-0.5 transition-all duration-300 shadow-lg shadow-emerald-500/20 active:scale-98 transform">
          <i class="fa-brands fa-whatsapp text-2xl group-hover/btn:scale-110 transition-transform duration-300"></i>
          <span>Hubungi via WhatsApp</span>
        </a>
      </div>
    </div>

    <!-- Right Column (Map with Floating Badge, Shrunk and Framed) -->
    <div class="md:col-span-5 p-6 lg:p-8 flex items-center justify-center bg-gray-50/10" data-aos="fade-left">
      <div class="w-full h-[380px] rounded-[2rem] overflow-hidden shadow-lg border-4 border-white relative">
        <!-- Masking attribution text from OpenStreetMap using a clean CSS crop wrapper -->
        <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=100.30%2C-0.98%2C100.42%2C-0.88&layer=mapnik"
                class="w-full border-0 grayscale-[8%] contrast-[105%]" 
                style="height: calc(100% + 40px); margin-bottom: -40px;"
                loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
