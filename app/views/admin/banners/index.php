<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['error']) ?></div>
<?php endif; ?>

<div class="grid md:grid-cols-3 gap-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
    <h2 class="font-bold text-primary mb-4">Tambah Banner</h2>
    <form method="POST" action="<?= BASE_URL ?>/admin/banner/tambah" enctype="multipart/form-data" class="space-y-3">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <input type="text" name="title" placeholder="Judul banner" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <input type="text" name="link" placeholder="Link (opsional)" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <input type="number" name="sort_order" placeholder="Urutan" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required class="w-full text-sm">
      <button type="submit" class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg w-full">Tambah</button>
    </form>
  </div>

  <div class="md:col-span-2 grid sm:grid-cols-2 gap-4 h-fit">
    <?php foreach ($banners as $b): ?>
      <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <img src="<?= uploadUrl('banners', $b['image']) ?>" class="w-full h-32 object-cover">
        <div class="p-4">
          <p class="font-medium truncate"><?= e($b['title'] ?: '(tanpa judul)') ?></p>
          <div class="flex items-center justify-between mt-3">
            <form method="POST" action="<?= BASE_URL ?>/admin/banner/<?= $b['id'] ?>/edit">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <label class="flex items-center gap-1 text-xs">
                <input type="checkbox" name="is_active" value="1" onchange="this.form.submit()" <?= $b['is_active'] ? 'checked' : '' ?> class="rounded text-primary"> Aktif
              </label>
            </form>
            <form method="POST" action="<?= BASE_URL ?>/admin/banner/<?= $b['id'] ?>/hapus" data-confirm="Hapus banner ini?">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
