<?php
/** Partial kartu produk. Butuh $product dalam scope. */
$__stockLabel = $product['stock'] > 0 ? ($product['stock'] <= 5 ? "Stok Tipis ({$product['stock']})" : "Stok: {$product['stock']}") : 'Stok Habis';
$__stockClass = $product['stock'] > 0 ? ($product['stock'] <= 5 ? 'text-amber-600 bg-amber-50 border-amber-200' : 'text-green-600 bg-green-50 border-green-100') : 'text-red-500 bg-red-50 border-red-100';
?>
<a href="<?= BASE_URL ?>/produk/<?= e($product['slug']) ?>"
   class="group bg-white rounded-2xl shadow-md shadow-gray-100 hover:shadow-2xl hover:shadow-primary/5 hover:-translate-y-1.5 transition-all duration-500 overflow-hidden block border border-gray-100">
  <div class="aspect-square overflow-hidden bg-cream relative">
    <img src="<?= uploadUrl('products', $product['image'] ?? null) ?>" alt="<?= e($product['name']) ?>"
         class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700" loading="lazy">
    
    <!-- Image Overlay when out of stock -->
    <?php if ($product['stock'] <= 0): ?>
      <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center">
        <span class="px-4 py-1.5 rounded-full bg-red-600 text-white font-bold text-xs uppercase tracking-wider shadow">Habis</span>
      </div>
    <?php endif; ?>
  </div>
  
  <div class="p-4 flex flex-col justify-between h-[115px]">
    <div>
      <h3 class="font-bold text-gray-800 truncate group-hover:text-primary transition-colors duration-300 text-sm md:text-base leading-snug"><?= e($product['name']) ?></h3>
      <?php if (!empty($product['category_name'])): ?>
        <span class="text-[10px] text-gray-400 font-medium tracking-wide block mt-0.5"><?= e($product['category_name']) ?></span>
      <?php endif; ?>
    </div>
    
    <div class="flex justify-between items-end">
      <div class="space-y-1">
        <p class="text-secondary font-extrabold text-sm md:text-base font-outfit leading-none"><?= rupiah($product['price']) ?></p>
        <span class="inline-block text-[9px] px-2 py-0.5 rounded-full border font-bold uppercase tracking-wider <?= $__stockClass ?>">
          <?= e($__stockLabel) ?>
        </span>
      </div>
      <div class="w-8 h-8 rounded-xl bg-cream flex items-center justify-center text-primary group-hover:bg-gradient-to-tr group-hover:from-primary group-hover:to-secondary group-hover:text-white group-hover:rotate-45 transition-all duration-500 shadow-sm border border-gray-100">
        <i class="fa-solid fa-chevron-right text-xs"></i>
      </div>
    </div>
  </div>
</a>
