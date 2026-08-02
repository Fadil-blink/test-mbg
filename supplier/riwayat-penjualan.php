<?php $page_title = 'Riwayat Penjualan'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$totalSales = 0;
$completedOrders = 0;
$totalOrders = 0;
$avgTransaction = 0;
$rows = [];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function status_class($status) {
  return match ($status) {
    'delivered' => 'green',
    'processing', 'confirmed' => 'blue',
    'shipped', 'dikirim' => 'blue',
    'pending' => 'amber',
    'cancelled', 'rejected' => 'red',
    'returned', 'retur' => 'amber',
    default => 'gray',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(total_amount),0), SUM(order_status = "delivered"), COUNT(*) FROM orders WHERE supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalSales, $completedOrders, $totalOrders);
    $stmt->fetch();
    $stmt->close();
  }
  $avgTransaction = $totalOrders ? round($totalSales / $totalOrders) : 0;

  $stmt = $mysqli->prepare('SELECT o.order_number, DATE_FORMAT(o.order_date, "%d %b %Y") AS order_date, COALESCE(s.name, "-") AS sppg_name, GROUP_CONCAT(CONCAT(p.name, " (", oi.quantity, " ", p.unit, ")") SEPARATOR ", ") AS products, SUM(oi.subtotal) AS total_amount, o.order_status FROM orders o JOIN order_items oi ON oi.order_id = o.id JOIN products p ON p.id = oi.product_id LEFT JOIN sppg s ON s.id = o.sppg_id WHERE o.supplier_id = ? GROUP BY o.id ORDER BY o.order_date DESC LIMIT 5');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $rows[] = $row;
    }
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Riwayat Penjualan</h1>
    <p>Pantau dan kelola seluruh catatan transaksi penjualan Anda dalam ekosistem MBG secara real-time.</p>
  </div>
</div>

<div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
  <div class="stat-card">
    <div class="label">Total Penjualan <span class="badge green">+12%</span></div>
    <div class="value"><?= format_idr($totalSales) ?></div>
    <div class="delta">dibanding bulan lalu</div>
  </div>
  <div class="stat-card">
    <div class="label">Pesanan Selesai</div>
    <div class="value"><?= $completedOrders ?> Transaksi</div>
    <div class="delta">98.2% efisiensi pengiriman</div>
  </div>
  <div class="stat-card">
    <div class="label">Rata-rata Transaksi</div>
    <div class="value"><?= format_idr($avgTransaction) ?></div>
    <div class="delta" style="color:var(--text-muted);">Per transaksi</div>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Selesai</a>
  <a href="#">Dibatalkan</a>
  <a href="#">Retur</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Transaksi atau Nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
  <button class="btn"><i class="fa-solid fa-download"></i> Unduh Laporan</button>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Transaksi</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Komoditas</th><th>Jumlah</th><th>Total Nominal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--text-muted);">Belum ada transaksi penjualan.</td></tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($r['order_number']) ?></td>
            <td><?= htmlspecialchars($r['order_date']) ?></td>
            <td><?= htmlspecialchars($r['sppg_name']) ?></td>
            <td><?= htmlspecialchars($r['products']) ?></td>
            <td><?= number_format(array_sum(array_map('intval', explode(', ', preg_replace('/[^0-9,]+/', '', $r['products']))))) ?> Kg</td>
            <td><b><?= format_idr($r['total_amount']) ?></b></td>
            <td><span class="badge <?= status_class($r['order_status']) ?>"><?= strtoupper($r['order_status']) ?></span></td>
            <td><i class="fa-regular fa-eye" style="color:var(--blue);cursor:pointer;"></i></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <div class="pagination">
    <div>Menampilkan 1-<?= min(5, max(0, count($rows))) ?> dari <?= count($rows) ?> Transaksi</div>
    <div class="pages">
      <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <span>...</span>
      <a href="#">168</a>
      <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
