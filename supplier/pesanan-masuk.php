<?php $page_title = 'Pesanan Masuk'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$orders = [];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function order_badge_class($status) {
  return match ($status) {
    'pending' => 'blue',
    'confirmed', 'processing' => 'blue',
    'shipped', 'dikirim', 'delivered' => 'green',
    'cancelled', 'rejected' => 'red',
    default => 'gray',
  };
}

function order_label($status) {
  return match ($status) {
    'pending' => 'Menunggu Konfirmasi',
    'confirmed', 'processing' => 'Diproses',
    'shipped', 'dikirim' => 'Dalam Perjalanan',
    'delivered' => 'Selesai',
    'cancelled' => 'Dibatalkan',
    'rejected' => 'Ditolak',
    default => ucfirst($status),
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT o.order_number, DATE_FORMAT(o.order_date, "%d %b %Y") AS order_date, COALESCE(s.name, "-") AS sppg_name, o.total_amount, o.order_status FROM orders o LEFT JOIN sppg s ON s.id = o.sppg_id WHERE o.supplier_id = ? ORDER BY o.order_date DESC LIMIT 20');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $orders[] = $row;
    }
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Pesanan Masuk</h1>
    <p>Kelola dan proses pesanan komoditas dari SPPG.</p>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Menunggu Konfirmasi</a>
  <a href="#">Diproses</a>
  <a href="#">Sedang Dikirim</a>
  <a href="#">Selesai</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Pesanan atau nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Pesanan</th><th>Nama SPPG</th><th>Tanggal</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($orders)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Belum ada pesanan masuk.</td></tr>
      <?php else: ?>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($order['order_number']) ?></td>
            <td><?= htmlspecialchars($order['sppg_name']) ?></td>
            <td><?= htmlspecialchars($order['order_date']) ?></td>
            <td><b><?= format_idr($order['total_amount']) ?></b></td>
            <td><span class="badge <?= order_badge_class($order['order_status']) ?>"><?= order_label($order['order_status']) ?></span></td>
            <td>
              <?php if ($order['order_status'] === 'pending'): ?>
                <button class="btn small">Terima</button> <button class="btn small outline">Tolak</button>
              <?php else: ?>
                <a href="#" class="cell-link">Detail</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
