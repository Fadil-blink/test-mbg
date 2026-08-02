<?php $page_title = 'Pendapatan'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$totalRevenue = 0;
$monthRevenue = 0;
$completedOrders = 0;
$availableBalance = 0;
$recentTransactions = [];
$categoryRevenue = [];
$chartLabels = [];
$chartData = [];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function status_label($status) {
  return match ($status) {
    'pending' => 'Menunggu',
    'confirmed', 'processing' => 'Diproses',
    'shipped', 'dikirim' => 'Dalam Perjalanan',
    'delivered' => 'Berhasil',
    'cancelled' => 'Dibatalkan',
    default => ucfirst($status),
  };
}

function status_badge($status) {
  return match ($status) {
    'delivered' => 'green',
    'processing', 'confirmed' => 'blue',
    'shipped', 'dikirim' => 'blue',
    'pending' => 'amber',
    'cancelled' => 'red',
    default => 'gray',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalRevenue);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE supplier_id = ? AND MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($monthRevenue);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COUNT(*) FROM orders WHERE supplier_id = ? AND order_status = "delivered"');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($completedOrders);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(i.paid_amount),0) FROM invoices i JOIN orders o ON i.order_id = o.id WHERE o.supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($availableBalance);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT o.order_number, DATE_FORMAT(o.order_date, "%d %b %Y") AS order_date, COALESCE(s.name, "-") AS sppg_name, o.total_amount, o.order_status FROM orders o LEFT JOIN sppg s ON s.id = o.sppg_id WHERE o.supplier_id = ? ORDER BY o.order_date DESC LIMIT 3');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $recentTransactions[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT c.name AS category_name, COALESCE(SUM(oi.subtotal),0) AS total_amount FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN categories c ON p.category_id = c.id JOIN orders o ON o.id = oi.order_id WHERE o.supplier_id = ? GROUP BY c.id ORDER BY total_amount DESC LIMIT 3');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $categoryRevenue[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT DATE(order_date) AS order_day, COALESCE(SUM(total_amount),0) AS total_amount FROM orders WHERE supplier_id = ? AND order_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(order_date) ORDER BY DATE(order_date)');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    $dayData = [];
    while ($row = $res->fetch_assoc()) {
      $dayData[$row['order_day']] = $row['total_amount'];
    }
    $stmt->close();
    for ($i = 6; $i >= 0; $i--) {
      $date = date('Y-m-d', strtotime("-$i days"));
      $chartLabels[] = date('D', strtotime($date));
      $chartData[] = isset($dayData[$date]) ? (int)$dayData[$date] / 1000000 : 0;
    }
  }
}
?>

<div class="page-header">
  <div>
    <h1>Dashboard Pendapatan</h1>
    <p>Pantau performa keuangan dan rincian transaksi penjualan Anda.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Pendapatan</div><div class="value"><?= format_idr($totalRevenue) ?></div></div>
  <div class="stat-card"><div class="label">Pendapatan Bulan Ini <span class="badge green">+12%</span></div><div class="value"><?= format_idr($monthRevenue) ?></div></div>
  <div class="stat-card"><div class="label">Pesanan Selesai</div><div class="value"><?= $completedOrders ?> Pesanan</div></div>
  <div class="stat-card dark">
    <div class="label">Saldo Tersedia <span class="btn small" style="background:rgba(255,255,255,.15);">Tarik Dana</span></div>
    <div class="value"><?= format_idr($availableBalance) ?></div>
  </div>
</div>

<div class="grid-2">
  <div class="panel">
    <div class="panel-head">
      <h3>Grafik Pendapatan 7 Hari Terakhir</h3>
      <span class="select-fake">Minggu Ini <i class="fa-solid fa-chevron-down"></i></span>
    </div>
    <div class="chart-box"><canvas id="chartPendapatan"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head"><h3>Ringkasan Penjualan</h3></div>
    <?php foreach ($categoryRevenue as $row): ?>
      <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid var(--border);"><span><?= htmlspecialchars($row['category_name']) ?></span><b><?= format_idr($row['total_amount']) ?></b></div>
    <?php endforeach; ?>
    <?php if (empty($categoryRevenue)): ?>
      <div style="padding:16px;color:var(--text-muted);">Belum ada data penjualan kategori.</div>
    <?php endif; ?>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;">
    <h3>Transaksi Terakhir</h3>
    <a href="#" class="link">Lihat Semua</a>
  </div>
  <table>
    <thead><tr><th>ID Transaksi</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Nominal</th><th>Status</th></tr></thead>
    <tbody>
      <?php if (empty($recentTransactions)): ?>
        <tr><td colspan="5" style="text-align:center;color:var(--text-muted);">Belum ada transaksi.</td></tr>
      <?php else: ?>
        <?php foreach ($recentTransactions as $row): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($row['order_number']) ?></td>
            <td><?= htmlspecialchars($row['order_date']) ?></td>
            <td><?= htmlspecialchars($row['sppg_name']) ?></td>
            <td><b><?= format_idr($row['total_amount']) ?></b></td>
            <td><span class="badge <?= status_badge($row['order_status']) ?>"><?= status_label($row['order_status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartPendapatan'), {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{ data: <?= json_encode($chartData) ?>, borderColor:'#0f2a4a', backgroundColor:'rgba(15,42,74,0.08)', fill:true, tension:0.4, pointRadius:3 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:v=>'Rp '+v+'jt'}},x:{grid:{display:false}}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
