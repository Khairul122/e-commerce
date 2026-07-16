<?php
$statusColors = [
    'pending' => 'bg-yellow-100 text-yellow-700',
    'diproses' => 'bg-blue-100 text-blue-700',
    'dikirim' => 'bg-purple-100 text-purple-700',
    'selesai' => 'bg-green-100 text-green-700',
    'dibatalkan' => 'bg-red-100 text-red-700',
];

if (!function_exists('format_bulan_indo')) {
    function format_bulan_indo($monthStr) {
        $bulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $split = explode('-', $monthStr);
        if (count($split) === 2 && isset($bulan[$split[1]])) {
            return $bulan[$split[1]] . ' ' . $split[0];
        }
        return $monthStr;
    }
}

if (!function_exists('tanggal_indonesia')) {
    function tanggal_indonesia($date) {
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $split = explode('-', date('Y-m-d', strtotime($date)));
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
}

$showTtd = ($_GET['show_ttd'] ?? '1') === '1';
$ttdCity = $_GET['ttd_city'] ?? 'Padang';
$ttdTitle = $_GET['ttd_title'] ?? 'Pimpinan Dapoer ARC';
$ttdName = $_GET['ttd_name'] ?? 'Owner Dapoer ARC';

include APP_PATH . '/views/layouts/admin_header.php';
?>

<!-- Filter Form Card -->
<form method="GET" action="<?= BASE_URL ?>/admin/laporan" class="flex flex-wrap items-end gap-4 mb-6 bg-white rounded-2xl shadow-sm p-6">
  <div>
    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Tipe Laporan</label>
    <select name="type" id="filterType" class="rounded-xl border-gray-200 px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-primary focus:border-transparent transition">
      <option value="custom" <?= $filterType === 'custom' ? 'selected' : '' ?>>Rentang Tanggal</option>
      <option value="daily" <?= $filterType === 'daily' ? 'selected' : '' ?>>Laporan Harian</option>
      <option value="monthly" <?= $filterType === 'monthly' ? 'selected' : '' ?>>Laporan Bulanan</option>
      <option value="yearly" <?= $filterType === 'yearly' ? 'selected' : '' ?>>Laporan Tahunan</option>
    </select>
  </div>

  <!-- Custom Date Inputs -->
  <div id="customGroup" class="filter-group flex gap-3">
    <div>
      <label class="block text-xs text-gray-500 mb-1">Dari Tanggal</label>
      <input type="date" name="from" value="<?= e($from) ?>" class="rounded-xl border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
    </div>
    <div>
      <label class="block text-xs text-gray-500 mb-1">Sampai Tanggal</label>
      <input type="date" name="to" value="<?= e($to) ?>" class="rounded-xl border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
    </div>
  </div>

  <!-- Daily Input -->
  <div id="dailyGroup" class="filter-group hidden">
    <label class="block text-xs text-gray-500 mb-1">Pilih Tanggal</label>
    <input type="date" name="daily_date" value="<?= e($dailyDate) ?>" class="rounded-xl border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
  </div>

  <!-- Monthly Input -->
  <div id="monthlyGroup" class="filter-group hidden">
    <label class="block text-xs text-gray-500 mb-1">Pilih Bulan</label>
    <input type="month" name="monthly_month" value="<?= e($monthlyMonth) ?>" class="rounded-xl border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
  </div>

  <!-- Yearly Input -->
  <div id="yearlyGroup" class="filter-group hidden">
    <label class="block text-xs text-gray-500 mb-1">Pilih Tahun</label>
    <select name="yearly_year" class="rounded-xl border-gray-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-transparent transition">
      <?php for ($y = (int)date('Y'); $y >= 2020; $y--): ?>
        <option value="<?= $y ?>" <?= (int)$yearlyYear === $y ? 'selected' : '' ?>><?= $y ?></option>
      <?php endfor; ?>
    </select>
  </div>

  <div class="flex gap-2 ml-auto">
    <button type="submit" onclick="this.form.action='<?= BASE_URL ?>/admin/laporan'; this.form.target='_self';" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:brightness-105 active:scale-98 transition duration-200 flex items-center gap-1.5">
      <i class="fa-solid fa-filter"></i> Filter
    </button>
    <button type="submit" onclick="this.form.action='<?= BASE_URL ?>/admin/laporan/csv'; this.form.target='_self';" class="bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:brightness-105 active:scale-98 transition duration-200 flex items-center gap-1.5">
      <i class="fa-solid fa-file-excel"></i> Excel / CSV
    </button>
    <button type="submit" onclick="this.form.action='<?= BASE_URL ?>/admin/laporan/print'; this.form.target='_blank';" class="bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 active:scale-98 transition duration-200 flex items-center gap-1.5">
      <i class="fa-solid fa-file-pdf"></i> Unduh PDF
    </button>
  </div>

  <!-- TTD Configuration Accordion -->
  <div class="w-full mt-4 pt-4 border-t border-gray-100">
    <button type="button" onclick="document.getElementById('ttdConfig').classList.toggle('hidden')" class="text-xs font-bold text-primary hover:brightness-95 flex items-center gap-1">
      <i class="fa-solid fa-pen-nib"></i> PENGATURAN TANDA TANGAN LAPORAN (TTD) <i class="fa-solid fa-chevron-down text-[10px]"></i>
    </button>
    
    <div id="ttdConfig" class="hidden mt-3 grid grid-cols-1 md:grid-cols-4 gap-4 bg-cream/10 p-4 rounded-xl border border-cream/20">
      <div class="flex items-center gap-2">
        <input type="checkbox" name="show_ttd" id="show_ttd" value="1" <?= $showTtd ? 'checked' : '' ?> class="rounded text-primary focus:ring-primary">
        <label for="show_ttd" class="text-xs font-bold text-gray-600">Tampilkan Tanda Tangan</label>
      </div>
      <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Kota Penandatangan</label>
        <input type="text" name="ttd_city" value="<?= e($ttdCity) ?>" class="w-full rounded-xl border-gray-200 px-3 py-1.5 text-xs focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Jabatan (Baris 1)</label>
        <input type="text" name="ttd_title" value="<?= e($ttdTitle) ?>" class="w-full rounded-xl border-gray-200 px-3 py-1.5 text-xs focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
      <div>
        <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Nama (Baris 2)</label>
        <input type="text" name="ttd_name" value="<?= e($ttdName) ?>" class="w-full rounded-xl border-gray-200 px-3 py-1.5 text-xs focus:ring-2 focus:ring-primary focus:border-transparent transition">
      </div>
    </div>
  </div>
</form>

<!-- Stats Grid -->
<div class="grid grid-cols-2 gap-6 mb-6">
  <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/40">
    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Transaksi</p>
    <p class="text-3xl font-extrabold text-primary font-outfit"><?= $totalOrders ?> <span class="text-xs text-gray-400 font-normal">pesanan</span></p>
  </div>
  <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100/40">
    <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Total Pendapatan (Selesai)</p>
    <p class="text-3xl font-extrabold text-secondary font-outfit"><?= rupiah($totalRevenue) ?></p>
  </div>
</div>

<!-- Chart Card -->
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100/40">
  <h2 class="font-bold text-primary text-lg font-outfit mb-4">Grafik Penjualan</h2>
  <canvas id="trendChart" height="90"></canvas>
</div>

<!-- Data Table Card -->
<?php if ($filterType === 'yearly'): ?>
  <!-- Tabel Penjualan Produk Mingguan Khusus Laporan Tahunan -->
  <?php
    $db = \App\Core\Database::getInstance();
    $sql = "SELECT p.name AS product_name, oi.quantity, o.created_at
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN products p ON oi.product_id = p.id
            WHERE o.status = 'selesai'
              AND o.created_at BETWEEN ? AND ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$from . ' 00:00:00', $to . ' 23:59:59']);
    $items = $stmt->fetchAll();

    $allProducts = (new \App\Models\Product())->all('name ASC');
    $matrix = [];
    foreach ($allProducts as $p) {
        $matrix[$p['name']] = [];
        for ($m = 1; $m <= 12; $m++) {
            $matrix[$p['name']][$m] = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
        }
    }
    foreach ($items as $item) {
        $dt = strtotime($item['created_at']);
        $month = (int)date('m', $dt);
        $day = (int)date('d', $dt);
        $week = min(4, (int)ceil($day / 7));
        $prodName = $item['product_name'];
        if (isset($matrix[$prodName])) {
            $matrix[$prodName][$month][$week] += (int)$item['quantity'];
        }
    }

    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
  ?>
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100/40">
    <div class="p-5 bg-cream border-b border-gray-100 flex flex-wrap justify-between items-center gap-2">
      <h3 class="font-bold text-primary font-outfit">Volume Pembelian Produk per Minggu (Tahun <?= e($yearlyYear) ?>)</h3>
      <span class="text-[10px] text-gray-400 font-light">*Kolom 1 s/d 4 mewakili Minggu ke-1 s/d ke-4 dari setiap bulan</span>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-xs min-w-[1200px]">
        <thead class="bg-cream/35 text-center text-primary font-bold border-b border-gray-100">
          <tr>
            <th rowspan="2" class="px-4 py-3 text-left min-w-[200px] border-r border-gray-100">Nama Produk</th>
            <?php foreach ($bulanIndo as $m => $name): ?>
              <th colspan="4" class="py-2 border-r border-gray-100 text-center font-bold text-xs uppercase bg-cream/10"><?= $name ?></th>
            <?php endforeach; ?>
            <th rowspan="2" class="px-4 py-3 text-center min-w-[100px] bg-cream/20">Total</th>
          </tr>
          <tr class="border-b border-gray-100 text-[10px] text-gray-500">
            <?php for ($m = 1; $m <= 12; $m++): ?>
              <th class="py-1 border-r border-gray-100 text-center">1</th>
              <th class="py-1 border-r border-gray-100 text-center">2</th>
              <th class="py-1 border-r border-gray-100 text-center">3</th>
              <th class="py-1 border-r border-gray-100 text-center">4</th>
            <?php endfor; ?>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-center">
          <?php foreach ($matrix as $prodName => $months): ?>
            <?php 
              $rowTotal = 0;
              for ($m = 1; $m <= 12; $m++) {
                  $rowTotal += array_sum($months[$m]);
              }
            ?>
            <tr class="hover:bg-cream/15 transition duration-150">
              <td class="px-4 py-3 font-bold text-gray-800 text-left border-r border-gray-100"><?= e($prodName) ?></td>
              <?php for ($m = 1; $m <= 12; $m++): ?>
                <?php for ($w = 1; $w <= 4; $w++): ?>
                  <?php $val = $months[$m][$w]; ?>
                  <td class="py-3 border-r border-gray-100 font-semibold <?= $val > 0 ? 'text-primary font-bold' : 'text-gray-300' ?>">
                    <?= $val ?: '-' ?>
                  </td>
                <?php endfor; ?>
              <?php endfor; ?>
              <td class="px-4 py-3 font-extrabold text-secondary bg-cream/5"><?= $rowTotal ?: '-' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
