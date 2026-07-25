<?php
require __DIR__ . '/config.php';
$pageTitle = "Data SPPG";
$topbarTitle = "PAN MBG Dashboard";
require __DIR__ . '/includes/header.php';
?>

<div class="breadcrumb">Beranda &rsaquo; <b>Data SPPG</b></div>
<div class="page-head">
  <div>
    <h1>Data SPPG</h1>
    <p>Manajemen data Satuan Pelayanan Pemenuhan Gizi (SPPG) seluruh wilayah Indonesia.</p>
  </div>
  <div class="page-head-actions">
    <button class="btn btn-primary"><i data-lucide="plus"></i>Tambah Unit SPPG</button>
  </div>
</div>

<div class="grid grid-4 mb-24">
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon"><i data-lucide="share-2"></i></div>
      <span class="stat-tag stat-tag-up" style="background:var(--green-bg);padding:3px 8px;border-radius:20px;">+12%</span>
    </div>
    <div class="stat-label-plain">Total SPPG</div>
    <div class="stat-value" style="margin-bottom:4px;">1.248</div>
    <?php echo progress_bar(80,'dark'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--blue-badge-bg);color:var(--blue-600);"><i data-lucide="check-circle-2"></i></div>
      <?php echo badge('Aktif','info'); ?>
    </div>
    <div class="stat-label-plain">SPPG Aktif</div>
    <div class="stat-value" style="margin-bottom:4px;">1.220</div>
    <?php echo progress_bar(92,'blue'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:var(--red-bg);color:var(--red-solid);"><i data-lucide="x-circle"></i></div>
      <?php echo badge('Siaga','warning'); ?>
    </div>
    <div class="stat-label-plain">SPPG Nonaktif</div>
    <div class="stat-value" style="margin-bottom:4px;">28</div>
    <?php echo progress_bar(8,'red'); ?>
  </div>
  <div class="stat-card">
    <div class="stat-top">
      <div class="stat-icon" style="background:#fbeedd;color:#b9791b;"><i data-lucide="wallet"></i></div>
      <span class="stat-tag" style="background:var(--gray-badge-bg);color:var(--gray-badge-text);padding:3px 8px;border-radius:20px;">YTD</span>
    </div>
    <div class="stat-label-plain">Anggaran Digunakan</div>
    <div class="stat-value" style="margin-bottom:4px;">Rp 4.2T</div>
    <?php echo progress_bar(45,'dark'); ?>
  </div>
</div>

<div class="card" style="padding:22px;">
  <div class="filter-toolbar" style="margin-bottom:18px;">
    <div class="search-filter" style="max-width:280px;"><i data-lucide="search"></i><input placeholder="Cari Nama SPPG..."></div>
    <div class="dropdown">Semua Provinsi<i data-lucide="chevron-down"></i></div>
    <div class="dropdown">Semua Kabupaten<i data-lucide="chevron-down"></i></div>
    <div class="dropdown">Status<i data-lucide="chevron-down"></i></div>
    <div style="margin-left:auto;display:flex;gap:10px;">
      <button class="btn btn-outline"><i data-lucide="sliders-horizontal"></i>Filter Lanjut</button>
      <button class="btn btn-outline"><i data-lucide="download"></i>Export</button>
    </div>
  </div>

  <div class="table-wrap">
    <table class="data-table">
      <thead>
        <tr>
          <th>Nama SPPG</th><th>Lokasi</th><th>Penanggung Jawab</th><th>Penerima</th><th>Anggaran</th><th>Realisasi</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><div class="cell-strong">SPPG Surabaya Barat</div><div class="cell-sub">ID: SPPG-JTM-001</div></td>
          <td>Jawa Timur<div class="cell-sub">Surabaya</div></td>
          <td>Dr. Ahmad Fauzi</td>
          <td>5.000</td>
          <td>Rp 500jt</td>
          <td class="cell-link">Rp 480jt</td>
          <td><?php echo badge('Aktif','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td><div class="cell-strong">SPPG Bandung Raya</div><div class="cell-sub">ID: SPPG-JBR-042</div></td>
          <td>Jawa Barat<div class="cell-sub">Bandung</div></td>
          <td>Siti Aminah</td>
          <td>3.500</td>
          <td>Rp 350jt</td>
          <td class="cell-link">Rp 320jt</td>
          <td><?php echo badge('Aktif','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td><div class="cell-strong">SPPG Medan Baru</div><div class="cell-sub">ID: SPPG-SU-112</div></td>
          <td>Sumatera Utara<div class="cell-sub">Medan</div></td>
          <td>Robert Siahaan</td>
          <td>4.200</td>
          <td>Rp 420jt</td>
          <td class="cell-link">Rp 410jt</td>
          <td><?php echo badge('Nonaktif','danger'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
        <tr>
          <td><div class="cell-strong">SPPG Makassar City</div><div class="cell-sub">ID: SPPG-SLS-089</div></td>
          <td>Sulawesi Selatan<div class="cell-sub">Makassar</div></td>
          <td>Andi Wijaya</td>
          <td>2.800</td>
          <td>Rp 280jt</td>
          <td class="cell-link">Rp 255jt</td>
          <td><?php echo badge('Aktif','success'); ?></td>
          <td><span class="action-eye"><i data-lucide="eye"></i></span></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="pagination-row">
    <span>Menampilkan 1-10 dari 1.248 SPPG</span>
    <div class="pagination">
      <span class="page-btn"><i data-lucide="chevron-left"></i></span>
      <span class="page-btn active">1</span>
      <span class="page-btn">2</span>
      <span class="page-btn">3</span>
      <span class="page-btn">...</span>
      <span class="page-btn">125</span>
      <span class="page-btn"><i data-lucide="chevron-right"></i></span>
    </div>
  </div>
</div>

<div class="alert-banner">
  <div class="alert-left">
    <div class="alert-icon"><i data-lucide="alert-triangle"></i></div>
    <div>
      <h4>Audit Alert: Anomali Data Realisasi</h4>
      <p>Sistem mendeteksi selisih realisasi anggaran &gt;15% pada 12 unit SPPG di wilayah Sumatera Utara. Diperlukan verifikasi lapangan segera.</p>
    </div>
  </div>
  <button class="btn btn-danger">Tinjau Sekarang</button>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
