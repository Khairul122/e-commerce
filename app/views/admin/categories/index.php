<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['error']) ?></div>
<?php endif; ?>

<div class="grid md:grid-cols-3 gap-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
    <h2 class="font-bold text-primary mb-4">Tambah Kategori</h2>
    <form method="POST" action="<?= BASE_URL ?>/admin/kategori/tambah" class="space-y-3">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <div>
        <label class="block text-sm font-medium mb-1">Nama Kategori</label>
        <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Ikon (Font Awesome, tanpa "fa-")</label>
        <input type="text" name="icon" placeholder="contoh: cake" class="w-full rounded-lg border-gray-300 focus:ring-primary focus:border-primary px-4 py-2.5">
      </div>
      <button type="submit" class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-primary-dark transition w-full">Tambah</button>
    </form>
  </div>

  <div class="md:col-span-2 bg-white rounded-2xl shadow-sm overflow-x-auto h-fit">
    <table class="w-full text-sm">
      <thead class="bg-cream text-left">
        <tr><th class="px-4 py-3">Ikon</th><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Slug</th><th class="px-4 py-3">Aksi</th></tr>
      </thead>
      <tbody class="divide-y">
        <?php foreach ($categories as $cat): ?>
          <tr>
            <td class="px-4 py-3"><i class="fa-solid fa-<?= e($cat['icon'] ?: 'utensils') ?> text-primary"></i></td>
            <td class="px-4 py-3 font-medium"><?= e($cat['name']) ?></td>
            <td class="px-4 py-3 text-gray-500"><?= e($cat['slug']) ?></td>
            <td class="px-4 py-3 space-x-2">
              <button type="button" onclick="document.getElementById('edit-<?= $cat['id'] ?>').classList.toggle('hidden')" class="text-blue-600 hover:underline">Edit</button>
              <form method="POST" action="<?= BASE_URL ?>/admin/kategori/<?= $cat['id'] ?>/hapus" class="inline" data-confirm="Hapus kategori ini? Produk terkait juga akan terhapus.">
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
              </form>
            </td>
          </tr>
          <tr id="edit-<?= $cat['id'] ?>" class="hidden bg-cream/50">
            <td colspan="4" class="px-4 py-3">
              <form method="POST" action="<?= BASE_URL ?>/admin/kategori/<?= $cat['id'] ?>/edit" class="flex gap-2 items-center">
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <input type="text" name="name" value="<?= e($cat['name']) ?>" required class="rounded-lg border-gray-300 px-3 py-1.5 text-sm">
                <input type="text" name="icon" value="<?= e($cat['icon']) ?>" placeholder="ikon" class="rounded-lg border-gray-300 px-3 py-1.5 text-sm w-28">
                <button type="submit" class="bg-primary text-white text-xs px-4 py-1.5 rounded-lg">Simpan</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
