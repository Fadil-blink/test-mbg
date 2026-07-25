<?php
require __DIR__ . '/config.php';
$pageTitle = "Data Supplier";
$topbarTitle = "Manajemen Supplier";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Manajemen Supplier</b></div>
<div class="page-head">
  <div>
    <h1>Kelola Basis Data Supplier</h1>
  </div>
  <div class="page-head-actions">
    <button class="btn btn-primary"><i data-lucide="user-plus"></i>Tambah Supplier Baru</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="users"></i></div>
      <span class="stat-tag stat-tag-up" style="background:var(--green-bg);padding:3px 8px;border-radius:20px;">+12%</span>
    </div>
    <div class="stat-label-plain">Total Supplier</div>
    <div class="stat-value">4.892</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="shield-check"></i></div>
    <div class="stat-label-plain">Supplier Terverifikasi</div>
    <div class="stat-value" style="color:var(--blue-600);">4.250</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#fbeedd;color:#b9791b;margin-bottom:10px;"><i data-lucide="clock"></i></div>
    <div class="stat-label-plain">Menunggu Verifikasi</div>
    <div class="stat-value">642</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="margin-bottom:10px;"><i data-lucide="landmark"></i></div>
    <div class="stat-label-plain">Total Volume Penjualan</div>
    <div class="stat-value">Rp 12.8T</div>
  </div>
</div>

<div class="card" style="padding:22px;">
  <div class="filter-toolbar" style="margin-bottom:0;">
    <span class="filter-label">Filter:</span>
    <div class="dropdown">Semua Jenis Supplier<i data-lucide="chevron-down"></i></div>
    <div class="dropdown">Semua Provinsi<i data-lucide="chevron-down"></i></div>
    <span class="link-btn" style="margin-left:auto;">Reset</span>
  </div>
</div>

<div class="card" style="padding:0;margin-top:20px;">
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>Nama Supplier</th><th>Jenis</th><th>Komoditas</th><th>Lokasi</th><th>Total Penjualan</th><th>Status</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <tr>
          <td style="display:flex;align-items:center;gap:10px;">
            <div class="avatar-circle" style="background:var(--blue-50);color:var(--blue-600);">UT</div>
            <span class="cell-strong">UMKM Tani Makmur</span>
          </td>
          <td><span class="chip chip-blue">UMKM</span></td>
          <td>Beras, Telur</td>
          <td>Surabaya, Jawa Timur</td>
          <td class="cell-money">Rp 4.2M</td>
          <td><?php echo badge('Terverifikasi','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="pagination-row" style="padding:16px 22px;">
    <span>Menampilkan 1-10 dari 4.892 supplier</span>
    <div class="pagination">
      <span class="page-btn"><i data-lucide="chevron-left"></i></span>
      <span class="page-btn active">1</span>
      <span class="page-btn"><i data-lucide="chevron-right"></i></span>
    </div>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
