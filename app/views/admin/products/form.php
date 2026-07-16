<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($errors)): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4">
    <ul class="list-disc pl-4"><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm p-6 max-w-2xl">
  <form method="POST" action="<?= $product ? BASE_URL . '/admin/produk/' . $product['id'] . '/edit' : BASE_URL . '/admin/produk/tambah' ?>"
        enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">

    <div>
      <label class="block text-sm font-medium mb-1">Nama Produk</label>
      <input type="text" name="name" required value="<?= e($product['name'] ?? '') ?>"
             class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Kategori</label>
      <select name="category_id" required class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
        <option value="">Pilih kategori</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? null) == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Deskripsi</label>
      <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5"><?= e($product['description'] ?? '') ?></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
        <input type="number" name="price" step="0.01" min="0" required value="<?= e($product['price'] ?? '') ?>"
               class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Stok</label>
        <input type="number" name="stock" min="0" required value="<?= e($product['stock'] ?? '0') ?>"
               class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
      </div>
    </div>

    <?php if ($product): ?>
      <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
          <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Aktif</option>
          <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
        </select>
      </div>
    <?php endif; ?>

    <div>
      <label class="block text-sm font-medium mb-1">Gambar Produk</label>
      <?php if (!empty($product['image'])): ?>
        <img src="<?= uploadUrl('products', $product['image']) ?>" class="w-20 h-20 rounded-lg object-cover mb-2">
      <?php endif; ?>
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full text-sm">
    </div>

    <label class="flex items-center gap-2 text-sm">
      <input type="checkbox" name="is_featured" value="1" <?= !empty($product['is_featured']) ? 'checked' : '' ?> class="rounded text-primary focus:ring-primary">
      Tampilkan sebagai produk unggulan di beranda
    </label>

    <div class="flex gap-3 pt-2">
      <button type="submit" class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-primary-dark transition active:scale-95">
        Simpan
      </button>
      <a href="<?= BASE_URL ?>/admin/produk" class="text-gray-500 px-6 py-2.5">Batal</a>
    </div>
  </form>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
