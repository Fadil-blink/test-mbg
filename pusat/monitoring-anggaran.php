<?php
require __DIR__ . '/config.php';
$pageTitle = "Monitoring Anggaran";
$topbarTitle = "Monitoring Anggaran";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Monitoring Anggaran</b></div>
<div class="page-head">
  <div><h1>Dashboard Anggaran Nasional</h1></div>
  <div class="page-head-actions">
    <button class="btn btn-primary"><i data-lucide="file-plus-2"></i>Buat Alokasi Baru</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="landmark"></i></div>
    <div class="stat-label-plain">Total Anggaran</div>
    <div class="stat-value">Rp 12.5T</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="wallet"></i></div>
    <div class="stat-label-plain">Anggaran Terpakai</div>
    <div class="stat-value" style="color:var(--blue-600);">Rp 4.2T</div>
    <div class="cell-sub" style="margin-top:4px;color:var(--blue-600);">33.6% dari total</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fbeedd;color:#b9791b;margin-bottom:10px;"><i data-lucide="piggy-bank"></i></div>
    <div class="stat-label-plain">Sisa Anggaran</div>
    <div class="stat-value">Rp 8.3T</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="trending-up"></i></div>
    <div class="stat-label-plain">Realisasi Rata-rata</div>
    <div class="stat-value">92%</div>
  </div>
</div>

<div class="filter-toolbar">
  <span class="filter-label"><i data-lucide="sliders-horizontal" style="width:15px;height:15px;vertical-align:-2px;"></i> Filter:</span>
  <div class="dropdown">July 2026<i data-lucide="chevron-down"></i></div>
  <div class="dropdown">Semua Provinsi<i data-lucide="chevron-down"></i></div>
  <div class="dropdown">Semua Kabupaten<i data-lucide="chevron-down"></i></div>
  <div class="dropdown">Semua Status<i data-lucide="chevron-down"></i></div>
  <span class="link-btn" style="margin-left:auto;">Reset</span>
</div>

<div class="card" style="padding:0;margin-top:20px;">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>ID Anggaran</th><th>Nama Unit (SPPG)</th><th>Alokasi</th><th>Realisasi</th><th>Sisa</th><th>Persentase</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">#BUD-001</td>
          <td>SPPG Surabaya Barat</td>
          <td>Rp 500jt</td>
          <td>Rp 480jt</td>
          <td>Rp 20jt</td>
          <td>96%</td>
          <td><?php echo badge('Sesuai','success'); ?></td>
        </tr>
        <tr>
          <td class="cell-strong">#BUD-002</td>
          <td>SPPG Bandung Raya</td>
          <td>Rp 350jt</td>
          <td>Rp 320jt</td>
          <td>Rp 30jt</td>
          <td>91%</td>
          <td><?php echo badge('Sesuai','success'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="pagination-row" style="padding:16px 22px;">
    <span>Menampilkan 1-10 dari 450 unit</span>
    <div class="pagination">
      <span class="page-btn"><i data-lucide="chevron-left"></i></span>
      <span class="page-btn active">1</span>
      <span class="page-btn"><i data-lucide="chevron-right"></i></span>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
