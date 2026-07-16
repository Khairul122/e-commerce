<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['success']) ?></div>
<?php endif; ?>
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg p-3 mb-4"><?= e($flash['error']) ?></div>
<?php endif; ?>

<div class="grid md:grid-cols-3 gap-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 h-fit">
    <h2 class="font-bold text-primary mb-4">Tambah Testimoni</h2>
    <form method="POST" action="<?= BASE_URL ?>/admin/testimoni/tambah" class="space-y-3">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <input type="text" name="customer_name" required placeholder="Nama pelanggan" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
      <textarea name="message" required placeholder="Pesan testimoni" rows="3" class="w-full rounded-lg border-gray-300 px-4 py-2.5"></textarea>
      <select name="rating" class="w-full rounded-lg border-gray-300 px-4 py-2.5">
        <?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>"><?= $i ?> Bintang</option><?php endfor; ?>
      </select>
      <button type="submit" class="bg-primary text-white font-semibold px-6 py-2.5 rounded-lg w-full">Tambah</button>
    </form>
  </div>

  <div class="md:col-span-2 space-y-4 h-fit">
    <?php foreach ($testimonials as $t): ?>
      <div class="bg-white rounded-2xl shadow-sm p-5">
        <div class="flex justify-between items-start">
          <div>
            <p class="font-semibold"><?= e($t['customer_name']) ?></p>
            <div class="text-secondary text-sm">
              <?php for ($i = 0; $i < 5; $i++): ?><i class="fa-solid fa-star <?= $i < $t['rating'] ? '' : 'opacity-30' ?>"></i><?php endfor; ?>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <form method="POST" action="<?= BASE_URL ?>/admin/testimoni/<?= $t['id'] ?>/edit">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <label class="flex items-center gap-1 text-xs">
                <input type="checkbox" name="is_shown" value="1" onchange="this.form.submit()" <?= $t['is_shown'] ? 'checked' : '' ?> class="rounded text-primary"> Tampilkan
              </label>
            </form>
            <form method="POST" action="<?= BASE_URL ?>/admin/testimoni/<?= $t['id'] ?>/hapus" data-confirm="Hapus testimoni ini?">
              <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
              <button type="submit" class="text-red-500 text-xs hover:underline">Hapus</button>
            </form>
          </div>
        </div>
        <p class="text-sm text-gray-600 mt-2 italic">"<?= e($t['message']) ?>"</p>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
