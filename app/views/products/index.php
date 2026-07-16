<?php include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Decorative Floating Blobs -->
<div class="absolute top-40 left-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>
<div class="absolute top-[500px] right-10 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-medium z-0"></div>

<!-- Editorial header strip -->
<section class="relative z-10 bg-gradient-to-br from-primary via-primary to-primary-dark overflow-hidden -mt-0">
  <div class="absolute inset-0 grain-overlay pointer-events-none"></div>
  <div class="absolute -right-16 -top-16 w-72 h-72 bg-secondary/10 rounded-full blur-3xl"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16 relative" data-aos="fade-up">
    <span class="px-4 py-1.5 rounded-full bg-white/10 text-secondary text-xs font-bold uppercase tracking-wider border border-white/10">Koleksi Menu</span>
    <h1 class="font-display italic text-4xl md:text-6xl font-medium text-cream mt-4 leading-[0.95]">Katalog Pastry &amp; Kuliner</h1>
    <p class="text-cream/60 font-light text-sm md:text-base mt-3 max-w-md">Temukan kelezatan khas yang siap memanjakan lidah Anda setiap hari.</p>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 -mt-8 relative z-10">
  <form method="GET" action="<?= BASE_URL ?>/produk" id="catalogSearchForm" class="bg-white rounded-[1.75rem] shadow-xl shadow-gray-200/60 p-3 flex items-center gap-3 mb-10" data-aos="fade-up">
    <span class="pl-3 text-gray-400"><i class="fa-solid fa-magnifying-glass"></i></span>
    <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Cari pastry, bolu, atau masakan..."
           class="flex-1 border-0 focus:ring-0 text-sm py-2.5 bg-transparent">
    <input type="hidden" name="category" value="<?= e($selectedCategory ?? '') ?>">
    <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white font-bold px-6 py-2.5 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 text-sm flex-shrink-0">
      Cari
    </button>
  </form>

  <div class="grid lg:grid-cols-4 gap-8 items-start">

    <!-- Sidebar Filter -->
    <aside class="lg:col-span-1 space-y-5 lg:sticky lg:top-28" data-aos="fade-up" data-aos-delay="60">
      <div class="bg-white/80 backdrop-blur-sm rounded-[1.75rem] border border-white shadow-lg shadow-gray-100/50 p-6">
        <h3 class="font-bold text-primary font-outfit text-sm uppercase tracking-wider mb-4">Kategori</h3>
        <ul class="space-y-1">
          <li>
            <a href="<?= BASE_URL ?>/produk<?= !empty($search) ? '?search=' . urlencode($search) : '' ?>"
               class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 <?= empty($selectedCategory) ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-cream' ?>">
              Semua Kategori
              <?php if (empty($selectedCategory)): ?><i class="fa-solid fa-check text-xs"></i><?php endif; ?>
            </a>
          </li>
          <?php foreach ($categories as $cat): ?>
            <li>
              <a href="<?= BASE_URL ?>/produk?category=<?= $cat['id'] ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>"
                 class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 <?= ($selectedCategory ?? null) == $cat['id'] ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-cream' ?>">
                <span class="flex items-center gap-2.5"><i class="fa-solid fa-<?= e($cat['icon'] ?: 'utensils') ?> text-xs opacity-70"></i><?= e($cat['name']) ?></span>
                <?php if (($selectedCategory ?? null) == $cat['id']): ?><i class="fa-solid fa-check text-xs"></i><?php endif; ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="relative overflow-hidden rounded-[1.75rem] bg-gradient-to-br from-primary to-primary-dark p-6 text-cream">
        <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-secondary/15 rounded-full blur-2xl"></div>
        <i class="fa-brands fa-whatsapp text-2xl text-secondary relative"></i>
        <p class="font-bold text-sm mt-3 relative">Butuh pesanan khusus?</p>
        <p class="text-xs text-cream/60 font-light mt-1 relative">Chat kami langsung untuk pesanan custom dalam jumlah besar.</p>
        <a href="https://wa.me/" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-secondary mt-4 relative hover:underline">
          Hubungi Kami <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
      </div>
    </aside>

    <!-- Product Content -->
    <div class="lg:col-span-3">
      <!-- Active filter badges + sort -->
      <div class="flex flex-wrap items-center justify-between gap-3 mb-6" data-aos="fade-up">
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 font-light">
          <?php if (!empty($search) || !empty($selectedCategory)): ?>
            <span>Hasil untuk:</span>
            <?php if (!empty($search)): ?>
              <span class="px-3 py-1 rounded-full bg-cream border border-gray-200 text-primary font-semibold text-xs flex items-center gap-1.5">
                "<?= e($search) ?>"
                <a href="<?= BASE_URL ?>/produk?category=<?= e($selectedCategory ?? '') ?>" class="hover:text-red-500 font-bold"><i class="fa-solid fa-xmark"></i></a>
              </span>
            <?php endif; ?>
            <?php if (!empty($selectedCategory)):
              $activeCatName = '';
              foreach ($categories as $cat) { if ($cat['id'] == $selectedCategory) { $activeCatName = $cat['name']; break; } }
            ?>
              <span class="px-3 py-1 rounded-full bg-cream border border-gray-200 text-primary font-semibold text-xs flex items-center gap-1.5">
                <?= e($activeCatName) ?>
                <a href="<?= BASE_URL ?>/produk?search=<?= e($search ?? '') ?>" class="hover:text-red-500 font-bold"><i class="fa-solid fa-xmark"></i></a>
              </span>
            <?php endif; ?>
          <?php else: ?>
            <span><?= count($products) ?> produk tersedia</span>
          <?php endif; ?>
        </div>

        <?php if (!empty($products)): ?>
          <label class="flex items-center gap-2 text-xs font-semibold text-gray-500">
            Urutkan
            <select id="sortSelect" class="border border-gray-200 rounded-xl px-3 py-2 text-xs font-semibold text-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent">
              <option value="default">Paling Relevan</option>
              <option value="price-asc">Harga Terendah</option>
              <option value="price-desc">Harga Tertinggi</option>
              <option value="name-asc">Nama A-Z</option>
            </select>
          </label>
        <?php endif; ?>
      </div>

      <!-- Products Grid -->
      <?php if (empty($products)): ?>
        <div class="text-center py-24 bg-white/50 backdrop-blur-sm rounded-[2rem] border border-white shadow-sm" data-aos="fade-up">
          <div class="w-20 h-20 bg-cream rounded-full flex items-center justify-center text-primary text-4xl mx-auto mb-4 animate-float-medium">
            <i class="fa-solid fa-box-open"></i>
          </div>
          <h3 class="text-lg font-bold text-gray-800">Menu Tidak Ditemukan</h3>
          <p class="text-gray-400 font-light text-sm mt-1 max-w-xs mx-auto">Kami tidak dapat menemukan produk yang sesuai dengan kriteria pencarian Anda.</p>
          <a href="<?= BASE_URL ?>/produk" class="inline-block mt-5 bg-primary text-white text-xs font-bold px-6 py-2.5 rounded-full hover:bg-primary-dark transition duration-300">
            Reset Pencarian
          </a>
        </div>
      <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6" id="productGrid">
          <?php foreach ($products as $i => $product): ?>
            <div class="product-grid-item" data-price="<?= (float) $product['price'] ?>" data-name="<?= e(strtolower($product['name'])) ?>" data-aos="fade-up" data-aos-delay="<?= min($i * 40, 300) ?>">
              <?php include APP_PATH . '/views/products/_card.php'; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  document.getElementById('sortSelect')?.addEventListener('change', function () {
    const grid = document.getElementById('productGrid');
    const items = Array.from(grid.querySelectorAll('.product-grid-item'));
    const mode = this.value;

    items.sort(function (a, b) {
      if (mode === 'price-asc') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
      if (mode === 'price-desc') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
      if (mode === 'name-asc') return a.dataset.name.localeCompare(b.dataset.name);
      return 0;
    });

    if (mode === 'default') return;
    items.forEach(item => grid.appendChild(item));
  });
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
