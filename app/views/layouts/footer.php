<?php
use App\Models\Setting;
$__settings = $__settings ?? (new Setting())->get();
?>
<footer class="relative bg-gradient-to-br from-primary via-primary to-primary-dark text-cream mt-24 overflow-hidden">
  <!-- Decorative top border line -->
  <div class="h-1.5 w-full bg-gradient-to-r from-secondary via-primary-dark to-secondary"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10 grid grid-cols-1 md:grid-cols-4 gap-10">
    <div class="space-y-4">
      <h3 class="text-2xl font-extrabold font-outfit tracking-wide flex items-center gap-2 text-white">
        <img src="<?= BASE_URL ?>/assets/images/logo.svg" alt="UKM ARC Logo" class="w-8 h-8">
        UKM ARC
      </h3>
      <p class="text-sm text-cream/70 leading-relaxed font-light"><?= e($__settings['about_text'] ?? '') ?></p>
      
      <!-- Social Media Icons -->
      <div class="flex items-center gap-3 pt-2">
        <a href="https://wa.me/<?= e($__settings['whatsapp'] ?? '') ?>" target="_blank" class="w-9 h-9 rounded-full bg-white/10 hover:bg-secondary hover:scale-110 flex items-center justify-center text-cream transition-all duration-300">
          <i class="fa-brands fa-whatsapp text-lg"></i>
        </a>
        <a href="mailto:<?= e($__settings['email'] ?? '') ?>" class="w-9 h-9 rounded-full bg-white/10 hover:bg-secondary hover:scale-110 flex items-center justify-center text-cream transition-all duration-300">
          <i class="fa-solid fa-envelope text-base"></i>
        </a>
      </div>
    </div>
    
    <div>
      <h4 class="text-white font-bold font-outfit text-lg mb-4 pb-2 border-b border-white/10">Tautan Cepat</h4>
      <ul class="space-y-3 text-sm font-medium text-cream/75">
        <li>
          <a href="<?= BASE_URL ?>/" class="inline-flex items-center gap-2 hover:text-secondary hover:translate-x-1.5 transition-all duration-300">
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i> Beranda
          </a>
        </li>
        <li>
          <a href="<?= BASE_URL ?>/produk" class="inline-flex items-center gap-2 hover:text-secondary hover:translate-x-1.5 transition-all duration-300">
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i> Katalog Produk
          </a>
        </li>
        <li>
          <a href="<?= BASE_URL ?>/register" class="inline-flex items-center gap-2 hover:text-secondary hover:translate-x-1.5 transition-all duration-300">
            <i class="fa-solid fa-chevron-right text-[10px] opacity-40"></i> Daftar Akun
          </a>
        </li>
      </ul>
    </div>
    
    <div>
      <h4 class="text-white font-bold font-outfit text-lg mb-4 pb-2 border-b border-white/10">Hubungi Kami</h4>
      <ul class="space-y-3.5 text-sm text-cream/75">
        <li class="flex items-start gap-2.5">
          <i class="fa-solid fa-location-dot text-secondary mt-1 flex-shrink-0"></i>
          <span><?= e($__settings['address'] ?? '') ?></span>
        </li>
        <li class="flex items-center gap-2.5">
          <i class="fa-solid fa-phone text-secondary flex-shrink-0"></i>
          <span><?= e($__settings['phone'] ?? '') ?></span>
        </li>
        <li class="flex items-center gap-2.5">
          <i class="fa-brands fa-whatsapp text-secondary flex-shrink-0"></i>
          <span><?= e($__settings['whatsapp'] ?? '') ?></span>
        </li>
        <li class="flex items-center gap-2.5">
          <i class="fa-solid fa-envelope text-secondary flex-shrink-0"></i>
          <span><?= e($__settings['email'] ?? '') ?></span>
        </li>
      </ul>
    </div>
    
    <div>
      <h4 class="text-white font-bold font-outfit text-lg mb-4 pb-2 border-b border-white/10">Jam Operasional</h4>
      <div class="bg-white/5 rounded-2xl p-4 border border-white/5 text-sm text-cream/75 space-y-2">
        <p class="flex justify-between">
          <span class="font-medium text-cream/60">Senin - Sabtu:</span>
          <span>08.00 - 18.00</span>
        </p>
        <p class="flex justify-between">
          <span class="font-medium text-cream/60">Minggu:</span>
          <span class="text-red-400 font-semibold">Tutup</span>
        </p>
      </div>
    </div>
  </div>
  
  <div class="border-t border-white/10 py-5 text-center text-xs text-cream/50 relative z-10 bg-black/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-2">
      <p>&copy; <?= date('Y') ?> UKM ARC. Seluruh hak cipta dilindungi.</p>
      <p class="font-light text-cream/40">Dibuat dengan cinta khas Ranah Minang</p>
    </div>
  </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>
