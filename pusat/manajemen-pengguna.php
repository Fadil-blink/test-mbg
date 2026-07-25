<?php
require __DIR__ . '/config.php';
$pageTitle = "Manajemen Pengguna";
$topbarTitle = "Manajemen Pengguna";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Manajemen Pengguna</b></div>
<div class="page-head">
  <div><h1>Manajemen Pengguna</h1></div>
  <div class="page-head-actions">
    <button class="btn btn-outline"><i data-lucide="download"></i>Ekspor Data</button>
    <button class="btn btn-primary"><i data-lucide="user-plus"></i>Tambah Pengguna</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Total Pengguna</div>
    <div class="stat-value">156</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Admin Aktif</div>
    <div class="stat-value">12</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">Auditor</div>
    <div class="stat-value">45</div>
  </div>
  <div class="stat-card">
    <div class="stat-label" style="margin-bottom:10px;">User SPPG/Supplier</div>
    <div class="stat-value">99</div>
  </div>
</div>

<div class="card" style="padding:0;">
  <div style="padding:22px 22px 0;display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
    <div class="search-filter" style="max-width:340px;"><i data-lucide="search"></i><input placeholder="Cari nama atau email..."></div>
    <div style="margin-left:auto;display:flex;gap:10px;">
      <div class="dropdown">Semua Role<i data-lucide="chevron-down"></i></div>
      <div class="dropdown">Status: Aktif<i data-lucide="chevron-down"></i></div>
    </div>
  </div>
  <div style="height:18px;"></div>
  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Instansi</th><th>Status</th><th>Login Terakhir</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <tr>
          <td class="cell-strong">Budi Santoso</td>
          <td>budi.s@audit.go.id</td>
          <td>Auditor Pusat</td>
          <td>Pusat Audit Nasional</td>
          <td><?php echo badge('Aktif','info'); ?></td>
          <td>24 Jul 2026, 10:15</td>
          <td><span class="link-btn">Detail</span></td>
        </tr>
        <tr>
          <td class="cell-strong">Siti Aminah</td>
          <td>siti.a@wilayah.go.id</td>
          <td>Admin Wilayah</td>
          <td>Kantor Wilayah I</td>
          <td><?php echo badge('Aktif','info'); ?></td>
          <td>23 Jul 2026, 16:45</td>
          <td><span class="link-btn">Detail</span></td>
        </tr>
        <tr>
          <td class="cell-strong">Andi Wijaya</td>
          <td>andi.w@sppg-jaya.com</td>
          <td>Petugas SPPG</td>
          <td>PT SPPG Jaya Makmur</td>
          <td><?php echo badge('Aktif','info'); ?></td>
          <td>24 Jul 2026, 08:30</td>
          <td><span class="link-btn">Detail</span></td>
        </tr>
      </tbody>
    </table>
  </div>
  <div style="height:6px;"></div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
