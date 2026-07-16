<?php include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Glowing Decorative Blobs -->
<div class="absolute top-[20%] left-1/2 -translate-x-[150%] w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none -z-10 animate-float-slow"></div>
<div class="absolute bottom-[20%] left-1/2 translate-x-[80%] w-96 h-96 bg-secondary/15 rounded-full blur-3xl pointer-events-none -z-10 animate-float-medium"></div>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
  <div class="text-center mb-12" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-cream text-secondary text-xs font-bold uppercase tracking-wider">Suara Pelanggan</span>
    <h1 class="text-4xl md:text-5xl font-extrabold text-primary font-outfit mt-4 leading-tight">Testimoni & Review</h1>
    <p class="text-gray-500 mt-3 max-w-xl mx-auto font-light text-sm">Bagikan pengalaman rasa masakan dan pelayanan kami, atau lihat apa kata pelanggan setia kami.</p>
  </div>

  <!-- Flash Messages -->
  <?php if (!empty($flash['success'])): ?>
    <div class="max-w-3xl mx-auto bg-green-50 border border-green-200 text-green-700 text-sm rounded-2xl p-4 mb-8 flex items-center gap-2" data-aos="fade-up">
      <i class="fa-solid fa-circle-check"></i> <?= e($flash['success']) ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($flash['error'])): ?>
    <div class="max-w-3xl mx-auto bg-red-50 border border-red-200 text-red-700 text-sm rounded-2xl p-4 mb-8 flex items-center gap-2" data-aos="fade-up">
      <i class="fa-solid fa-circle-exclamation"></i> <?= e($flash['error']) ?>
    </div>
  <?php endif; ?>

  <div class="grid lg:grid-cols-3 gap-8 items-start">
    
    <!-- Testimonial Submission Form (Left/Top on mobile) -->
    <div class="lg:col-span-1" data-aos="fade-up">
      <div class="bg-white/80 backdrop-blur-md rounded-[2.25rem] border border-white shadow-xl shadow-gray-100/50 p-6 md:p-8 sticky top-24">
        <h2 class="font-bold text-xl text-primary font-outfit mb-2">Beri Testimoni</h2>
        <p class="text-gray-400 font-light text-xs mb-6">Bagikan komentar Anda agar membantu kami terus meningkatkan kualitas pelayanan kami.</p>
        
        <?php if ($__user): ?>
          <form method="POST" action="<?= BASE_URL ?>/testimoni" class="space-y-5">
            <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rating Kepuasan</label>
              <div class="flex flex-wrap gap-2.5">
                <?php for ($r = 5; $r >= 1; $r--): ?>
                  <label class="cursor-pointer group flex items-center gap-1.5 bg-cream/35 border border-gray-100 px-3.5 py-2 rounded-xl hover:bg-cream hover:border-secondary/35 transition duration-200">
                    <input type="radio" name="rating" value="<?= $r ?>" <?= $r === 5 ? 'checked' : '' ?> class="accent-secondary h-4 w-4">
                    <span class="flex items-center text-amber-500 text-xs gap-0.5">
                      <?php for ($s = 1; $s <= $r; $s++): ?>
                        <i class="fa-solid fa-star"></i>
                      <?php endfor; ?>
                    </span>
                  </label>
                <?php endfor; ?>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pesan Ulasan</label>
              <div class="relative">
                <span class="absolute top-3 left-0 pl-4 flex items-center text-gray-400"><i class="fa-solid fa-comment-dots"></i></span>
                <textarea name="message" rows="4" required placeholder="Tulis masukan tentang rasa makanan, kemasan, atau kecepatan pengantaran kami..."
                  class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm"></textarea>
              </div>
            </div>

            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-secondary to-orange-500 text-white font-bold py-3.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-secondary/15">
              <i class="fa-solid fa-paper-plane text-xs animate-pulse"></i> Kirim Testimoni
            </button>
          </form>
        <?php else: ?>
          <div class="bg-cream/40 border border-secondary/10 rounded-2xl p-5 text-center">
            <div class="w-12 h-12 rounded-full bg-cream flex items-center justify-center text-secondary text-xl mx-auto mb-3">
              <i class="fa-solid fa-lock"></i>
            </div>
            <p class="text-sm font-semibold text-primary">Ingin meninggalkan review?</p>
            <p class="text-xs text-gray-500 mt-1 mb-4 leading-relaxed">Anda harus masuk menggunakan akun pelanggan terlebih dahulu.</p>
            <a href="<?= BASE_URL ?>/login" class="inline-flex items-center justify-center gap-2 bg-primary text-white font-bold text-xs px-5 py-2.5 rounded-xl hover:bg-primary-dark transition duration-300 shadow-sm w-full">
              <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk Sekarang
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Testimonials List Grid (Right/Bottom on mobile) -->
    <div class="lg:col-span-2">
      <div class="grid sm:grid-cols-2 gap-6">
        <?php if (!empty($testimonials)): ?>
          <?php foreach ($testimonials as $i => $testi): ?>
            <div class="bg-white/80 backdrop-blur-md rounded-[2rem] border border-gray-100/60 p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between"
                 data-aos="fade-up" data-aos-delay="<?= $i * 50 ?>">
              
              <!-- Review Body -->
              <div class="space-y-4">
                <!-- Stars and Quote -->
                <div class="flex justify-between items-center">
                  <div class="flex gap-0.5 text-amber-500 text-[11px]">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                      <i class="fa-<?= $s <= (int)($testi['rating'] ?? 5) ? 'solid' : 'regular' ?> fa-star"></i>
                    <?php endfor; ?>
                  </div>
                  <span class="text-cream text-3xl font-serif leading-none opacity-80"><i class="fa-solid fa-quote-right text-gray-200"></i></span>
                </div>
                
                <p class="text-sm text-gray-600 leading-relaxed font-light italic">
                  "<?= e($testi['message']) ?>"
                </p>
              </div>

              <!-- Reviewer Info -->
              <div class="flex items-center gap-3.5 mt-6 pt-5 border-t border-gray-50">
                <div class="w-10 h-10 rounded-full bg-cream flex items-center justify-center font-bold text-secondary text-sm border border-gray-100 flex-shrink-0">
                  <?= strtoupper(substr(e($testi['customer_name']), 0, 1)) ?>
                </div>
                <div>
                  <h4 class="font-bold text-gray-800 text-sm"><?= e($testi['customer_name']) ?></h4>
                  <p class="text-[10px] text-gray-400 font-light mt-0.5"><?= date('d F Y', strtotime($testi['created_at'])) ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-span-2 text-center py-12 bg-white/40 backdrop-blur-md rounded-[2.25rem] border border-dashed border-gray-200">
            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 text-3xl mx-auto mb-3">
              <i class="fa-solid fa-comment-slash"></i>
            </div>
            <p class="text-sm font-semibold text-gray-400">Belum ada testimoni.</p>
            <p class="text-xs text-gray-400 mt-1 font-light">Jadilah yang pertama menuliskan ulasan tentang kami!</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
