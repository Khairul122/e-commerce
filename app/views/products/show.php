<?php include APP_PATH . '/views/layouts/header.php'; ?>

<!-- Decorative Floating Blobs -->
<div class="absolute top-40 left-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none animate-float-slow z-0"></div>
<div class="absolute top-[500px] right-10 w-80 h-80 bg-secondary/5 rounded-full blur-3xl pointer-events-none animate-float-medium z-0"></div>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
  <!-- Breadcrumbs -->
  <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-400 font-medium mb-10 bg-white/40 backdrop-blur-sm py-3 px-5 rounded-2xl border border-white w-fit shadow-sm" data-aos="fade-up">
    <a href="<?= BASE_URL ?>/" class="hover:text-primary transition">Beranda</a>
    <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
    <a href="<?= BASE_URL ?>/produk" class="hover:text-primary transition">Katalog</a>
    <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
    <a href="<?= BASE_URL ?>/produk?category=<?= $product['category_id'] ?>" class="hover:text-primary transition font-semibold text-gray-500"><?= e($product['category_name']) ?></a>
    <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
    <span class="text-gray-800 font-extrabold truncate max-w-[150px] md:max-w-xs"><?= e($product['name']) ?></span>
  </nav>

  <div class="grid md:grid-cols-12 gap-10 items-start">
    <!-- Gallery Image Section -->
    <div class="md:col-span-6 space-y-4" data-aos="fade-right">
      <!-- Main Photo Frame -->
      <div class="rounded-3xl overflow-hidden shadow-xl border-4 border-white bg-white aspect-square relative">
        <img id="mainImage" src="<?= uploadUrl('products', $product['image'] ?? null) ?>" alt="<?= e($product['name']) ?>" class="w-full h-full object-cover transition-all duration-300">
        
        <?php if ($product['stock'] <= 0): ?>
          <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center">
            <span class="px-6 py-2.5 rounded-full bg-red-600 text-white font-bold text-sm uppercase tracking-wider shadow-lg">Habis</span>
          </div>
        <?php endif; ?>
      </div>

      <!-- Thumbnail Selector Grid -->
      <div class="grid grid-cols-5 gap-3">
        <!-- Main image as first thumb -->
        <img src="<?= uploadUrl('products', $product['image'] ?? null) ?>" alt="<?= e($product['name']) ?>"
             class="product-thumb rounded-2xl cursor-pointer aspect-square object-cover border-2 shadow-sm transition-all duration-300">
        <!-- Extra images -->
        <?php if (!empty($images)): ?>
          <?php foreach ($images as $img): ?>
            <img src="<?= uploadUrl('products', $img['image_path']) ?>" alt="Detail <?= e($product['name']) ?>"
                 class="product-thumb rounded-2xl cursor-pointer aspect-square object-cover border-2 shadow-sm transition-all duration-300">
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>

    <!-- Product Info Section -->
    <div class="md:col-span-6" data-aos="fade-left">
      <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] border border-white p-8 shadow-xl shadow-gray-100/50 space-y-6">
        <div>
          <span class="text-xs text-secondary font-bold uppercase tracking-widest bg-cream py-1 px-3.5 rounded-full border border-secondary/10"><?= e($product['category_name']) ?></span>
          <h1 class="text-3xl font-extrabold text-primary font-outfit mt-3.5 mb-2 leading-tight"><?= e($product['name']) ?></h1>
          
          <!-- Stars / Rating Placeholder (Decorative for Premium look) -->
          <div class="flex items-center gap-2 mt-1">
            <div class="flex gap-0.5 text-amber-400 text-xs">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
            <span class="text-xs text-gray-400 font-light">(5.0 / Terlaris)</span>
          </div>
        </div>

        <div class="border-y border-gray-100 py-4 flex items-center justify-between">
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Harga</p>
            <p class="text-3xl font-extrabold text-secondary font-outfit mt-0.5"><?= rupiah($product['price']) ?></p>
          </div>
          
          <!-- Stock Badge -->
          <div>
            <?php
            $__stockLabel = $product['stock'] > 0 ? ($product['stock'] <= 5 ? "Stok Tipis ({$product['stock']})" : "Stok: {$product['stock']} pcs") : 'Stok Habis';
            $__stockClass = $product['stock'] > 0 ? ($product['stock'] <= 5 ? 'text-amber-600 bg-amber-50 border-amber-200' : 'text-green-600 bg-green-50 border-green-100') : 'text-red-500 bg-red-50 border-red-100';
            ?>
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border text-xs font-bold uppercase tracking-wider <?= $__stockClass ?>">
              <span class="w-1.5 h-1.5 rounded-full <?= $product['stock'] > 0 ? ($product['stock'] <= 5 ? 'bg-amber-500 animate-pulse' : 'bg-green-500') : 'bg-red-500' ?>"></span>
              <?= e($__stockLabel) ?>
            </span>
          </div>
        </div>

        <div class="space-y-2">
          <h4 class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Deskripsi Menu</h4>
          <p class="text-gray-600 leading-relaxed text-sm font-light whitespace-pre-line"><?= nl2br(e($product['description'] ?? '')) ?></p>
        </div>

        <!-- Add To Cart Form -->
        <div class="pt-4 border-t border-gray-100">
          <?php if ($product['stock'] > 0): ?>
            <form id="addToCartForm" method="POST" action="<?= BASE_URL ?>/cart/add" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
              
              <!-- Quantity Controls wrapper matching app.js -->
              <div class="qty-group flex items-center justify-between sm:justify-start gap-3 bg-cream/70 border border-gray-200/80 rounded-2xl px-2 py-1 flex-shrink-0">
                <button type="button" class="qty-minus w-10 h-10 rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition duration-300 font-bold text-base select-none">-</button>
                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" readonly
                       class="qty-input w-12 bg-transparent text-center border-0 focus:ring-0 text-sm font-bold text-gray-800 pointer-events-none">
                <button type="button" class="qty-plus w-10 h-10 rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition duration-300 font-bold text-base select-none">+</button>
              </div>

              <!-- Submit Button -->
              <button type="submit" class="flex-1 bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 px-6 rounded-2xl hover:brightness-105 active:scale-98 transition duration-300 shadow-lg shadow-primary/10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-cart-plus text-sm"></i> Tambah ke Keranjang
              </button>
            </form>
          <?php else: ?>
            <button disabled class="w-full bg-gray-200 text-gray-400 font-bold py-3.5 rounded-2xl cursor-not-allowed border border-gray-300/50 flex items-center justify-center gap-2">
              <i class="fa-solid fa-ban"></i> Stok Habis
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Related Products -->
  <?php if (!empty($related)): ?>
    <div class="mt-24 border-t border-gray-200/50 pt-16">
      <div class="text-center md:text-left mb-10" data-aos="fade-up">
        <span class="px-4 py-1.5 rounded-full bg-cream text-primary text-xs font-bold uppercase tracking-wider">Mungkin Anda Suka</span>
        <h2 class="text-2xl md:text-3xl font-extrabold text-primary font-outfit mt-3 mb-2">Produk Serupa</h2>
        <p class="text-gray-400 font-light text-xs md:text-sm">Cobalah varian hidangan penutup dan makanan pendamping lezat lainnya.</p>
      </div>
      
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <?php foreach ($related as $rProduct): ?>
          <div data-aos="fade-up">
            <!-- Ensure child mapping works properly -->
            <?php 
              $product = $rProduct;
              include APP_PATH . '/views/products/_card.php'; 
            ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
