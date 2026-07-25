<?php
require __DIR__ . '/config.php';
$pageTitle = "Jejak Audit";
$topbarTitle = "Monitoring Anggaran";
require __DIR__ . '/includes/header.php';
?>

<div class="page-head">
  <div>
    <h1>Jejak Audit</h1>
    <p>Log aktivitas sistem dan riwayat perubahan data untuk transparansi audit.</p>
  </div>
  <div class="page-head-actions">
    <button class="btn btn-outline"><i data-lucide="file-output"></i>Ekspor PDF</button>
    <button class="btn btn-primary"><i data-lucide="sliders-horizontal"></i>Filter Data</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Total Aktivitas</div>
    <div class="stat-value">42.5k</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Login Hari Ini</div>
    <div class="stat-value">128</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Perubahan Data</div>
    <div class="stat-value">45</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Peringatan Keamanan</div>
    <div class="stat-value">0</div>
  </div>
</div>

<div class="card" style="padding:0;">
  <div class="card-head-row" style="padding:22px 22px 0;">
    <div class="card-title">Log Aktivitas Terbaru</div>
    <span class="page-btn"><i data-lucide="refresh-cw"></i></span>
  </div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>Tanggal &amp; Waktu</th><th>Pengguna</th><th>Peran</th><th>Aktivitas</th><th>Alamat IP</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>24 Jul 2026, 14:20</td>
          <td class="cell-strong">Auditor Utama</td>
          <td>Auditor</td>
          <td>Melihat Laporan #REP-2026-07-01</td>
          <td>192.168.1.1</td>
          <td><?php echo badge('Berhasil','info'); ?></td>
        </tr>
        <tr>
          <td>24 Jul 2026, 14:15</td>
          <td class="cell-strong">Sistem AI</td>
          <td>System</td>
          <td>Sinkronisasi Data SPPG</td>
          <td>127.0.0.1</td>
          <td><?php echo badge('Berhasil','info'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
