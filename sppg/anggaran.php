<?php
$pageTitle = 'Monitoring Anggaran';
$active = 'anggaran';
include 'includes/header.php';

$orgId = $_SESSION['organization_id'] ?? null;
$where = [];
$params = [];
$types = '';
if ($orgId) {
  $where[] = 'b.sppg_id = ?';
  $types = 'i';
  $params[] = &$orgId;
}
$whereClause = '';
if (!empty($where)) {
  $whereClause = ' WHERE ' . implode(' AND ', $where);
}

function table_exists($mysqli, $table) {
  $result = $mysqli->query("SHOW TABLES LIKE '" . $mysqli->real_escape_string($table) . "'");
  return $result && $result->num_rows > 0;
}

$summary = ['total_budget'=>0,'used_amount'=>0,'remaining'=>0];
$alloc = [];
$transactions = [];

if (table_exists($mysqli, 'budget')) {
  $summarySql = 'SELECT COALESCE(SUM(total_budget),0) AS total_budget, COALESCE(SUM(used_amount),0) AS used_amount, COALESCE(SUM(remaining),0) AS remaining FROM budget' . $whereClause;
  $stmt = $mysqli->prepare($summarySql);
  if ($stmt) {
    if ($types !== '') {
      $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $summary = $stmt->get_result()->fetch_assoc() ?: $summary;
    $stmt->close();
  }

  $allocSql = 'SELECT allocation_type, COALESCE(SUM(total_budget),0) AS total FROM budget' . $whereClause . ' GROUP BY allocation_type';
  $stmt = $mysqli->prepare($allocSql);
  if ($stmt) {
    if ($types !== '') {
      $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $alloc = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
  }

  $transSql = 'SELECT DATE_FORMAT(b.created_at, "%d %b %Y") AS tanggal, CONCAT("Alokasi ", b.allocation_type) AS ket, b.notes AS kategori, b.total_budget AS nominal, "Selesai" AS status FROM budget b' . $whereClause . ' ORDER BY b.created_at DESC LIMIT 6';
  $stmt = $mysqli->prepare($transSql);
  if ($stmt) {
    if ($types !== '') {
      $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $transactions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
  }
}

function status_class($s){ return strtolower($s); }
?>
<div class="page-header-row">
  <div>
    <div class="breadcrumb"><a href="beranda.php">Beranda</a> &nbsp;&gt;&nbsp; <b>Monitoring Anggaran</b></div>
    <h1 class="page-title">Monitoring Anggaran</h1>
    <p class="page-sub">Pantau alokasi, realisasi, dan sisa anggaran SPPG secara real-time.</p>
  </div>
  <a href="notifikasi.php" class="btn btn-outline">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12"/><path d="M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
    Unduh Laporan
  </a>
</div>

<div class="stat-grid">
  <div class="stat-card"><div class="label">Total Anggaran</div><div class="value">Rp <?php echo number_format($summary['total_budget'],0,',','.'); ?></div></div>
  <div class="stat-card"><div class="label">Anggaran Terpakai</div><div class="value">Rp <?php echo number_format($summary['used_amount'],0,',','.'); ?></div><div class="progress-bar"><span style="width:<?php echo $summary['total_budget'] ? min(100, ($summary['used_amount'] / $summary['total_budget']) * 100) : 0; ?>%;"></span></div><div class="text-xs"><?php echo $summary['total_budget'] ? round(($summary['used_amount'] / $summary['total_budget']) * 100) : 0; ?>% Terpakai</div></div>
  <div class="stat-card"><div class="label">Sisa Anggaran</div><div class="value">Rp <?php echo number_format($summary['remaining'],0,',','.'); ?></div></div>
  <div class="stat-card"><div class="label">Persentase</div><div class="value"><?php echo $summary['total_budget'] ? round(($summary['used_amount'] / $summary['total_budget']) * 100) : 0; ?>%</div></div>
</div>

<div class="two-col">
  <div class="panel"><h3>Tren Penggunaan Anggaran Bulanan</h3><div class="bar-chart"><div class="bar-col"><div class="bar" style="height:32%;"></div><div class="bar-label">Jan</div></div><div class="bar-col"><div class="bar" style="height:38%;"></div><div class="bar-label">Feb</div></div><div class="bar-col"><div class="bar" style="height:46%;"></div><div class="bar-label">Mar</div></div><div class="bar-col"><div class="bar" style="height:42%;"></div><div class="bar-label">Apr</div></div><div class="bar-col"><div class="bar" style="height:56%;"></div><div class="bar-label">Mei</div></div><div class="bar-col"><div class="bar" style="height:50%;"></div><div class="bar-label">Jun</div></div></div></div>
  <div class="panel"><h3>Alokasi per Tipe</h3><?php foreach ($alloc as $a): ?><div class="alloc-row"><div class="alloc-top"><span><?php echo htmlspecialchars(ucfirst($a['allocation_type'])); ?></span> <b><?php echo round($summary['total_budget'] ? ($a['total'] / $summary['total_budget']) * 100 : 0); ?>%</b></div><div class="progress-bar"><span style="width:<?php echo $summary['total_budget'] ? ($a['total'] / $summary['total_budget']) * 100 : 0; ?>%;"></span></div></div><?php endforeach; ?></div>
</div>

<div class="panel"><div class="panel-head"><h3>Riwayat Transaksi Anggaran</h3><a href="#" class="seeall">Lihat Semua</a></div><div class="table-wrap" style="box-shadow:none;border:1px solid var(--border);"><table class="data-table"><thead><tr><th>Tanggal</th><th>Keterangan</th><th>Kategori</th><th>Nominal</th><th>Status</th></tr></thead><tbody><?php if (empty($transactions)): ?><tr><td colspan="5" style="text-align:center;padding:22px;color:var(--text-500);">Tidak ada data anggaran.</td></tr><?php endif; ?><?php foreach ($transactions as $t): ?><tr><td class="cell-muted"><?php echo htmlspecialchars($t['tanggal']); ?></td><td><?php echo htmlspecialchars($t['ket']); ?></td><td class="cell-muted"><?php echo htmlspecialchars($t['kategori']); ?></td><td class="cell-strong">Rp <?php echo number_format($t['nominal'],0,',','.'); ?></td><td><span class="status-pill <?php echo status_class($t['status']); ?>"><?php echo htmlspecialchars($t['status']); ?></span></td></tr><?php endforeach; ?></tbody></table></div></div>

<?php include 'includes/footer.php'; ?>
