<?php $page_title = 'Produk Saya'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$products = [];
$totalProducts = 0;
$activeProducts = 0;
$inactiveProducts = 0;
$categoriesCount = 0;

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function status_badge($status) {
  return match ($status) {
    'aman' => 'green',
    'menipis' => 'amber',
    'habis' => 'red',
    default => 'gray',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT p.name, p.sku, c.name AS category, p.price_per_unit, p.current_stock, p.stock_status, p.unit, p.is_active FROM products p JOIN categories c ON p.category_id = c.id WHERE p.supplier_id = ? ORDER BY p.is_active DESC, p.current_stock DESC');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $products[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COUNT(*) AS total, SUM(p.is_active = 1) AS active, COUNT(*) - SUM(p.is_active = 1) AS inactive, COUNT(DISTINCT p.category_id) AS categories FROM products p WHERE p.supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalProducts, $activeProducts, $inactiveProducts, $categoriesCount);
    $stmt->fetch();
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Produk Saya</h1>
    <p>Kelola daftar komoditas dan produk agrikultur Anda.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Produk <i class="fa-solid fa-box-archive"></i></div><div class="value"><?= $totalProducts ?></div></div>
  <div class="stat-card"><div class="label">Produk Aktif <i class="fa-solid fa-circle-check" style="color:var(--green)"></i></div><div class="value" style="color:var(--green)"><?= $activeProducts ?></div></div>
  <div class="stat-card"><div class="label">Produk Non-Aktif <i class="fa-solid fa-circle-xmark" style="color:var(--red)"></i></div><div class="value" style="color:var(--red)"><?= $inactiveProducts ?></div></div>
  <div class="stat-card"><div class="label">Kategori Produk <i class="fa-solid fa-sitemap"></i></div><div class="value"><?= $categoriesCount ?></div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari nama produk atau SKU..."></div>
  <span class="select-fake">Semua Kategori <i class="fa-solid fa-chevron-down"></i></span>
  <span class="select-fake">Semua Status <i class="fa-solid fa-chevron-down"></i></span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>Produk</th><th>Kategori</th><th>Harga Satuan</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($products)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Belum ada produk terdaftar.</td></tr>
      <?php else: ?>
        <?php foreach ($products as $p): ?>
          <tr>
            <td>
              <div class="product-cell">
                <img src="https://placehold.co/44x44/e6ebf1/6b7c93?text=%20" alt="">
                <div><div class="p-name"><?= htmlspecialchars($p['name']) ?></div><div class="p-sku">SKU: <?= htmlspecialchars($p['sku']) ?></div></div>
              </div>
            </td>
            <td><?= htmlspecialchars($p['category']) ?></td>
            <td><b><?= format_idr($p['price_per_unit']) ?>/<?= htmlspecialchars($p['unit']) ?></b></td>
            <td><?= number_format((int)$p['current_stock']) ?> <?= htmlspecialchars($p['unit']) ?></td>
            <td><span class="badge <?= status_badge($p['stock_status']) ?>"><?= ucfirst($p['stock_status']) ?></span></td>
            <td><a href="#" class="cell-link">Edit</a> &nbsp; <a href="#" class="cell-link">Detail</a></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
