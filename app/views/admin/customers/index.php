<?php include APP_PATH . '/views/layouts/admin_header.php'; ?>

<!-- Flash Message Notifications -->
<?php if (!empty($flash['success'])): ?>
  <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-2xl p-4 mb-6 flex items-center gap-3">
    <i class="fa-solid fa-circle-check text-green-500 text-lg"></i>
    <span><?= e($flash['success']) ?></span>
  </div>
<?php endif; ?>
<?php if (!empty($flash['error'])): ?>
  <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-2xl p-4 mb-6 flex items-center gap-3">
    <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
    <span><?= e($flash['error']) ?></span>
  </div>
<?php endif; ?>

<!-- Summary Statistic Cards -->
<?php
$totalCustomers = count($customers);
$totalOrdersAll = 0;
$totalSpentAll = 0;
foreach ($customers as $c) {
    $totalOrdersAll += (int)$c['total_orders'];
    $totalSpentAll += (float)$c['total_spent'];
}
?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/40">
    <div class="flex items-center justify-between mb-2">
      <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Pelanggan</p>
      <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
        <i class="fa-solid fa-users"></i>
      </div>
    </div>
    <p class="text-3xl font-extrabold text-primary font-outfit"><?= $totalCustomers ?> <span class="text-xs text-gray-400 font-normal">akun</span></p>
  </div>
  
  <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/40">
    <div class="flex items-center justify-between mb-2">
      <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Belanja Realisasi</p>
      <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
        <i class="fa-solid fa-wallet"></i>
      </div>
    </div>
    <p class="text-3xl font-extrabold text-secondary font-outfit"><?= rupiah($totalSpentAll) ?></p>
  </div>

  <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/40">
    <div class="flex items-center justify-between mb-2">
      <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Akumulasi Pesanan</p>
      <div class="w-8 h-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-600">
        <i class="fa-solid fa-shopping-bag"></i>
      </div>
    </div>
    <p class="text-3xl font-extrabold text-green-600 font-outfit"><?= $totalOrdersAll ?> <span class="text-xs text-gray-400 font-normal">pesanan</span></p>
  </div>
</div>

<!-- Header Actions & Search -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100/40">
  <div class="flex flex-wrap items-center justify-between gap-4">
    <form method="GET" action="<?= BASE_URL ?>/admin/pembeli" class="flex items-center gap-2 flex-grow max-w-md">
      <div class="relative w-full">
        <input type="text" name="search" value="<?= e($search) ?>" placeholder="Cari nama, email, atau telepon..." class="w-full rounded-xl border-gray-200 pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
        <div class="absolute left-3.5 top-2.5 text-gray-400">
          <i class="fa-solid fa-magnifying-glass text-sm"></i>
        </div>
      </div>
      <button type="submit" class="bg-primary text-white px-4 py-2 rounded-xl text-sm font-semibold hover:brightness-105 active:scale-98 transition duration-200">
        Cari
      </button>
      <?php if (!empty($search)): ?>
        <a href="<?= BASE_URL ?>/admin/pembeli" class="text-xs text-gray-400 hover:text-gray-600 underline whitespace-nowrap">Reset</a>
      <?php endif; ?>
    </form>
    
    <button onclick="openAddModal()" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:brightness-105 active:scale-98 transition duration-200 flex items-center gap-2">
      <i class="fa-solid fa-plus text-xs"></i> Tambah Pembeli Baru
    </button>
  </div>
</div>

<!-- Customer List Table -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100/40">
  <div class="p-5 bg-cream border-b border-gray-100 flex items-center justify-between">
    <h3 class="font-bold text-primary font-outfit">Daftar Pembeli / Customer</h3>
    <span class="text-xs text-gray-400 font-light">*Total belanja hanya menghitung transaksi dengan status 'Selesai'</span>
  </div>
  
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-cream/35 text-left text-primary font-bold">
        <tr>
          <th class="px-6 py-4">Nama Pembeli</th>
          <th class="px-6 py-4">Kontak</th>
          <th class="px-6 py-4">Alamat Utama</th>
          <th class="px-6 py-4 text-center">Akumulasi Belanja</th>
          <th class="px-6 py-4">Tanggal Daftar</th>
          <th class="px-6 py-4 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php foreach ($customers as $c): ?>
          <tr class="hover:bg-cream/15 transition duration-150">
            <!-- Nama -->
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 text-primary font-extrabold flex items-center justify-center font-outfit uppercase">
                  <?= substr($c['name'], 0, 2) ?>
                </div>
                <div>
                  <p class="font-bold text-gray-800"><?= e($c['name']) ?></p>
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-cream text-primary uppercase">Customer</span>
                </div>
              </div>
            </td>
            <!-- Kontak -->
            <td class="px-6 py-4">
              <p class="text-gray-700 font-medium text-xs flex items-center gap-1.5 mb-0.5">
                <i class="fa-solid fa-envelope text-gray-400 text-[10px]"></i> <?= e($c['email']) ?>
              </p>
              <p class="text-gray-500 font-light text-xs flex items-center gap-1.5">
                <i class="fa-solid fa-phone text-gray-400 text-[10px]"></i> <?= e($c['phone'] ?: '-') ?>
              </p>
            </td>
            <!-- Alamat -->
            <td class="px-6 py-4">
              <p class="text-gray-600 font-light text-xs max-w-xs truncate" title="<?= e($c['address']) ?>">
                <?= e($c['address'] ?: '-') ?>
              </p>
            </td>
            <!-- Belanja -->
            <td class="px-6 py-4 text-center">
              <div class="inline-block text-left">
                <span class="block text-xs font-bold text-secondary"><?= rupiah($c['total_spent']) ?></span>
                <span class="block text-[10px] text-gray-400 text-center font-semibold"><?= $c['total_orders'] ?>x transaksi</span>
              </div>
            </td>
            <!-- Daftar -->
            <td class="px-6 py-4">
              <p class="text-gray-500 font-light text-xs"><?= date('d M Y H:i', strtotime($c['created_at'])) ?></p>
            </td>
            <!-- Aksi -->
            <td class="px-6 py-4">
              <div class="flex items-center justify-center gap-2">
                <button onclick="openEditModal(<?= htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8') ?>)" class="text-primary hover:text-orange-600 px-2 py-1 rounded hover:bg-primary/5 transition text-xs font-semibold flex items-center gap-1">
                  <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
                <form method="POST" action="<?= BASE_URL ?>/admin/pembeli/<?= $c['id'] ?>/hapus" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pembeli ini? Seluruh riwayat transaksi terkait juga akan dihapus secara permanen.')">
                  <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
                  <button type="submit" class="text-red-500 hover:text-red-700 px-2 py-1 rounded hover:bg-red-50 transition text-xs font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-trash-can"></i> Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($customers)): ?>
          <tr>
            <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-light">
              <i class="fa-solid fa-user-slash text-3xl mb-2 text-gray-200 block"></i>
              Tidak ada data pembeli ditemukan.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL ADD USER -->
