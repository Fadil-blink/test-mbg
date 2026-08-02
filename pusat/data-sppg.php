<?php
require __DIR__ . '/config.php';

$search = trim($_GET['search'] ?? '');
$province = trim($_GET['province'] ?? '');
$city = trim($_GET['city'] ?? '');
$status = trim($_GET['status'] ?? '');

$statsStmt = $mysqli->prepare('SELECT COUNT(*) AS total, SUM(status = "aktif") AS active, SUM(status != "aktif") AS nonactive, SUM(budget_annual) AS budget_total FROM sppg');
$statsStmt->execute();
$statsResult = $statsStmt->get_result();
$stats = $statsResult->fetch_assoc() ?: ['total'=>0,'active'=>0,'nonactive'=>0,'budget_total'=>0];
$statsStmt->close();

$provinceResult = $mysqli->query('SELECT DISTINCT province FROM sppg WHERE province <> "" ORDER BY province');
$cityResult = $mysqli->query('SELECT DISTINCT city FROM sppg WHERE city <> "" ORDER BY city');
$statusOptions = ['' => 'Semua Status', 'aktif' => 'Aktif', 'inactive' => 'Nonaktif', 'suspended' => 'Ditangguhkan'];

$whereClauses = [];
$paramTypes = '';
$params = [];
if ($search !== '') {
    $whereClauses[] = '(name LIKE ? OR code LIKE ? OR pic_name LIKE ?)';
    $paramTypes .= 'sss';
    $searchTerm = "%${search}%";
    $params[] = &$searchTerm;
    $params[] = &$searchTerm;
    $params[] = &$searchTerm;
}
if ($province !== '') {
    $whereClauses[] = 'province = ?';
    $paramTypes .= 's';
    $params[] = &$province;
}
if ($city !== '') {
    $whereClauses[] = 'city = ?';
    $paramTypes .= 's';
    $params[] = &$city;
}
if ($status !== '') {
    $whereClauses[] = 'status = ?';
    $paramTypes .= 's';
    $params[] = &$status;
}

$sql = 'SELECT id, code, name, province, city, pic_name, budget_annual, is_verified, status FROM sppg';
if (!empty($whereClauses)) {
    $sql .= ' WHERE ' . implode(' AND ', $whereClauses);
}
$sql .= ' ORDER BY name LIMIT 200';
$stmt = $mysqli->prepare($sql);
if ($stmt) {
    if (!empty($paramTypes)) {
        bind_stmt_params($stmt, $paramTypes, $params);
    }
    $stmt->execute();
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $rows = [];
}

