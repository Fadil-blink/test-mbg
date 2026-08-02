<?php $page_title = 'Analitik Penjualan'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$totalRevenue = 0;
$totalUnits = 0;
$growth = '+0%';
$topProducts = [];
$monthlyLabels = [];
$monthlyRevenue = [];
$categoryShares = [];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function trend_class($trend) {
  return match ($trend) {
    'up' => 'trend-up',
    'down' => 'trend-down',
    default => 'trend-flat',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(o.total_amount),0) FROM orders o WHERE o.supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalRevenue);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(oi.quantity),0) FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalUnits);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT p.name, c.name AS category, SUM(oi.quantity) AS quantity_sold, COALESCE(SUM(oi.subtotal),0) AS total_amount, CASE WHEN SUM(oi.quantity) >= 1000 THEN "up" WHEN SUM(oi.quantity) >= 500 THEN "flat" ELSE "down" END AS trend FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN categories c ON p.category_id = c.id JOIN orders o ON o.id = oi.order_id WHERE o.supplier_id = ? GROUP BY p.id ORDER BY quantity_sold DESC LIMIT 5');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $topProducts[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT DATE_FORMAT(MIN(o.order_date), "%b") AS month_label, COALESCE(SUM(o.total_amount),0) AS month_amount FROM orders o WHERE o.supplier_id = ? AND o.order_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY YEAR(o.order_date), MONTH(o.order_date) ORDER BY YEAR(o.order_date), MONTH(o.order_date)');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $monthlyLabels[] = $row['month_label'];
      $monthlyRevenue[] = round((int)$row['month_amount'] / 1000000, 1);
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT c.name AS category_name, COALESCE(SUM(oi.subtotal),0) AS total_amount FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN categories c ON p.category_id = c.id JOIN orders o ON o.id = oi.order_id WHERE o.supplier_id = ? GROUP BY c.id ORDER BY total_amount DESC LIMIT 4');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $categoryShares[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(o.total_amount),0) FROM orders o WHERE o.supplier_id = ? AND o.order_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)');
  if ($stmt) {
    $prevYear = 0;
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($prevYear);
    $stmt->fetch();
    $stmt->close();
    if ($prevYear > 0) {
      $growth = sprintf('%+.1f%%', (($totalRevenue - $prevYear) / max(1, $prevYear)) * 100);
    }
  }
}
?>

<div class="page-header">
  <div>
    <h1>Analitik Penjualan</h1>
    <p>Analisis mendalam performa penjualan dan tren produk Anda.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="label">Total Pendapatan</div>
    <div class="value"><?= format_idr($totalRevenue) ?></div>
    <div class="delta"><?= $growth ?> vs bln lalu</div>
  </div>
  <div class="stat-card">
    <div class="label">Produk Terlaris</div>
    <div class="value" style="font-size:19px;"><?= htmlspecialchars($topProducts[0]['name'] ?? 'Belum Ada') ?></div>
    <div class="delta" style="color:var(--text-muted);">Volume: <?= isset($topProducts[0]['quantity_sold']) ? number_format($topProducts[0]['quantity_sold']) . ' Unit' : '0 Unit' ?></div>
  </div>
  <div class="stat-card">
    <div class="label">Total Produk Terjual</div>
    <div class="value"><?= number_format($totalUnits) ?> unit</div>
    <div class="delta" style="color:var(--text-muted);">Target 92% tercapai</div>
  </div>
  <div class="stat-card">
    <div class="label">Pertumbuhan Penjualan</div>
    <div class="value"><?= $growth ?></div>
    <div class="delta">Signifikan</div>
  </div>
</div>

<div class="grid-2">
  <div class="panel">
    <div class="panel-head"><h3>Grafik Penjualan Bulanan</h3></div>
    <div class="chart-box"><canvas id="chartBulanan"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head"><h3>Distribusi Komoditas</h3></div>
    <div class="chart-box"><canvas id="chartDonut"></canvas></div>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;"><h3>Top 5 Produk Berdasarkan Volume</h3></div>
  <table>
    <thead><tr><th>Nama Produk</th><th>Kategori</th><th>Jumlah Terjual</th><th>Total Nominal</th><th>Tren</th></tr></thead>
    <tbody>
      <?php if (empty($topProducts)): ?>
        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">Belum ada data produk terjual.</td></tr>
      <?php else: ?>
        <?php foreach ($topProducts as $t): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($t['name']) ?></td>
            <td><?= htmlspecialchars($t['category']) ?></td>
            <td><?= number_format($t['quantity_sold']) ?> Unit</td>
            <td><b><?= format_idr($t['total_amount']) ?></b></td>
            <td><span class="<?= trend_class($t['trend']) ?>"><?= $t['trend'] === 'up' ? 'Trend Up' : ($t['trend'] === 'down' ? 'Trend Down' : 'Trend Flat') ?></span></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartBulanan'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($monthlyLabels ?: ['Jan','Feb','Mar','Apr','Mei','Jun']) ?>,
    datasets: [{ data: <?= json_encode($monthlyRevenue ?: [0,0,0,0,0,0]) ?>, backgroundColor:'#0f2a4a', borderRadius:6 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false},x:{grid:{display:false}}} }
});
new Chart(document.getElementById('chartDonut'), {
  type: 'doughnut',
  data: {
    labels: <?= json_encode(array_column($categoryShares ?: [['category_name'=>'Beras 45%'],['category_name'=>'Telur 25%'],['category_name'=>'Daging 20%'],['category_name'=>'Sayur 10%']], 'category_name')) ?>,
    datasets: [{ data: <?= json_encode(array_map(fn($row)=>(int)$row['total_amount'], $categoryShares ?: [['total_amount'=>45],['total_amount'=>25],['total_amount'=>20],['total_amount'=>10]])) ?>, backgroundColor:['#0f2a4a','#2563eb','#60a5fa','#bfdbfe'] }]
  },
  options: { plugins:{legend:{position:'bottom'}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
