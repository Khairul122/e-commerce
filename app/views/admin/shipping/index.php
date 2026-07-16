<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>

<div class="grid md:grid-cols-3 gap-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
    <h2 class="font-bold text-primary mb-4">Tambah Metode</h2>
    <form method="POST" action="<?= BASE_URL ?>/admin/pengiriman/tambah" class="space-y-3">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <input type="text" name="name" required placeholder="Nama metode" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <input type="text" name="description" placeholder="Deskripsi" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <input type="number" name="cost" step="0.01" min="0" placeholder="Biaya (Rp)" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <button type="submit" class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg w-full">Tambah</button>
    </form>
  </div>

  <div class="md:col-span-2 bg-white rounded-2xl shadow-sm overflow-x-auto h-fit">
    <table class="w-full text-sm">
      <thead class="bg-cream text-left">
        <tr><th class="px-4 py-3">Nama</th><th class="px-4 py-3">Biaya</th><th class="px-4 py-3">Aktif</th><th class="px-4 py-3">Aksi</th></tr>
      </thead>
      <tbody class="divide-y">
        <?php foreach ($methods as $m): ?>
          <tr>
            <td class="px-4 py-3">
              <p class="font-medium"><?= e($m['name']) ?></p>
              <p class="text-xs text-gray-500"><?= e($m['description']) ?></p>
            </td>
            <td class="px-4 py-3"><?= $m['cost'] > 0 ? rupiah($m['cost']) : 'Gratis' ?></td>
            <td class="px-4 py-3">
              <form method="POST" action="<?= BASE_URL ?>/admin/pengiriman/<?= $m['id'] ?>/edit">
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <input type="hidden" name="name" value="<?= e($m['name']) ?>">
                <input type="hidden" name="description" value="<?= e($m['description']) ?>">
                <input type="hidden" name="cost" value="<?= e($m['cost']) ?>">
                <input type="checkbox" name="is_active" value="1" onchange="this.form.submit()" <?= $m['is_active'] ? 'checked' : '' ?> class="rounded text-primary">
              </form>
            </td>
            <td class="px-4 py-3">
              <form method="POST" action="<?= BASE_URL ?>/admin/pengiriman/<?= $m['id'] ?>/hapus" data-confirm="Hapus metode pengiriman ini?">
                <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