<?php else: ?>
  <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100/40">
    <div class="p-5 bg-cream border-b border-gray-100">
      <h3 class="font-bold text-primary font-outfit">
        Daftar Pemesanan (Periode: <?= $filterType === 'monthly' ? format_bulan_indo($monthlyMonth) : ($filterType === 'daily' ? tanggal_indonesia($dailyDate) : tanggal_indonesia($from) . ' s/d ' . tanggal_indonesia($to)) ?>)
      </h3>
    </div>
    <table class="w-full text-sm">
      <thead class="bg-cream/35 text-left text-primary font-bold">
        <tr>
          <th class="px-5 py-3.5">Kode Pesanan</th>
          <th class="px-5 py-3.5">Tanggal</th>
          <th class="px-5 py-3.5">Pelanggan</th>
          <th class="px-5 py-3.5">Total Belanja</th>
          <th class="px-5 py-3.5">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php foreach ($orders as $o): ?>
          <tr class="hover:bg-cream/15 transition duration-150">
            <td class="px-5 py-4 font-bold text-gray-800"><?= e($o['order_code']) ?></td>
            <td class="px-5 py-4 text-gray-500 font-light"><?= date('d M Y H:i', strtotime($o['created_at'])) ?></td>
            <td class="px-5 py-4 font-semibold text-gray-700"><?= e($o['customer_name']) ?></td>
            <td class="px-5 py-4 font-bold text-secondary"><?= rupiah($o['total']) ?></td>
            <td class="px-5 py-4">
              <span class="px-3 py-1 rounded-full text-xs font-bold <?= $statusColors[$o['status']] ?? '' ?>">
                <?= ucfirst(e($o['status'])) ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($orders)): ?>
          <tr>
            <td colspan="5" class="px-5 py-12 text-center text-gray-400 font-light">
              <i class="fa-solid fa-folder-open text-3xl mb-2 text-gray-200 block"></i>
              Tidak ada transaksi tercatat pada periode ini.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<!-- Signature Preview on Admin Page -->
