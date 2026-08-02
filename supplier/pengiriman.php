<?php $page_title = 'Pengiriman'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$shipments = [];

function shipment_method_label($method) {
  return match ($method) {
    'internal_courier' => 'Kurir Internal',
    'jne' => 'JNE',
    'jnt' => 'J&T',
    'tiki' => 'TIKI',
    'pos' => 'POS',
    default => 'Custom',
  };
}

function shipment_badge($status) {
  return match ($status) {
    'dikemas', 'pending' => 'gray',
    'dikirim', 'dalam_transit' => 'blue',
    'tiba', 'diterima' => 'green',
    'gagal' => 'red',
    default => 'gray',
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT sh.shipment_number, o.order_number, COALESCE(s.name, "-") AS destination, sh.shipping_method, DATE_FORMAT(sh.expected_delivery_date, "%d %b %Y") AS eta, sh.status FROM shipments sh JOIN orders o ON sh.order_id = o.id LEFT JOIN sppg s ON o.sppg_id = s.id WHERE o.supplier_id = ? ORDER BY sh.shipment_date DESC LIMIT 20');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $shipments[] = $row;
    }
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Manajemen Pengiriman</h1>
    <p>Pantau dan kelola status pengiriman komoditas ke SPPG.</p>
  </div>
</div>

<div class="tabs">
  <a href="#" class="active">Semua</a>
  <a href="#">Sedang Dikemas</a>
  <a href="#">Dalam Perjalanan</a>
  <a href="#">Tiba di Lokasi</a>
  <a href="#">Selesai</a>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Pengiriman atau nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> Pilih Tanggal</span>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Pengiriman</th><th>ID Pesanan</th><th>Tujuan</th><th>Metode</th><th>Estimasi Tiba</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($shipments)): ?>
        <tr><td colspan="7" style="text-align:center;color:var(--text-muted);">Belum ada data pengiriman.</td></tr>
      <?php else: ?>
        <?php foreach ($shipments as $row): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($row['shipment_number']) ?></td>
            <td class="link"><?= htmlspecialchars($row['order_number']) ?></td>
            <td><?= htmlspecialchars($row['destination']) ?></td>
            <td><?= shipment_method_label($row['shipping_method']) ?></td>
            <td><?= htmlspecialchars($row['eta']) ?></td>
            <td><span class="badge <?= shipment_badge($row['status']) ?>"><?= ucfirst(str_replace('_', ' ', $row['status'])) ?></span></td>
            <td><a href="#" class="cell-link">Lacak</a></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
