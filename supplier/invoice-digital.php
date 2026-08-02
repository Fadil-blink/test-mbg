<?php $page_title = 'Invoice Digital'; include __DIR__ . '/includes/header.php'; ?>

<?php
$supplierId = $supplier['id'] ?? null;
$invoices = [];
$stats = ['total' => 0, 'pending' => 0, 'paid' => 0, 'overdue' => 0, 'amount' => 0];

function format_idr($amount) {
  return 'Rp ' . number_format((int)$amount, 0, ',', '.');
}

function invoice_badge($status) {
  return match ($status) {
    'paid' => 'green',
    'sent', 'partial' => 'blue',
    'overdue' => 'red',
    'draft', 'cancelled' => 'gray',
    default => 'gray',
  };
}

function invoice_label($status) {
  return match ($status) {
    'paid' => 'Dibayar',
    'sent' => 'Terkirim',
    'partial' => 'Sebagian',
    'overdue' => 'Terlambat',
    'draft' => 'Draft',
    'cancelled' => 'Dibatalkan',
    default => ucfirst($status),
  };
}

if ($supplierId) {
  $stmt = $mysqli->prepare('SELECT i.invoice_number, DATE_FORMAT(i.invoice_date, "%d %b %Y") AS invoice_date, COALESCE(s.name, "-") AS sppg_name, i.amount, i.status FROM invoices i JOIN orders o ON i.order_id = o.id JOIN sppg s ON o.sppg_id = s.id WHERE o.supplier_id = ? ORDER BY i.invoice_date DESC LIMIT 20');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
      $invoices[] = $row;
    }
    $stmt->close();
  }

  $stmt = $mysqli->prepare('SELECT COUNT(*) AS total, SUM(CASE WHEN i.status IN ("draft","sent","partial") THEN 1 ELSE 0 END) AS pending, SUM(i.status = "paid") AS paid, SUM(i.status = "overdue") AS overdue, COALESCE(SUM(i.amount),0) AS amount FROM invoices i JOIN orders o ON i.order_id = o.id WHERE o.supplier_id = ?');
  if ($stmt) {
    $stmt->bind_param('i', $supplierId);
    $stmt->execute();
    $stmt->bind_result($stats['total'], $stats['pending'], $stats['paid'], $stats['overdue'], $stats['amount']);
    $stmt->fetch();
    $stmt->close();
  }
}
?>

<div class="page-header">
  <div>
    <h1>Invoice Digital</h1>
    <p>Kelola dan unduh invoice penagihan Anda untuk setiap transaksi.</p>
  </div>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Invoice</div><div class="value"><?= $stats['total'] ?></div></div>
  <div class="stat-card"><div class="label">Menunggu Pembayaran</div><div class="value"><?= $stats['pending'] ?></div></div>
  <div class="stat-card"><div class="label">Sudah Dibayar</div><div class="value"><?= $stats['paid'] ?></div></div>
  <div class="stat-card"><div class="label">Total Tagihan</div><div class="value"><?= format_idr($stats['amount']) ?></div></div>
</div>

<div class="toolbar">
  <div class="search-input"><i class="fa-solid fa-magnifying-glass"></i><input type="text" placeholder="Cari ID Invoice atau Nama SPPG..."></div>
  <span class="date-fake"><i class="fa-regular fa-calendar"></i> mm/dd/yyyy</span>
</div>
<div class="tabs pill">
  <a href="#" class="active">Semua</a>
  <a href="#">Belum Bayar</a>
  <a href="#">Dibayar</a>
  <a href="#">Terlambat</a>
</div>

<div class="table-wrap">
  <table>
    <thead><tr><th>ID Invoice</th><th>Tanggal</th><th>SPPG Tujuan</th><th>Total Nominal</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($invoices)): ?>
        <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Tidak ada invoice.</td></tr>
      <?php else: ?>
        <?php foreach ($invoices as $inv): ?>
          <tr>
            <td class="link"><?= htmlspecialchars($inv['invoice_number']) ?></td>
            <td><?= htmlspecialchars($inv['invoice_date']) ?></td>
            <td><?= htmlspecialchars($inv['sppg_name']) ?></td>
            <td><b><?= format_idr($inv['amount']) ?></b></td>
            <td><span class="badge <?= invoice_badge($inv['status']) ?>"><?= invoice_label($inv['status']) ?></span></td>
            <td><i class="fa-regular fa-eye" style="color:var(--blue);margin-right:14px;"></i><i class="fa-solid fa-download" style="color:var(--blue);"></i></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <div class="pagination">
    <div>Menampilkan 1-<?= min(10, max(0, count($invoices))) ?> dari <?= count($invoices) ?> invoice</div>
    <div class="pages">
      <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
      <a href="#" class="active">1</a>
      <a href="#">2</a>
      <a href="#">3</a>
      <a href="#"><i class="fa-solid fa-chevron-right"></i></a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