<?php if ($showTtd): ?>
  <div class="mt-8 flex justify-end">
    <div class="text-center w-[280px] text-sm text-gray-700 bg-white p-6 rounded-2xl shadow-sm border border-gray-100/40">
      <p class="text-gray-500 text-xs"><?= e($ttdCity) ?>, <?= tanggal_indonesia(date('Y-m-d')) ?></p>
      <p class="font-bold text-primary mt-1"><?= e($ttdTitle) ?></p>
      <div class="h-20 my-4 border-b border-dashed border-gray-200"></div>
      <p class="font-bold text-gray-800 underline"><?= e($ttdName) ?></p>
    </div>
  </div>
<?php endif; ?>


<script>
// Toggle Filter Groups based on selection
const filterType = document.getElementById('filterType');
const groups = {
  custom: document.getElementById('customGroup'),
  daily: document.getElementById('dailyGroup'),
  monthly: document.getElementById('monthlyGroup'),
  yearly: document.getElementById('yearlyGroup')
};

function updateFilters() {
  const selected = filterType.value;
  Object.keys(groups).forEach(key => {
    if (key === selected) {
      groups[key].classList.remove('hidden');
      if (key === 'custom') {
        groups[key].classList.add('flex');
      } else {
        groups[key].classList.add('block');
      }
    } else {
      groups[key].classList.add('hidden');
      groups[key].classList.remove('flex', 'block');
    }
  });
}

filterType.addEventListener('change', updateFilters);
updateFilters(); // Run immediately on page load

// Render Sales Trend Chart
new Chart(document.getElementById('trendChart'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{ 
      label: 'Jumlah Transaksi', 
      data: <?= json_encode($chartValues) ?>, 
      backgroundColor: '#D98324',
      borderRadius: 6
    }],
  },
  options: { 
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      }
    }
  },
});
</script>

<?php include APP_PATH . '/views/layouts/admin_footer.php'; ?>
