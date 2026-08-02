<?php
$pageTitle = 'Invoice Digital';
$active = 'invoice';
include 'includes/header.php';

$orgId = $_SESSION['organization_id'] ?? null;
$where = [];
$params = [];
$types = '';
$sql = 'SELECT i.invoice_number, DATE_FORMAT(i.invoice_date, "%d %b %Y") AS invoice_date, COALESCE(s.name, "-") AS supplier, i.amount, i.status FROM invoices i LEFT JOIN orders o ON i.order_id = o.id LEFT JOIN suppliers s ON o.supplier_id = s.id';
if ($orgId) {
  $sql .= ' WHERE o.sppg_id = ?';
  $types = 'i';
  $params[] = &$orgId;
}
$sql .= ' ORDER BY i.invoice_date DESC LIMIT 20';
$stmt = $mysqli->prepare($sql);
$invoices = [];
if ($stmt) {
  if ($types !== '') {
    $stmt->bind_param($types, ...$params);
  }
  $stmt->execute();
  $invoices = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
}
function status_class($s){ $map = ['Lunas'=>'lunas','Menunggu Pembayaran'=>'menunggu','partial'=>'menunggu']; return $map[$s] ?? strtolower(str_replace(' ','-', $s)); }
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Invoice Digital</b></div>
    <h1 class="page-title">Invoice Digital</h1>
    <p class="page-sub">Kelola dan unduh dokumen tagihan resmi dari transaksi pengadaan komoditas.</p>
  </div>
</div>

<div class="kpi-grid">
  <div class="kpi-card"><div class="kpi-label">Total Tagihan Bulan Ini</div><div class="kpi-value">Rp <?php echo number_format(array_sum(array_column($invoices,'amount')),0,',','.'); ?></div><div class="kpi-note up">+12.4%</div></div>
  <div class="kpi-card"><div class="kpi-label">Tagihan Belum Dibayar</div><div class="kpi-value">Rp <?php echo number_format(array_reduce($invoices, fn($sum,$i)=> $sum + ($i['status'] !== 'Lunas' ? $i['amount'] : 0), 0),0,',','.'); ?></div><div class="kpi-note"><?php echo count(array_filter($invoices, fn($i)=> $i['status'] !== 'Lunas')); ?> invoice jatuh tempo</div></div>
  <div class="kpi-card"><div class="kpi-label">Tagihan Lunas</div><div class="kpi-value">Rp <?php echo number_format(array_reduce($invoices, fn($sum,$i)=> $sum + ($i['status'] === 'Lunas' ? $i['amount'] : 0), 0),0,',','.'); ?></div><div class="kpi-note">Tingkat kepatuhan 94%</div></div>
</div>

<div class="toolbar">
  <div class="search-input"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg><input type="text" placeholder="Cari nomor invoice atau supplier..."></div>
  <select disabled><option>Semua Status</option><option>Lunas</option><option>Menunggu Pembayaran</option></select>
  <select disabled><option>Bulan Ini</option></select>
  <a href="#" class="btn btn-outline"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg> Ekspor Semua (CSV)</a>
</div>

<div class="table-wrap">
  <table class="data-table">
    <thead><tr><th>Nomor Invoice</th><th>Tanggal</th><th>Supplier</th><th>Total Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
      <?php if (empty($invoices)): ?>
        <tr><td colspan="6" style="text-align:center;padding:22px;color:var(--text-500);">Tidak ada invoice.</td></tr>
      <?php endif; ?>
      <?php foreach ($invoices as $i): ?>
      <tr>
        <td class="cell-strong"><?php echo htmlspecialchars($i['invoice_number']); ?></td>
        <td class="cell-muted"><?php echo htmlspecialchars($i['invoice_date']); ?></td>
        <td><?php echo htmlspecialchars($i['supplier']); ?></td>
        <td class="cell-strong">Rp <?php echo number_format($i['amount'],0,',','.'); ?></td>
        <td><span class="status-pill <?php echo status_class($i['status']); ?>"><?php echo htmlspecialchars($i['status']); ?></span></td>
        <td><a href="#" class="cell-link">Detail</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="alert-banner red"><div class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.3 3.9L1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg></div><div><b>Peringatan Audit Fraud</b><p>Ditemukan beberapa invoice dengan nilai tagihan tinggi. Silakan tinjau ulang detail transaksi sebelum melakukan pembayaran.</p><a href="#" class="link">Tinjau Sekarang</a></div></div>

<?php include 'includes/footer.php'; ?>
