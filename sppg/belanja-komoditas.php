<?php
$pageTitle = 'Belanja Komoditas';
$active = 'belanja';
include 'includes/header.php';

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$supplierType = trim($_GET['supplier_type'] ?? '');
$where = ['p.is_active = 1', 'p.stock_status != "habis"'];
$params = [];
$types = '';
if ($search !== '') {
  $where[] = '(p.name LIKE ? OR s.name LIKE ? OR c.name LIKE ?)';
  $types .= 'sss';
  $term = "%{$search}%";
  $params[] = &$term;
  $params[] = &$term;
  $params[] = &$term;
}
if ($category !== '') {
  $where[] = 'c.code = ?';
  $types .= 's';
  $params[] = &$category;
}
if ($supplierType !== '') {
  $where[] = 's.type = ?';
  $types .= 's';
  $params[] = &$supplierType;
}
$sql = 'SELECT p.code, p.name, p.price_per_unit, p.unit, p.rating, p.current_stock, p.stock_status, s.name AS supplier_name, s.type AS supplier_type, s.city, s.province, c.name AS category_name FROM products p JOIN suppliers s ON p.supplier_id = s.id JOIN categories c ON p.category_id = c.id WHERE ' . implode(' AND ', $where) . ' ORDER BY p.rating DESC LIMIT 24';
$stmt = $mysqli->prepare($sql);
$products = [];
if ($stmt) {
  if ($types !== '') {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}
$categoryResult = $mysqli->query('SELECT code, name FROM categories WHERE is_active = TRUE ORDER BY name');
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Belanja Komoditas</b></div>
    <h1 class="page-title">Belanja Komoditas</h1>
    <p class="page-sub">SPPG dapat membeli bahan pangan hanya dari supplier terverifikasi untuk menjamin kualitas program.</p>
  </div>
  <a href="pesanan-saya.php" class="btn btn-navy">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/></svg>
    Keranjang (<span class="cart-count">3</span>)
  </a>
</div>

<div class="filter-bar">
  <form method="get" style="display:flex;flex-wrap:wrap;gap:14px;width:100%;">
    <div class="filter-item" style="flex:1;min-width:200px;">
      <label>Produk</label>
      <input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari produk atau supplier...">
    </div>
    <div class="filter-item">
      <label>Kategori</label>
      <select name="category">
        <option value="">Semua Kategori</option>
        <?php while ($row = $categoryResult->fetch_assoc()): ?>
          <option value="<?php echo htmlspecialchars($row['code']); ?>" <?php echo $category === $row['code'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['name']); ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="filter-item">
      <label>Jenis Supplier</label>
      <select name="supplier_type">
        <option value="">Semua Jenis</option>
        <option value="pt" <?php echo $supplierType === 'pt' ? 'selected' : ''; ?>>PT</option>
        <option value="koperasi" <?php echo $supplierType === 'koperasi' ? 'selected' : ''; ?>>Koperasi</option>
        <option value="umkm" <?php echo $supplierType === 'umkm' ? 'selected' : ''; ?>>UMKM</option>
      </select>
    </div>
    <div class="filter-item" style="flex:0.8;justify-content:flex-end;display:flex;align-items:flex-end;">
      <button type="submit" class="btn btn-outline" style="width:100%;">Terapkan</button>
    </div>
  </form>
</div>

<div class="commodity-grid">
  <?php if (empty($products)): ?>
    <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-500);">Tidak ditemukan produk yang sesuai.</div>
  <?php endif; ?>
  <?php foreach ($products as $p): ?>
  <div class="commodity-card">
    <div class="thumb">
      <img src="https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400&h=300&fit=crop" alt="<?php echo htmlspecialchars($p['name']); ?>">
      <div class="rating"><svg viewBox="0 0 24 24"><polygon points="12 2 15 9 22 9 16.5 13.5 18.5 21 12 17 5.5 21 7.5 13.5 2 9 9 9"/></svg> <?php echo htmlspecialchars($p['rating']); ?></div>
      <div class="verified-badge">TERVERIFIKASI</div>
    </div>
    <div class="body">
      <div class="name-price">
        <span class="name"><?php echo htmlspecialchars($p['name']); ?></span>
        <span class="price"><?php echo number_format($p['price_per_unit'],0,',','.'); ?> <small>/<?php echo htmlspecialchars($p['unit']); ?></small></span>
      </div>
      <div class="supplier-row">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l1.5-5h15L21 9"/><path d="M3 9v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9"/></svg>
        <?php echo htmlspecialchars($p['supplier_name']); ?>
      </div>
      <div class="tag-row"><span class="tag"><?php echo strtoupper(htmlspecialchars($p['supplier_type'])); ?></span> <?php echo htmlspecialchars($p['city']); ?>, <?php echo htmlspecialchars($p['province']); ?></div>
      <div class="stock-row"><span>Sisa Stok:</span> <b><?php echo htmlspecialchars(number_format($p['current_stock'], 0, ',', '.')); ?> <?php echo htmlspecialchars($p['unit']); ?></b></div>
      <button class="add-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 12.2a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L21 8H6"/></svg>
        Tambah ke Keranjang
      </button>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="table-footer" style="padding:0;">
  <span>Menampilkan <?php echo count($products); ?> produk</span>
  <div class="pagination">
    <a href="#">&lsaquo;</a>
    <a href="#" class="active">1</a>
    <a href="#">2</a>
    <span class="dots">…</span>
    <a href="#">4</a>
    <a href="#">&rsaquo;</a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
