<?php
$pageTitle = 'Pesanan Saya';
$active = 'pesanan';
include 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$orgId = $_SESSION['organization_id'] ?? null;
$where = [];
$params = [];
$types = '';
if ($orgId) {
  $where[] = 'o.sppg_id = ?';
  $types .= 'i';
  $params[] = &$orgId;
}
if ($search !== '') {
  $where[] = '(o.order_number LIKE ? OR s.name LIKE ?)';
  $types .= 'ss';
  $term = "%{$search}%";
  $params[] = &$term;
  $params[] = &$term;
}
$sql = 'SELECT o.order_number, s.name AS supplier, DATE_FORMAT(o.order_date, "%d %b %Y") AS order_date, o.total_amount, o.order_status FROM orders o LEFT JOIN suppliers s ON o.supplier_id = s.id';
if (!empty($where)) {
  $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY o.order_date DESC LIMIT 20';
$stmt = $mysqli->prepare($sql);
$orders = [];
if ($stmt) {
  if ($types !== '') {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}
function status_class($s){
  $map = ['Diproses'=>'diproses','Dikirim'=>'dikirim','Selesai'=>'selesai','Kendala'=>'kendala','Menunggu'=>'menunggu'];
  return $map[$s] ?? '';
}
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Pesanan Saya</b></div>
    <h1 class="page-title">Pesanan Saya</h1>
    <p class="page-sub">Pantau status pengadaan dan kelola pesanan SPPG Anda.</p>
  </div>
  <a href="#" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Unduh Laporan
  </a>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Menunggu</a>
  <a href="#">Diproses</a>
  <a href="#">Sedang Dikirim</a>
  <a href="#">Selesai</a>
</div>

<div class="toolbar">
  <form method="get" style="display:flex;gap:12px;flex-wrap:wrap;width:100%;">
    <div class="search-input" style="flex:1;min-width:240px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
      <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari ID Pesanan atau Supplier...">
    </div>
    <select name="status" disabled>
      <option>📅 Pilih Tanggal</option>
    </select>
    <button type="submit" class="btn btn-outline">Filter</button>
  </form>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr><th>ID Pesanan</th><th>Supplier</th><th>Tanggal</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php if (empty($orders)): ?>
        <tr><td colspan="6" style="text-align:center;padding:22px;color:var(--text-500);">Tidak ditemukan pesanan.</td></tr>
      <?php endif; ?>
      <?php foreach ($orders as $o): ?>
      <tr>
        <td class="cell-strong"><?php echo htmlspecialchars($o['order_number']); ?></td>
        <td><?php echo htmlspecialchars($o['supplier']); ?></td>
        <td class="cell-muted"><?php echo htmlspecialchars($o['order_date']); ?></td>
        <td class="cell-strong"><?php echo number_format($o['total_amount'], 0, ',', '.'); ?></td>
        <td><span class="status-pill <?php echo status_class($o['order_status']); ?>"><?php echo htmlspecialchars($o['order_status']); ?></span></td>
        <td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="table-footer">
    <span>Menampilkan <?php echo count($orders); ?> dari <?php echo count($orders); ?> pesanan</span>
    <div class="pagination">
      <a href="#">&lsaquo;</a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">&rsaquo;</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
