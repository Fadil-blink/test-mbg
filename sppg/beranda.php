<?php
$pageTitle = 'Beranda';
$active = 'beranda';
include 'includes/header.php';

$orgId = $_SESSION['organization_id'] ?? null;
$stats = [
  'budget_total' => 0,
  'budget_used' => 0,
  'remaining' => 0,
  'percent_used' => 0,
  'orders_total' => 0,
  'supplier_count' => 0,
  'product_count' => 0,
];
$orders = [];

function table_exists($mysqli, $table) {
  $result = $mysqli->query("SHOW TABLES LIKE '" . $mysqli->real_escape_string($table) . "'");
  return $result && $result->num_rows > 0;
}

if (table_exists($mysqli, 'budget')) {
  $budgetSql = 'SELECT COALESCE(SUM(total_budget),0) AS total, COALESCE(SUM(used_amount),0) AS used, COALESCE(SUM(remaining),0) AS remaining FROM budget';
  if ($orgId) {
    $budgetSql .= ' WHERE sppg_id = ?';
  }
  $budgetStmt = $mysqli->prepare($budgetSql);
  if ($budgetStmt) {
    if ($orgId) {
      $budgetStmt->bind_param('i', $orgId);
    }
    $budgetStmt->execute();
    $budgetResult = $budgetStmt->get_result()->fetch_assoc();
    if ($budgetResult) {
      $stats['budget_total'] = $budgetResult['total'];
      $stats['budget_used'] = $budgetResult['used'];
      $stats['remaining'] = $budgetResult['remaining'];
      $stats['percent_used'] = $budgetResult['total'] ? round(($budgetResult['used'] / $budgetResult['total']) * 100, 1) : 0;
    }
    $budgetStmt->close();
  }
}

$supplierStmt = $mysqli->prepare('SELECT COUNT(*) AS total FROM suppliers WHERE is_verified = TRUE AND status = "aktif"');
if ($supplierStmt) {
  $supplierStmt->execute();
  $supplierResult = $supplierStmt->get_result()->fetch_assoc();
  $stats['supplier_count'] = $supplierResult['total'] ?? 0;
  $supplierStmt->close();
}

$productStmt = $mysqli->prepare('SELECT COUNT(*) AS total FROM products WHERE is_active = TRUE');
if ($productStmt) {
  $productStmt->execute();
  $productResult = $productStmt->get_result()->fetch_assoc();
  $stats['product_count'] = $productResult['total'] ?? 0;
  $productStmt->close();
}

$orderSql = 'SELECT o.order_number, o.order_date, o.total_amount, o.order_status, s.name AS supplier_name FROM orders o LEFT JOIN suppliers s ON o.supplier_id = s.id';
if ($orgId) {
  $orderSql .= ' WHERE o.sppg_id = ?';
}
$orderSql .= ' ORDER BY o.order_date DESC LIMIT 6';
$orderStmt = $mysqli->prepare($orderSql);
if ($orderStmt) {
  if ($orgId) {
    $orderStmt->bind_param('i', $orgId);
  }
  $orderStmt->execute();
  $orders = $orderStmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $orderStmt->close();
}

$stats['orders_total'] = count($orders);

function status_class($s) {
  $map = ['pending'=>'menunggu','processing'=>'diproses','shipped'=>'dikirim','delivered'=>'selesai','cancelled'=>'kendala'];
  return $map[strtolower($s)] ?? '';
}
?>
<div class="page-header-row">
  <div>
    <h1 class="page-title">Selamat Datang, <?php echo htmlspecialchars($fullName); ?></h1>
    <p class="page-sub">Ringkasan operasional SPPG dan status pengadaan saat ini.</p>
  </div>
  <a href="pesanan-saya.php" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Laporan Cepat
  </a>
</div>

