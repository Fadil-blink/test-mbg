<?php $page_title = 'Beranda'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$today = date('Y-m-d');
$ordersToday = 0;
$monthRevenue = 0;
$totalProducts = 0;
$activeProducts = 0;
$distinctSppg = 0;
$needsConfirmation = 0;
$chartLabels = [];
$chartRevenue = [];
$chartVolume = [];
$recentOrders = [];
$notifs = [];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function order_badge($status) {
  return match ($status) {
    'pending', 'confirmed' => 'blue',
    'processing' => 'blue',
    'shipped', 'dikirim', 'delivered' => 'green',
    'cancelled', 'rejected' => 'red',
    default => 'gray',
  };
}

function order_label($status) {
  return match ($status) {
    'pending' => 'Menunggu Konfirmasi',
    'confirmed', 'processing' => 'Diproses',
    'shipped', 'dikirim' => 'Sedang Dikirim',
    'delivered' => 'Selesai',
    'cancelled' => 'Dibatalkan',
    'rejected' => 'Ditolak',
    default => ucfirst($status),
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT COUNT(*) AS cnt FROM orders WHERE supplier_id = ? AND DATE(order_date) = ?');
  if ($stmt) {
    $stmt->bind_param('is', $supplierId, $today);
    $stmt->execute();
    $stmt->bind_result($ordersToday);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(total_amount),0) AS revenue, COUNT(DISTINCT sppg_id) AS distinct_sppg, SUM(CASE WHEN order_status IN ("pending","confirmed") THEN 1 ELSE 0 END) AS needs_confirmation FROM orders WHERE supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($allRevenue, $distinctSppg, $needsConfirmation);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COUNT(*) AS total, SUM(CASE WHEN is_active THEN 1 ELSE 0 END) AS active FROM products WHERE supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($totalProducts, $activeProducts);
    $stmt->fetch();
    $stmt->close();
  }
  $inactiveProducts = max(0, $totalProducts - $activeProducts);

  $stmt = $mysqli->prepare('SELECT COALESCE(SUM(total_amount),0) AS revenue FROM orders WHERE supplier_id = ? AND MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($monthRevenue);
    $stmt->fetch();
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT o.order_number, COALESCE(s.name, "-") AS sppg_name, GROUP_CONCAT(CONCAT(oi.quantity, " ", p.unit, " ", p.name) SEPARATOR ", ") AS products, o.total_amount, o.order_status FROM orders o LEFT JOIN sppg s ON s.id = o.sppg_id LEFT JOIN order_items oi ON oi.order_id = o.id LEFT JOIN products p ON p.id = oi.product_id WHERE o.supplier_id = ? GROUP BY o.id ORDER BY o.order_date DESC LIMIT 4');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $recentOrders[] = $row;
    }
    $stmt->close();
  }

  $notifs = [];
  try {
    $stmt = $mysqli->prepare('SELECT n.title, n.message, n.type, n.is_read, DATE_FORMAT(n.created_at, "%d %b %Y %H:%i") AS created_at FROM notifications n WHERE n.user_id = ? ORDER BY n.created_at DESC LIMIT 5');
  } catch (mysqli_sql_exception $e) {
    $stmt = false;
  }

  if ($stmt) {
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $notifs[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT DATE(order_date) AS order_day, COALESCE(SUM(total_amount),0) AS total_amount, COUNT(*) AS count_orders FROM orders WHERE supplier_id = ? AND order_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) GROUP BY DATE(order_date) ORDER BY DATE(order_date)');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    $days = [];
    while ($row = $res->fetch_assoc()) {
      $days[$row['order_day']] = $row;
    }
    $stmt->close();
    for ($i = 6; $i >= 0; $i--) {
      $date = date('Y-m-d', strtotime("-$i days"));
      $chartLabels[] = date('D', strtotime($date));
      $chartRevenue[] = isset($days[$date]) ? (int)$days[$date]['total_amount'] / 1000000 : 0;
      $chartVolume[] = isset($days[$date]) ? (int)$days[$date]['count_orders'] : 0;
    }
  }
}
?>