$pageTitle = "Data SPPG";
$topbarTitle = "Manajemen SPPG";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Data SPPG</b></div>
<div class="page-head">
  <div>
    <h1>Data SPPG</h1>
    <p>Manajemen data Satuan Pelayanan Pemenuhan Gizi (SPPG) seluruh wilayah Indonesia.</p>
  </div>
  <div class="page-head-actions">
    <a href="action.php?action=tambah-sppg" class="btn btn-primary"><i data-lucide="plus"></i>Tambah Unit SPPG</a>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="share-2"></i></div>
      <span class="stat-tag stat-tag-up" style="background:var(--green-bg);padding:3px 8px;border-radius:20px;">+12%</span>
    </div>
    <div class="stat-label-plain">Total SPPG</div>
    <div class="stat-value" style="margin-bottom:4px;"><?php echo escape($stats['total']); ?></div>
    <?php echo progress_bar($stats['total'] > 0 ? 100 : 0,'dark'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--blue-badge-bg);color:var(--blue-600);"><i data-lucide="check-circle-2"></i></div>
      <?php echo badge('Aktif','info'); ?>
    </div>
    <div class="stat-label-plain">SPPG Aktif</div>
    <div class="stat-value" style="margin-bottom:4px;"><?php echo escape($stats['active']); ?></div>
    <?php echo progress_bar($stats['total'] > 0 ? ($stats['active'] / $stats['total']) * 100 : 0,'blue'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:#fbeedd;color:#b9791b;"><i data-lucide="x-circle"></i></div>
      <?php echo badge('Siaga','warning'); ?>
    </div>
    <div class="stat-label-plain">SPPG Nonaktif</div>
    <div class="stat-value" style="margin-bottom:4px;"><?php echo escape($stats['nonactive']); ?></div>
    <?php echo progress_bar($stats['total'] > 0 ? ($stats['nonactive'] / $stats['total']) * 100 : 0,'red'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:#fbeedd;color:#b9791b;"><i data-lucide="wallet"></i></div>
      <span class="stat-tag" style="background:var(--gray-badge-bg);color:var(--gray-badge-text);padding:3px 8px;border-radius:20px;">YTD</span>
    </div>
    <div class="stat-label-plain">Anggaran Terdaftar</div>
    <div class="stat-value" style="margin-bottom:4px;"><?php echo formatRp($stats['budget_total']); ?></div>
    <?php echo progress_bar(45,'dark'); ?>
  </div>
</div>

<div class="card" style="padding:22px;margin-bottom:20px;">
  <form method="get" class="filter-toolbar" style="gap:10px;align-items:center;display:flex;flex-wrap:wrap;">
    <div class="search-filter" style="max-width:280px;"><i data-lucide="search"></i><input type="search" class="input" name="search" value="<?php echo escape($search); ?>" placeholder="Cari Nama SPPG..."></div>
    <div class="dropdown">
      <select name="province" style="background:transparent;border:none;width:100%;color:inherit;">
        <option value="">Semua Provinsi</option>
        <?php while ($row = $provinceResult->fetch_assoc()): ?>
          <option value="<?php echo escape($row['province']); ?>" <?php echo $province === $row['province'] ? 'selected' : ''; ?>><?php echo escape($row['province']); ?></option>
        <?php endwhile; ?>
      </select>
      <i data-lucide="chevron-down"></i>
    </div>
    <div class="dropdown">
      <select name="city" style="background:transparent;border:none;width:100%;color:inherit;">
        <option value="">Semua Kabupaten</option>
        <?php while ($row = $cityResult->fetch_assoc()): ?>
          <option value="<?php echo escape($row['city']); ?>" <?php echo $city === $row['city'] ? 'selected' : ''; ?>><?php echo escape($row['city']); ?></option>
        <?php endwhile; ?>
      </select>
      <i data-lucide="chevron-down"></i>
    </div>
    <div class="dropdown">
      <select name="status" style="background:transparent;border:none;width:100%;color:inherit;">
        <?php foreach ($statusOptions as $value => $label): ?>
          <option value="<?php echo escape($value); ?>" <?php echo $status === $value ? 'selected' : ''; ?>><?php echo escape($label); ?></option>
        <?php endforeach; ?>
      </select>
      <i data-lucide="chevron-down"></i>
    </div>
    <button type="submit" class="btn btn-primary">Terapkan</button>
    <a href="action.php?action=ekspor-sppg" class="btn btn-outline"><i data-lucide="download"></i>Export</a>
  </form>
</div>

<div class="card" style="padding:0;">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama SPPG</th><th>Lokasi</th><th>Penanggung Jawab</th><th>Penerima</th><th>Anggaran</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($rows)): ?>
          <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--text-500);">Data SPPG tidak ditemukan.</td></tr>
        <?php endif; ?>
        <?php foreach ($rows as $row): ?>
        <tr>
          <td><div class="cell-strong"><?php echo escape($row['name']); ?></div><div class="cell-sub">ID: <?php echo escape($row['code']); ?></div></td>
          <td><?php echo escape($row['province']); ?><div class="cell-sub"><?php echo escape($row['city']); ?></div></td>
          <td><?php echo escape($row['pic_name']); ?></td>
          <td><?php echo escape(number_format($row['budget_annual'] / 1000, 0, ',', '.')); ?></td>
          <td class="cell-money"><?php echo formatRp($row['budget_annual']); ?></td>
          <td><?php echo badge($row['status'] === 'aktif' ? 'Aktif' : ($row['status'] === 'inactive' ? 'Nonaktif' : 'Ditangguhkan'), $row['status'] === 'aktif' ? 'success' : 'warning'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="pagination-row" style="padding:16px 22px;">
    <span>Menampilkan <?php echo count($rows); ?> dari <?php echo escape($stats['total']); ?> SPPG</span>
    <div class="pagination">
      <span class="page-btn"><i data-lucide="chevron-left"></i></span>
      <span class="page-btn active">1</span>
      <span class="page-btn"><i data-lucide="chevron-right"></i></span>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