<div class="stat-grid cols-6">
  <div class="stat-card">
    <div class="top-row"><div class="icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6h20v14H2z"/><path d="M6 10h12"/><path d="M10 14h4"/></svg></div><span class="badge-pct up">+12.4%</span></div>
    <div class="label">Total Anggaran</div>
    <div class="value small"><?php echo number_format($stats['budget_total'], 0, ',', '.'); ?></div>
  </div>
  <div class="stat-card">
    <div class="top-row"><div class="icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 3-6.7"/><path d="M3 4v5h5"/></svg></div><span class="badge-pct neutral"><?php echo $stats['percent_used']; ?>% digunakan</span></div>
    <div class="label">Anggaran Terpakai</div>
    <div class="value small"><?php echo number_format($stats['budget_used'], 0, ',', '.'); ?></div>
  </div>
  <div class="stat-card">
    <div class="top-row"><div class="icon teal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V7h18v12a2 2 0 0 1-2 2z"/><path d="M16 5V3H8v2"/></svg></div></div>
    <div class="label">Sisa Anggaran</div>
    <div class="value small"><?php echo number_format($stats['remaining'], 0, ',', '.'); ?></div>
  </div>
  <div class="stat-card">
    <div class="top-row"><div class="icon gray"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M7 10h10"/><path d="M9 14h6"/></svg></div></div>
    <div class="label">Supplier Aktif</div>
    <div class="value small"><?php echo $stats['supplier_count']; ?></div>
  </div>
  <div class="stat-card">
    <div class="top-row"><div class="icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6h20v14H2z"/><path d="M6 10h12"/><path d="M10 14h4"/></svg></div></div>
    <div class="label">Produk Tersedia</div>
    <div class="value small"><?php echo $stats['product_count']; ?></div>
  </div>
  <div class="stat-card">
    <div class="top-row"><div class="icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/></svg></div></div>
    <div class="label">Pesanan Aktif</div>
    <div class="value small"><?php echo $stats['orders_total']; ?></div>
  </div>
</div>

<div class="two-col">
  <div class="panel">
    <div class="panel-head"><h3>Grafik Pengeluaran Bulanan</h3><select><option>Tahun 2024</option><option>Tahun 2023</option></select></div>
    <div class="panel-sub">Trend belanja komoditas 6 bulan terakhir</div>
    <div class="bar-chart"><div class="bar-col"><div class="bar" style="height:60%;"></div><div class="bar-label">MEI</div></div><div class="bar-col"><div class="bar" style="height:55%;"></div><div class="bar-label">JUN</div></div><div class="bar-col"><div class="bar" style="height:38%;"></div><div class="bar-label">JUL</div></div><div class="bar-col"><div class="bar highlight" style="height:90%;"></div><div class="bar-label">AGU</div></div><div class="bar-col"><div class="bar" style="height:80%;"></div><div class="bar-label">SEP</div></div><div class="bar-col"><div class="bar" style="height:100%;"></div><div class="bar-label">OKT</div></div></div>
  </div>
  <div class="panel">
    <div class="panel-head"><h3>Notifikasi Terbaru</h3><a href="notifikasi.php" class="seeall">Semua</a></div>
    <div class="notif-list">
      <div class="notif-item"><div class="n-icon blue"><svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/></svg></div><div><b>Pesanan baru diterima</b><p>Pesanan #ORD-2024-0089 sedang dalam proses pengiriman.</p><div class="time">1 jam yang lalu</div></div></div>
      <div class="notif-item"><div class="n-icon green"><svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg></div><div><b>Supplier terverifikasi</b><p>Supplier CV. Sembako Jaya sekarang tersedia untuk pemesanan.</p><div class="time">3 jam yang lalu</div></div></div>
    </div>
  </div>
</div>

<div class="panel">
  <div class="panel-head"><h3>Daftar Pesanan Terbaru</h3><a href="pesanan-saya.php" class="btn btn-outline btn-sm">Lihat Semua</a></div>
  <div class="panel-sub">Monitoring transaksi pengadaan aktif</div>
  <div class="table-wrap" style="box-shadow:none;border:1px solid var(--border);">
    <table class="data-table">
      <thead><tr><th>ID Pesanan</th><th>Supplier</th><th>Total Tagihan</th><th>Status</th></tr></thead>
      <tbody>
        <?php if (empty($orders)): ?>
          <tr><td colspan="4" style="text-align:center;padding:22px;color:var(--text-500);">Tidak ada pesanan tersedia.</td></tr>
        <?php endif; ?>
        <?php foreach ($orders as $o): ?>
        <tr>
          <td class="cell-link"><?php echo htmlspecialchars($o['order_number']); ?></td>
          <td><?php echo htmlspecialchars($o['supplier_name'] ?: 'Supplier Tidak Diketahui'); ?></td>
          <td class="cell-strong"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?></td>
          <td><span class="status-pill <?php echo status_class($o['order_status']); ?>"><?php echo htmlspecialchars($o['order_status']); ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
