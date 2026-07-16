<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
  <form method="GET" action="<?= BASE_URL ?>/admin/produk" class="flex gap-2">
    <input type="text" name="search" value="<?= e($search ?? '') ?>" placeholder="Cari produk..."
           class="rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2 text-sm">
    <button class="bg-gray-100 px-4 py-2 rounded-lg text-sm"><i class="fa-solid fa-search"></i></button>
  </form>
  <a href="<?= BASE_URL ?>/admin/produk/tambah" class="bg-primary text-white font-medium px-5 py-2.5 rounded-lg hover:bg-primary-dark transition text-sm">
    <i class="fa-solid fa-plus mr-1"></i> Tambah Produk
  </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="bg-cream text-left">
      <tr>
        <th class="px-4 py-3">Gambar</th>
        <th class="px-4 py-3">Nama</th>
        <th class="px-4 py-3">Kategori</th>
        <th class="px-4 py-3">Harga</th>
        <th class="px-4 py-3">Stok</th>
        <th class="px-4 py-3">Status</th>
        <th class="px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody class="divide-y">
      <?php foreach ($products as $p): ?>
        <tr>
          <td class="px-4 py-3"><img src="<?= uploadUrl('products', $p['image'] ?? null) ?>" class="w-12 h-12 rounded-lg object-cover"></td>
          <td class="px-4 py-3 font-medium"><?= e($p['name']) ?> <?= $p['is_featured'] ? '<span class="text-xs text-secondary">★ unggulan</span>' : '' ?></td>
          <td class="px-4 py-3"><?= e($p['category_name']) ?></td>
          <td class="px-4 py-3"><?= rupiah($p['price']) ?></td>
          <td class="px-4 py-3"><?= $p['stock'] ?></td>
          <td class="px-4 py-3">
            <span class="px-2 py-1 rounded-full text-xs <?= $p['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>"><?= e($p['status']) ?></span>
          </td>
          <td class="px-4 py-3 space-x-2">
            <a href="<?= BASE_URL ?>/admin/produk/<?= $p['id'] ?>/edit" class="text-blue-600 hover:underline">Edit</a>
            <form method="POST" action="<?= BASE_URL ?>/admin/produk/<?= $p['id'] ?>/hapus" class="inline" data-confirm="Hapus produk ini secara permanen?">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <button type="submit" class="text-red-500 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
