<?php
$pageTitle = 'Supplier';
$active = 'supplier';
include 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$where = ['s.is_verified = TRUE', 's.status = "aktif"'];
$params = [];
$types = '';
if ($search !== '') {
  $where[] = '(s.name LIKE ? OR s.province LIKE ? OR s.city LIKE ? OR s.type LIKE ?)';
  $types .= 'ssss';
  $term = "%{$search}%";
  $params[] = &$term;
  $params[] = &$term;
  $params[] = &$term;
  $params[] = &$term;
}
$sql = 'SELECT s.id, s.name, s.type, s.city, s.province, s.rating, s.total_sales, s.total_transactions, s.status, COUNT(p.id) AS product_count FROM suppliers s LEFT JOIN products p ON p.supplier_id = s.id WHERE ' . implode(' AND ', $where) . ' GROUP BY s.id ORDER BY s.rating DESC LIMIT 24';
$stmt = $mysqli->prepare($sql);
$suppliers = [];
if ($stmt) {
  if ($types !== '') {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $suppliers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Supplier</b></div>
    <h1 class="page-title">Daftar Supplier Terverifikasi</h1>
    <p class="page-sub">Kelola dan temukan mitra supplier berkualitas untuk pemenuhan gizi nasional.</p>
  </div>
  <a href="#" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
    Daftarkan Supplier Baru
  </a>
</div>

<div class="filter-bar">
  <form method="get" style="display:flex;flex-wrap:wrap;gap:14px;width:100%;">
    <div class="filter-item" style="flex:1;min-width:240px;">
      <label>Cari Supplier</label>
      <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nama atau lokasi supplier...">
    </div>
    <div class="filter-item grow">
      <label>Jenis Komoditas</label>
      <select disabled><option>Semua</option><option>Protein</option><option>Karbohidrat</option></select>
    </div>
    <div class="filter-item">
      <label>Rating Minimum</label>
      <select disabled><option>★★★★☆ 4.0+</option><option>★★★☆☆ 3.0+</option></select>
    </div>
    <div class="filter-item" style="flex:0.6;justify-content:flex-end;display:flex;align-items:flex-end;">
      <button type="submit" class="btn btn-outline" style="width:100%;">Cari</button>
    </div>
  </form>
</div>

<div class="supplier-grid">
  <?php if (empty($suppliers)): ?>
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-500);">Tidak ada supplier terverifikasi yang cocok.</div>
  <?php endif; ?>
  <?php foreach ($suppliers as $s): ?>
  <div class="supplier-card">
    <div class="thumb">
      <img src="https://images.unsplash.com/photo-1500937386664-56d1dfef3854?w=500&h=300&fit=crop" alt="<?php echo htmlspecialchars($s['name']); ?>">
      <div class="verified">Terverifikasi</div>
      <div class="logo-badge"><?php echo htmlspecialchars(substr($s['name'], 0, 2)); ?></div>
    </div>
    <div class="body">
      <div class="s-name"><?php echo htmlspecialchars($s['name']); ?></div>
      <div class="s-type"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $s['type']))); ?></div>
      <div class="s-loc"><span>📍 <?php echo htmlspecialchars($s['city']); ?>, <?php echo htmlspecialchars($s['province']); ?></span><span class="stars">⭐ <?php echo htmlspecialchars($s['rating']); ?></span></div>
      <div class="s-stats">
        <div><div class="stat-label">Produk</div><div class="stat-val"><?php echo htmlspecialchars($s['product_count']); ?> Item</div></div>
        <div><div class="stat-label">Kapasitas</div><div class="stat-val"><?php echo htmlspecialchars(number_format($s['total_transactions'], 0, ',', '.')); ?> Order</div></div>
      </div>
      <a href="belanja-komoditas.php" class="view-btn">Lihat Produk
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="table-footer" style="padding:0;">
  <span>Menampilkan <?php echo count($suppliers); ?> supplier terverifikasi</span>
  <div class="pagination">
    <a href="#">&lsaquo;</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <a href="#">3</a>
    <a href="#">&rsaquo;</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