<div class="page-header">
  <div>
    <h1>Ringkasan Operasional</h1>
    <p>Selamat datang kembali, <?= htmlspecialchars($supplier['name'] ?? 'Supplier') ?>. Berikut performa hari ini.</p>
  </div>
  <button class="btn"><i class="fa-solid fa-plus"></i> Tambah Produk</button>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="label">Pesanan Hari Ini <i class="fa-regular fa-calendar"></i></div>
    <div class="value"><?= $ordersToday ?></div>
  </div>
  <div class="stat-card">
    <div class="label">Pendapatan Bulan Ini <i class="fa-solid fa-money-check-alt"></i></div>
    <div class="value"><?= format_idr($monthRevenue) ?></div>
    <div class="delta"><i class="fa-solid fa-arrow-trend-up"></i> <?= $totalProducts > 0 ? '+15% dari bln lalu' : 'Belum ada transaksi' ?></div>
  </div>
  <div class="stat-card">
    <div class="label">Produk Aktif <i class="fa-solid fa-box-archive"></i></div>
    <div class="value"><?= $activeProducts ?></div>
  </div>
  <div class="stat-card">
    <div class="label">SPPG Dilayani <i class="fa-solid fa-diagram-project"></i></div>
    <div class="value"><?= $distinctSppg ?> Unit</div>
  </div>
  <div class="stat-card warn">
    <div class="label">Butuh Konfirmasi <i class="fa-solid fa-triangle-exclamation"></i></div>
    <div class="value"><?= $needsConfirmation ?></div>
  </div>
</div>

<div class="grid-3">
  <div class="panel">
    <div class="panel-head">
      <h3>Tren Pendapatan</h3>
      <span class="select-fake">7 Hari Terakhir <i class="fa-solid fa-chevron-down"></i></span>
    </div>
    <div class="chart-box"><canvas id="chartTren"></canvas></div>
  </div>
  <div class="panel">
    <div class="panel-head">
      <h3>Volume Pesanan</h3>
      <i class="fa-regular fa-circle-question"></i>
    </div>
    <div class="chart-box"><canvas id="chartVolume"></canvas></div>
    <p style="text-align:center;color:var(--text-muted);font-size:13.5px;margin-top:8px;">Total: <?= array_sum($chartVolume) ?> pesanan terselesaikan</p>
  </div>
  <div class="panel">
    <div class="panel-head">
      <h3>Notifikasi Terbaru</h3>
      <a href="notifikasi.php" class="link">Lihat Semua</a>
    </div>
    <?php if (empty($notifs)): ?>
      <div style="padding:16px 0;color:var(--text-muted);">Tidak ada notifikasi terbaru.</div>
    <?php endif; ?>
    <?php foreach ($notifs as $notif): ?>
      <?php
        $icon = match ($notif['type']) {
          'shipment' => 'fa-truck',
          'payment' => 'fa-money-check-alt',
          'alert' => 'fa-triangle-exclamation',
          default => 'fa-circle-info',
        };
        $color = $notif['is_read'] ? '#b0b7c3' : '#0f2a4a';
      ?>
      <div style="display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
        <div class="notif-icon" style="background:#eef2f7;color:<?= $color ?>;"><i class="fa-solid <?= $icon ?>"></i></div>
        <div>
          <div style="font-size:13.5px;font-weight:600;color:var(--navy);"><?= htmlspecialchars($notif['title']) ?></div>
          <div style="font-size:12.5px;color:var(--text-muted);"><?= htmlspecialchars($notif['created_at']) ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="table-wrap">
  <div class="panel-head" style="padding:20px 22px 0 22px;">
    <h3>Pesanan Terbaru</h3>
    <div style="display:flex;gap:10px;">
      <button class="btn outline small"><i class="fa-solid fa-download"></i> Unduh Laporan (CSV)</button>
      <button class="btn small">Lihat Semua</button>
    </div>
  </div>
  <table>
    <thead>
      <tr><th>ID Pesanan</th><th>Nama SPPG</th><th>Komoditas</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php if (empty($recentOrders)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Belum ada pesanan.</td></tr>
      <?php else: ?>
        <?php foreach ($recentOrders as $order): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($order['order_number']) ?></td>
            <td><?= htmlspecialchars($order['sppg_name']) ?></td>
            <td><?= htmlspecialchars($order['products']) ?></td>
            <td><b><?= format_idr($order['total_amount']) ?></b></td>
            <td><span class="badge <?= order_badge($order['order_status']) ?>"><?= order_label($order['order_status']) ?></span></td>
            <td class="link">Detail</td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
new Chart(document.getElementById('chartTren'), {
  type: 'bar',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{ data: <?= json_encode($chartRevenue) ?>, backgroundColor: '#0f2a4a', borderRadius: 6, barThickness: 26 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false,beginAtZero:true},x:{grid:{display:false}}} }
});
new Chart(document.getElementById('chartVolume'), {
  type: 'line',
  data: {
    labels: <?= json_encode($chartLabels) ?>,
    datasets: [{ data: <?= json_encode($chartVolume) ?>, borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,0.08)', fill:true, tension:0.4, pointRadius:0 }]
  },
  options: { plugins:{legend:{display:false}}, scales:{y:{display:false},x:{display:false}} }
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
