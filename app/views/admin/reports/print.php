<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pemesanan <?= e($from) ?> s/d <?= e($to) ?></title>
<style>
  body { font-family: Arial, sans-serif; color: #222; padding: 24px; }
  h1 { color: #7A2E1D; margin-bottom: 4px; }
  .meta { color: #666; margin-bottom: 20px; font-size: 13px; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
  th { background: #FBF3EA; color: #7A2E1D; }
  .summary { margin-bottom: 16px; font-weight: bold; }
  .print-btn { margin-bottom: 20px; }
  @media print {
    .print-btn { display: none; }
  }
</style>
</head>
<body>
  <button class="print-btn" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
  <h1><?= e($settings['site_name'] ?? 'UKM ARC') ?></h1>
  <p class="meta"><?= e($settings['address'] ?? '') ?></p>
  <h2>Laporan Pemesanan</h2>
  <p class="meta">Periode: <?= date('d M Y', strtotime($from)) ?> s/d <?= date('d M Y', strtotime($to)) ?></p>
  <p class="summary">Total Pendapatan (Selesai): <?= rupiah($totalRevenue) ?> | Total Pesanan: <?= count($orders) ?></p>

  <table>
    <thead>
      <tr><th>Kode</th><th>Tanggal</th><th>Pelanggan</th><th>Subtotal</th><th>Ongkir</th><th>Total</th><th>Status</th></tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <td><?= e($o['order_code']) ?></td>
          <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
          <td><?= e($o['customer_name']) ?></td>
          <td><?= rupiah($o['subtotal']) ?></td>
          <td><?= rupiah($o['shipping_cost']) ?></td>
          <td><?= rupiah($o['total']) ?></td>
          <td><?= ucfirst(e($o['status'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
