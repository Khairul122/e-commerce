<?php
function format_bulan_indo($monthStr)
{
  $bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember'
  ];
  $split = explode('-', $monthStr);
  if (count($split) === 2 && isset($bulan[$split[1]])) {
    return $bulan[$split[1]] . ' ' . $split[0];
  }
  return $monthStr;
}

function tanggal_indonesia($date)
{
  $bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  ];
  $split = explode('-', date('Y-m-d', strtotime($date)));
  return $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];
}

$yearlyYear = $_GET['yearly_year'] ?? date('Y');
$monthlyMonth = $_GET['monthly_month'] ?? date('Y-m');
$dailyDate = $_GET['daily_date'] ?? date('Y-m-d');

$showTtd = ($_GET['show_ttd'] ?? '1') === '1';
$ttdCity = $_GET['ttd_city'] ?? 'Padang';
$ttdTitle = $_GET['ttd_title'] ?? 'Pimpinan Dapoer ARC';
$ttdName = $_GET['ttd_name'] ?? 'Owner Dapoer ARC';

if ($filterType === 'yearly') {
  $labelPeriode = "Tahun " . $yearlyYear;
} elseif ($filterType === 'monthly') {
  $labelPeriode = format_bulan_indo($monthlyMonth);
} elseif ($filterType === 'daily') {
  $labelPeriode = tanggal_indonesia($dailyDate);
} else {
  $labelPeriode = tanggal_indonesia($from) . " s/d " . tanggal_indonesia($to);
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Pemesanan Dapoer ARC</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      color: #000;
      padding: 40px;
      line-height: 1.5;
      font-size: 14px;
      background: #fff;
    }

    /* Kop Surat Formal */
    .kop-surat {
      text-align: center;
      position: relative;
      margin-bottom: 25px;
    }

    .kop-surat h1 {
      font-size: 24px;
      font-weight: bold;
      margin: 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .kop-surat p {
      margin: 3px 0;
      font-size: 13px;
      font-style: italic;
      color: #333;
    }

    .kop-surat .alamat {
      font-size: 12px;
      font-style: normal;
      font-weight: normal;
    }

    .kop-line {
      border: none;
      border-top: 3px solid #000;
      border-bottom: 1px solid #000;
      height: 4px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    /* Judul Laporan */
    .judul-laporan {
      text-align: center;
      margin-bottom: 30px;
    }

    .judul-laporan h2 {
      margin: 0;
      font-size: 18px;
      font-weight: bold;
      text-decoration: underline;
      text-transform: uppercase;
    }

    .judul-laporan p {
      margin: 5px 0 0 0;
      font-size: 14px;
    }

    /* Meta Informasi */
    table.meta-tabel {
      width: 100%;
      margin-bottom: 20px;
      font-size: 13px;
      border-collapse: collapse;
    }

    table.meta-tabel td {
      border: none !important;
      padding: 3px 0 !important;
      text-align: left !important;
    }

    /* Tabel Data Laporan */
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
      margin-top: 10px;
    }

    th,
    td {
      border: 1px solid #000;
      padding: 8px 10px;
      text-align: left;
    }

    th {
      background: #f2f2f2;
      font-weight: bold;
      text-transform: uppercase;
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .font-bold {
      font-weight: bold;
    }

    /* Ringkasan Keuangan */
    .summary-row {
      background: #f9f9f9;
      font-weight: bold;
    }

    /* Tanda Tangan (TTD) */
    .ttd-container {
      margin-top: 50px;
      display: flex;
      justify-content: flex-end;
      page-break-inside: avoid;
    }

    .ttd-box {
      text-align: center;
      width: 280px;
      font-size: 14px;
    }

    .ttd-space {
      height: 80px;
    }

    .print-btn {
      background: #000;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 4px;
      font-size: 13px;
      font-weight: bold;
      cursor: pointer;
      margin-bottom: 20px;
    }

    @media print {
      .print-btn {
        display: none;
      }

      body {
        padding: 0;
      }
    }

    <?php if ($filterType === 'yearly'): ?>
      @page {
        size: landscape;
        margin: 0.5cm;
      }

      body {
        padding: 10px;
        font-size: 10px;
      }

      table {
        font-size: 8px;
        width: 100%;
      }

      th,
      td {
        padding: 3px 2px !important;
        text-align: center;
      }

      .kop-surat h1 {
        font-size: 18px;
      }

      .kop-surat p {
        font-size: 10px;
      }

      .kop-line {
        margin-top: 5px;
        margin-bottom: 10px;
      }

      .judul-laporan {
        margin-bottom: 15px;
      }

      .judul-laporan h2 {
        font-size: 14px;
      }

      .meta-tabel {
        font-size: 10px;
        margin-bottom: 10px;
      }

      .ttd-container {
        margin-top: 25px;
      }

      .ttd-box {
        width: 220px;
        font-size: 11px;
      }

      .ttd-space {
        height: 50px;
      }

    <?php endif; ?>
  </style>
</head>

<body>
  <button class="print-btn" onclick="window.print()">Cetak Dokumen Laporan</button>

  <!-- Kop Surat Formal -->
  <div class="kop-surat">
    <h1><?= e($settings['site_name'] ?? 'Dapoer ARC') ?></h1>
    <p>Spesialis Kue Tradisional, Pastry, Nasi Box & Catering Higienis</p>
    <p class="alamat">Alamat: <?= e($settings['address'] ?? 'Kota Padang, Sumatera Barat') ?> | Telp/WA:
      <?= e($settings['whatsapp'] ?? $settings['phone'] ?? '') ?> | Email: <?= e($settings['email'] ?? '') ?></p>
    <hr class="kop-line">
  </div>

  <!-- Judul Laporan -->
  <div class="judul-laporan">
    <h2>Laporan Realisasi Pendapatan Penjualan</h2>
    <p>Periode Laporan: <?= $labelPeriode ?></p>
  </div>

  <!-- Meta Informasi Dokumen -->
  <div style="display: flex; justify-content: space-between; margin-bottom: 20px; font-size: <?= $filterType === 'yearly' ? '10px' : '13px' ?>;">
    <!-- Bagian Kiri (50%) -->
    <table class="meta-tabel" style="width: 50%; border-collapse: collapse;">
      <tr>
        <td style="width: 100px; font-weight: bold; padding: 3px 0;">Klasifikasi</td>
        <td style="width: 15px; text-align: center; padding: 3px 0;">:</td>
        <td style="padding: 3px 0;">Laporan Keuangan Internal UKM</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 3px 0;">Status Data</td>
        <td style="text-align: center; padding: 3px 0;">:</td>
        <td style="padding: 3px 0;">Telah Realisasi (Selesai)</td>
      </tr>
    </table>
    <!-- Bagian Kanan (Rapat & Selalu di Kanan Kertas) -->
    <table class="meta-tabel" style="width: auto; margin-left: auto; border-collapse: collapse;">
      <tr>
        <td style="width: 100px; font-weight: bold; padding: 3px 0;">Tanggal Cetak</td>
        <td style="width: 15px; text-align: center; padding: 3px 0;">:</td>
        <td style="padding: 3px 0; white-space: nowrap;"><?= tanggal_indonesia(date('Y-m-d')) ?></td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 3px 0;">Dicetak Oleh</td>
        <td style="width: 15px; text-align: center; padding: 3px 0;">:</td>
        <td style="padding: 3px 0; white-space: nowrap;">Administrator Utama</td>
      </tr>
    </table>
  </div>

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
      $month = (int) date('m', $dt);
      $day = (int) date('d', $dt);
      $week = min(4, (int) ceil($day / 7));
      $prodName = $item['product_name'];
      if (isset($matrix[$prodName])) {
        $matrix[$prodName][$month][$week] += (int) $item['quantity'];
      }
    }

    $bulanIndo = [
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember'
    ];
    ?>
    <table style="width: 100%; border-collapse: collapse;">
      <thead>
        <tr>
          <th rowspan="2" style="text-align: left; padding: 4px; font-weight: bold;">Nama Produk</th>
          <?php foreach ($bulanIndo as $m => $name): ?>
            <th colspan="4" class="text-center" style="font-weight: bold; background: #f2f2f2;"><?= $name ?></th>
          <?php endforeach; ?>
          <th rowspan="2" class="text-center" style="font-weight: bold; background: #e6e6e6;">Total</th>
        </tr>
        <tr>
          <?php for ($m = 1; $m <= 12; $m++): ?>
            <th class="text-center" style="font-size: 9px; padding: 2px;">1</th>
            <th class="text-center" style="font-size: 9px; padding: 2px;">2</th>
            <th class="text-center" style="font-size: 9px; padding: 2px;">3</th>
            <th class="text-center" style="font-size: 9px; padding: 2px;">4</th>
          <?php endfor; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($matrix as $prodName => $months): ?>
          <?php
          $rowTotal = 0;
          for ($m = 1; $m <= 12; $m++) {
            $rowTotal += array_sum($months[$m]);
          }
          ?>
          <tr>
            <td class="font-bold" style="text-align: left; padding: 4px;"><?= e($prodName) ?></td>
            <?php for ($m = 1; $m <= 12; $m++): ?>
              <?php for ($w = 1; $w <= 4; $w++): ?>
                <?php $val = $months[$m][$w]; ?>
                <td class="text-center" style="<?= $val > 0 ? 'font-weight: bold;' : 'color: #ccc;' ?>"><?= $val ?: '-' ?></td>
              <?php endfor; ?>
            <?php endfor; ?>
            <td class="text-center font-bold" style="background: #fafafa;"><?= $rowTotal ?: '-' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <!-- Tabel Utama default -->
    <table>
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 15%;">Kode Transaksi</th>
          <th style="width: 15%;">Tanggal</th>
          <th>Nama Pelanggan</th>
          <th style="width: 15%;">Subtotal</th>
          <th style="width: 12%;">Biaya Ongkir</th>
          <th style="width: 18%;">Total Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1;
        foreach ($orders as $o): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center font-bold"><?= e($o['order_code']) ?></td>
            <td class="text-center"><?= date('d-m-Y H:i', strtotime($o['created_at'])) ?></td>
            <td><?= e($o['customer_name']) ?></td>
            <td class="text-right"><?= rupiah($o['subtotal']) ?></td>
            <td class="text-right"><?= rupiah($o['shipping_cost']) ?></td>
            <td class="text-right font-bold"><?= rupiah($o['total']) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($orders)): ?>
          <tr>
            <td colspan="7" class="text-center" style="color: #666; padding: 20px; font-style: italic;">Tidak ada realisasi
              transaksi pada periode ini.</td>
          </tr>
        <?php else: ?>
          <!-- Baris Total Ringkasan -->
          <tr class="summary-row">
            <td colspan="4" class="text-right">TOTAL PENDAPATAN REALISASI (SELESAI):</td>
            <td colspan="3" class="text-right font-bold" style="font-size: 15px; border-left: 2px solid #000;">
              <?= rupiah($totalRevenue) ?></td>
          </tr>
          <tr class="summary-row">
            <td colspan="4" class="text-right">TOTAL VOLUME PENJUALAN:</td>
            <td colspan="3" class="text-right font-bold"><?= count($orders) ?> Transaksi Sukses</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <?php if ($showTtd): ?>
    <!-- Bagian Tanda Tangan (TTD) -->
    <div class="ttd-container">
      <div class="ttd-box">
        <p><?= e($ttdCity) ?>, <?= tanggal_indonesia(date('Y-m-d')) ?></p>
        <p>Mengetahui/Menyetujui,</p>
        <p class="font-bold" style="margin-top: 5px;"><?= e($ttdTitle) ?></p>
        <div class="ttd-space"></div>
        <p style="text-decoration: underline; font-weight: bold;"><?= e($ttdName) ?></p>
      </div>
    </div>
  <?php endif; ?>

  <script>
    // Trigger print dialog automatically when document is fully loaded
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(() => {
        window.print();
      }, 300);
    });
  </script>
</body>

</html>