<div id="addModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition duration-300">
    <div class="p-5 bg-cream border-b border-gray-100 flex items-center justify-between">
      <h3 class="font-bold text-primary font-outfit flex items-center gap-2">
        <i class="fa-solid fa-user-plus text-sm"></i> Tambah Pembeli Baru
      </h3>
      <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>
    <form method="POST" action="<?= BASE_URL ?>/admin/pembeli/tambah" class="p-6 space-y-4">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap *</label>
        <input type="text" name="name" required class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email *</label>
        <input type="email" name="email" required class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Password Baru *</label>
        <input type="password" name="password" required class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Telepon / WA</label>
        <input type="text" name="phone" class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Lengkap</label>
        <textarea name="address" rows="3" class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition"></textarea>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="closeAddModal()" class="w-1/2 border border-gray-200 text-gray-500 font-semibold px-4 py-2.5 rounded-xl text-sm hover:bg-gray-50 transition">
          Batal
        </button>
        <button type="submit" class="w-1/2 bg-primary text-white font-semibold px-4 py-2.5 rounded-xl text-sm hover:brightness-105 transition">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL EDIT USER -->
<div id="editModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition duration-300">
    <div class="p-5 bg-cream border-b border-gray-100 flex items-center justify-between">
      <h3 class="font-bold text-primary font-outfit flex items-center gap-2">
        <i class="fa-solid fa-user-pen text-sm"></i> Edit Data Pembeli
      </h3>
      <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
    </div>
    <form id="editForm" method="POST" action="" class="p-6 space-y-4">
      <input type="hidden" name="csrf_token" value="<?= e($csrf) ?>">
      <input type="hidden" name="id" id="edit_id">
      
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap *</label>
        <input type="text" name="name" id="edit_name" required class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email *</label>
        <input type="email" name="email" id="edit_email" required class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <div class="flex justify-between items-center mb-1">
          <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Ganti Password</label>
          <span class="text-[10px] text-gray-400 font-light">*Kosongkan jika tidak diganti</span>
        </div>
        <input type="password" name="password" id="edit_password" placeholder="Password baru" class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No. Telepon / WA</label>
        <input type="text" name="phone" id="edit_phone" class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Lengkap</label>
        <textarea name="address" id="edit_address" rows="3" class="w-full rounded-xl border-gray-200 px-4 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition"></textarea>
      </div>

      <div class="flex gap-3 pt-2">
        <button type="button" onclick="closeEditModal()" class="w-1/2 border border-gray-200 text-gray-500 font-semibold px-4 py-2.5 rounded-xl text-sm hover:bg-gray-50 transition">
          Batal
        </button>
        <button type="submit" class="w-1/2 bg-primary text-white font-semibold px-4 py-2.5 rounded-xl text-sm hover:brightness-105 transition">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.getElementById('addModal').classList.add('flex');
  }
  
  function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addModal').classList.remove('flex');
  }
  
  function openEditModal(customer) {
    document.getElementById('edit_id').value = customer.id;
    document.getElementById('edit_name').value = customer.name;
    document.getElementById('edit_email').value = customer.email;
    document.getElementById('edit_phone').value = customer.phone || '';
    document.getElementById('edit_address').value = customer.address || '';
    document.getElementById('edit_password').value = ''; // clear password input
    
    const form = document.getElementById('editForm');
    form.action = '<?= BASE_URL ?>/admin/pembeli/' + customer.id + '/edit';
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
  }
  
  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
  }
</script>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
