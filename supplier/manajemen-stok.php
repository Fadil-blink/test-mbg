<?php $page_title = 'Manajemen Stok'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$stocks = [];
$totalProducts = 0;
$lowStock = 0;
$outOfStock = 0;
$lastUpdated = null;

function status_badge($status) {
  return match ($status) {
    'aman' => 'green',
    'menipis' => 'amber',
    'habis' => 'red',
    default => 'gray',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT p.name, p.sku, c.name AS category, p.current_stock, p.unit, p.stock_status, p.updated_at FROM products p JOIN categories c ON p.category_id = c.id WHERE p.supplier_id = ? ORDER BY p.stock_status ASC, p.current_stock ASC');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $stocks[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COUNT(*) AS total, SUM(stock_status = "menipis") AS low, SUM(stock_status = "habis") AS out_of_stock, MAX(updated_at) AS last_updated FROM products WHERE supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalProducts, $lowStock, $outOfStock, $lastUpdated);
    $stmt->fetch();
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Manajemen Stok</h1>
    <p>Pantau dan kelola ketersediaan stok komoditas Anda.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Stok</button>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Produk <i class="fa-solid fa-box-archive"></i></div><div class="value"><?= $totalProducts ?></div></div>
  <div class="stat-card"><div class="label">Produk Stok Rendah <i class="fa-solid fa-triangle-exclamation" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)"><?= $lowStock ?></div></div>
  <div class="stat-card"><div class="label">Produk Habis <i class="fa-solid fa-circle-exclamation" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)"><?= $outOfStock ?></div></div>
  <div class="stat-card"><div class="label">Update Terakhir <i class="fa-solid fa-rotate"></i></div><div class="value" style="font-size:18px;"><?= $lastUpdated ? date('d M Y H:i', strtotime($lastUpdated)) : 'Belum ada' ?></div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari nama produk atau SKU..."></div>
  <span class="select-fake">Semua Kategori <i class="fa-solid fa-chevron-down"></i></span>
  <span class="select-fake">Semua Status Stok <i class="fa-solid fa-chevron-down"></i></span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Produk</th><th>Kategori</th><th>Stok Saat Ini</th><th>Satuan</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($stocks)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Belum ada produk terdaftar.</td></tr>
      <?php else: ?>
        <?php foreach ($stocks as $s): ?>
          <tr>
            <td>
              <div class="product-cell">
                <img src="https://placehold.co/44x44/e6ebf1/6b7c93?text=%20" alt="">
                <div><div class="p-name"><?= htmlspecialchars($s['name']) ?></div><div class="p-sku">SKU: <?= htmlspecialchars($s['sku']) ?></div></div>
              </div>
            </td>
            <td><?= htmlspecialchars($s['category']) ?></td>
            <td><b><?= number_format((int)$s['current_stock']) ?></b></td>
            <td><?= htmlspecialchars($s['unit']) ?></td>
            <td><span class="badge <?= status_badge($s['stock_status']) ?>"><?= ucfirst($s['stock_status']) ?></span></td>
            <td><a href="#" class="cell-link">Update Stok</a></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
